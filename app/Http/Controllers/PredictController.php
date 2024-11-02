<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Prediction;
use App\Models\Train;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PredictController extends Controller
{
    public function index()
    {
        $drugs = Obat::all();
        $prediksiData = Prediction::all();
        $prediksi = Prediction::value('obat');

        return view('admin.prediksi.index', [
            'prediksiData' => $prediksiData,
            'drugs' => $drugs,
            'prediksi' => $prediksi,
        ]);
    }

    public function store(Request $request)
    {
        Log::info('Prediction request received', $request->all());

        $request->validate([
            'obat' => 'required|string',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 100),
        ]);

        $obat = $request->obat;
        $tahunPrediksi = $request->tahun;
        $tahunSebelumnya = $tahunPrediksi - 1;
        $duaTahunSebelumnya = $tahunPrediksi - 2;

        $dataDuaTahunSebelumnya = Train::where('obat', $obat)
            ->whereYear('tanggal', $duaTahunSebelumnya)
            ->orderBy('tanggal')
            ->get();

        $dataTahunSebelumnya = Train::where('obat', $obat)
            ->whereYear('tanggal', $tahunSebelumnya)
            ->orderBy('tanggal')
            ->get();

        if ($dataTahunSebelumnya->isEmpty() || $dataDuaTahunSebelumnya->isEmpty()) {
            Log::error('No data found for prediction', [
                'obat' => $obat,
                'tahunPrediksi' => $tahunPrediksi,
                'tahunSebelumnya' => $tahunSebelumnya,
                'duaTahunSebelumnya' => $duaTahunSebelumnya,
            ]);
            return redirect()->back()->with('error', 'Data penjualan untuk obat ini tidak ditemukan pada dua tahun sebelumnya.');
        }

        $dataGabungan = $dataDuaTahunSebelumnya->merge($dataTahunSebelumnya);

        $n = $dataGabungan->count();
        $totalY = $dataGabungan->sum('penjualan_y');
        $totalX = $dataGabungan->sum('periode_x');
        $totalXY = $dataGabungan->sum(function ($item) {
            return $item->periode_x * $item->penjualan_y;
        });
        $totalX2 = $dataGabungan->sum(function ($item) {
            return $item->periode_x * $item->periode_x;
        });

        $slope = ($n * $totalXY - $totalX * $totalY) / ($n * $totalX2 - $totalX * $totalX);
        $intercept = ($totalY - $slope * $totalX) / $n;

        Prediction::truncate();

        $dataTahunPrediksi = Train::where('obat', $obat)
            ->whereYear('tanggal', $tahunPrediksi)
            ->orderBy('tanggal')
            ->get();

        foreach ($dataTahunPrediksi as $data) {
            $currentPeriodeX = $data->periode_x;
            $prediksiY = $intercept + $slope * $currentPeriodeX;
            $bulanTahun = Carbon::parse($data->tanggal)->format('F Y');
            Prediction::create([
                'obat' => $obat,
                'bulan' => $bulanTahun,
                'prediksi_f' => round($prediksiY, 2),
                'periode_x' => $currentPeriodeX,
                'aktual_y' => $data->penjualan_y,
            ]);
        }

        Log::info('Prediction completed', ['obat' => $obat, 'tahunPrediksi' => $tahunPrediksi]);
        return redirect()->route('predict.index')->with('success', 'Prediksi berhasil dihitung dan disimpan.');
    }
}