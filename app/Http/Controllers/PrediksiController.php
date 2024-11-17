<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Obat;
use App\Models\Prediksi;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PrediksiController extends Controller
{
    public function index()
    {
        $data = [
            'drugs' => Obat::all(),
            'prediksiData' => [],
            'prediksi' => ''
        ];
        return view('admin.prediksi.train', $data);
    }

    public function showPrediction()
    {
        $data = [
            'drugs' => Obat::all(),
            'prediksiData' => [],
            'prediksi' => ''
        ];
        return view('admin.prediksi.index', $data);
    }

    private function findOptimalParameters($allData)
    {
        $bestAlpha = 0;
        $bestBeta = 0;
        $bestMape = PHP_FLOAT_MAX;
        
        // Grid search dengan memastikan alpha + beta = 1
        for ($alpha = 0.01; $alpha <= 0.99; $alpha += 0.01) {
            $beta = round(1 - $alpha, 2); // Memastikan alpha + beta = 1
            
            $prediksiData = $this->processPrediction($allData, $alpha, $beta);
            
            // Hitung MAPE untuk data 2023
            $totalApe = 0;
            $count = 0;
            $data2023 = array_slice($prediksiData, -12);
            
            foreach ($data2023 as $data) {
                if ($data['aktual_y'] > 0) {
                    $count++;
                    if ($data['ap'] !== null) {
                        $totalApe += $data['ap'];
                    }
                }
            }
            
            $mape = $count > 0 ? $totalApe / $count : PHP_FLOAT_MAX;
            
            if ($mape < $bestMape) {
                $bestMape = $mape;
                $bestAlpha = $alpha;
                $bestBeta = $beta;
            }
        }
        
        return [
            'alpha' => $bestAlpha,
            'beta' => $bestBeta,
            'mape' => $bestMape
        ];
    }

    public function predict(Request $request)
    {
        try {
            $request->validate([
                'obat_id' => 'required|exists:obats,id',
                'parameter_mode' => 'required|in:manual,auto',
                'alpha' => 'required_if:parameter_mode,manual|numeric|between:0,1',
                'beta' => 'required_if:parameter_mode,manual|numeric|between:0,1',
            ]);

            // Validasi jumlah alpha + beta = 1 untuk mode manual
            if ($request->parameter_mode === 'manual') {
                $sumParams = $request->alpha + $request->beta;
                if (round($sumParams, 2) !== 1.00) {
                    return redirect()
                        ->route('train.index')
                        ->with('error', 'Jumlah parameter Alpha dan Beta harus sama dengan 1');
                }
            }

            $obat = Obat::findOrFail($request->obat_id);
            
            $allData = Penjualan::where('obat_id', $request->obat_id)
                ->whereYear('tanggal', '>=', '2021')
                ->whereYear('tanggal', '<=', '2023')
                ->orderBy('tanggal')
                ->get()
                ->groupBy(function($item) {
                    return Carbon::parse($item->tanggal)->format('Y-m');
                })
                ->map(function($group) {
                    return $group->sum('jumlah');
                })
                ->values()
                ->toArray();

            if (count($allData) < 2) {
                return redirect()
                    ->route('train.index')
                    ->with('error', 'Data penjualan tidak cukup untuk melakukan prediksi');
            }

            // Tentukan parameter berdasarkan mode
            if ($request->parameter_mode === 'auto') {
                $optimalParams = $this->findOptimalParameters($allData);
                $alpha = $optimalParams['alpha'];
                $beta = $optimalParams['beta'];
            } else {
                $alpha = $request->alpha;
                $beta = $request->beta;
            }

            $prediksiData = $this->processPrediction($allData, $alpha, $beta);
            
            // Hitung MAPE untuk data 2023
            $totalApe = 0;
            $count = 0;
            $data2023 = array_slice($prediksiData, -12);
            
            foreach ($data2023 as $data) {
                if ($data['aktual_y'] > 0 && $data['ap'] !== null) {
                    $count++;
                    $totalApe += $data['ap'];
                }
            }

            $mape = $count > 0 ? $totalApe / $count : 0;

            // Simpan hasil prediksi
            $lastPrediction = end($prediksiData);
            Prediksi::create([
                'obat_id' => $request->obat_id,
                'periode' => now()->addMonth(),
                'alpha' => $alpha,
                'beta' => $beta,
                'hasil_prediksi' => $lastPrediction['prediksi_f'],
                'nilai_mape' => $mape,
                'is_auto_parameter' => $request->parameter_mode === 'auto'
            ]);
            // Simpan data ke session
        session([
            'prediksiData' => $prediksiData,
            'prediksi' => $obat->nama_obat,
            'mape' => $mape,
            'totalApe' => $totalApe,
            'count' => $count,
            'alpha' => $alpha,
            'beta' => $beta,
            'is_auto_parameter' => $request->parameter_mode === 'auto'
        ]);
            return view('admin.prediksi.index', [
                'drugs' => Obat::all(),
                'prediksiData' => $prediksiData,
                'prediksi' => $obat->nama_obat,
                'mape' => $mape,
                'totalApe' => $totalApe,
                'count' => $count,
                'alpha' => $alpha,
                'beta' => $beta,
                'is_auto_parameter' => $request->parameter_mode === 'auto'
            ]);

        } catch (\Exception $e) {
            return redirect()
                ->route('train.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function processPrediction($allData, $alpha, $beta)
    {
        $result = [];
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        $n = count($allData);
        $L = array_fill(0, $n, 0.0);
        $T = array_fill(0, $n, 0.0);
        $F = array_fill(0, $n, 0.0);

        $L[0] = $allData[0];
        $T[0] = isset($allData[1]) ? $allData[1] - $allData[0] : 0;

        for ($i = 1; $i < $n; $i++) {
            $tahun = (int)(2021 + floor($i / 12));
            $bulanIndex = $i % 12;

            if ($i < $n - 12) { // Data 2021-2022
                $L[$i] = $alpha * $allData[$i] + 
                         (1 - $alpha) * ($L[$i-1] + $T[$i-1]);
                $T[$i] = $beta * ($L[$i] - $L[$i-1]) + 
                         (1 - $beta) * $T[$i-1];
                $F[$i] = $L[$i] + $T[$i];
            } else { // Data 2023
                $F[$i] = $L[$i-1] + $T[$i-1];
                $L[$i] = $alpha * $F[$i] + 
                         (1 - $alpha) * ($L[$i-1] + $T[$i-1]);
                $T[$i] = $beta * ($L[$i] - $L[$i-1]) + 
                         (1 - $beta) * $T[$i-1];
                $F[$i] = $L[$i] + $T[$i];
            }

            // Hitung APE
            $ape = null;
            if ($allData[$i] > 0) {
                $ape = abs(($allData[$i] - $F[$i]) / $allData[$i]) * 100;
            }

            $result[] = [
                'bulan' => $bulan[$bulanIndex] . ' ' . $tahun,
                'tahun' => (string)$tahun,
                'aktual_y' => $allData[$i],
                'level' => round($L[$i], 2),
                'trend' => round($T[$i], 2),
                'prediksi_f' => round($F[$i], 2),
                'ap' => $ape !== null ? round($ape, 2) : null
            ];
        }

        return $result;
    }
    public function downloadPDF($type)
{
    try {
        // Cek apakah data tersedia di session
        if (!session()->has('prediksiData') || !session()->has('prediksi')) {
            return redirect()
                ->back()
                ->with('error', 'Data prediksi tidak ditemukan. Silakan lakukan prediksi terlebih dahulu.');
        }

        // Ambil data dari session
        $data = [
            'prediksiData' => session('prediksiData'),
            'prediksi' => session('prediksi'),
            'mape' => session('mape'),
            'totalApe' => session('totalApe'),
            'count' => session('count'),
            'alpha' => session('alpha'),
            'beta' => session('beta'),
            'is_auto_parameter' => session('is_auto_parameter'),
            'type' => $type
        ];

        // Generate PDF
        $pdf = PDF::loadView('admin.prediksi.pdf', $data);
        
        // Set paper size dan orientation
        $pdf->setPaper('a4', 'landscape');
        
        // Generate filename
        $filename = sprintf(
            '%s-%s-%s.pdf',
            $type,
            Str::slug(session('prediksi')), // Gunakan Str::slug() sebagai pengganti str_slug()
            now()->format('Y-m-d')
        );

        return $pdf->download($filename);

    } catch (\Exception $e) {
        Log::error('PDF Generation Error: ' . $e->getMessage());
        return redirect()
            ->back()
            ->with('error', 'Terjadi kesalahan saat men-download PDF: ' . $e->getMessage());
    }
}
}