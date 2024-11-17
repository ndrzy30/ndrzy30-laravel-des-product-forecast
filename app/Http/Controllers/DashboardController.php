<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Prediksi;
use App\Models\Penjualan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now();
        
        $data = [
            'total_obat' => Obat::count(),
            'total_penjualan' => $this->getTotalPenjualan(),
            'total_prediksi' => $this->getTotalPrediksi(),
            // 'stok_warning' => Obat::where('stok', '<=', 0)->count(),
            'monthly_sales' => $this->getMonthlyPenjualan(),
            'prediction_data' => $this->getPredictionData(),
            'current_month' => $currentMonth->format('F Y'),
            'last_updated' => now()->format('d M Y H:i')
        ];

        return view('admin.dashboard.index', $data);
    }

    private function getTotalPenjualan()
    {
        return Penjualan::whereYear('tanggal', now()->year)
                        ->whereMonth('tanggal', now()->month)
                        ->sum('jumlah');
    }

    private function getTotalPrediksi()
    {
        return Prediksi::whereYear('periode', now()->year)
                      ->whereMonth('periode', now()->month)
                      ->count();
    }

    private function getMonthlyPenjualan()
    {
        $startDate = now()->subMonths(11)->startOfMonth();
        $endDate = now()->endOfMonth();

        $sales = Penjualan::select(
            DB::raw('YEAR(tanggal) as year'),
            DB::raw('MONTH(tanggal) as month'),
            DB::raw('SUM(jumlah) as total_quantity')
        )
        ->where('tanggal', '>=', $startDate)
        ->where('tanggal', '<=', $endDate)
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

        $result = collect();
        $current = $startDate->copy();

        while ($current <= $endDate) {
            $monthData = $sales->first(function ($item) use ($current) {
                return $item->year == $current->year && $item->month == $current->month;
            });

            $result->push([
                'periode' => $current->format('M Y'),
                'total_quantity' => $monthData ? (float) $monthData->total_quantity : 0
            ]);

            $current->addMonth();
        }

        return $result;
    }

    private function getPredictionData()
    {
        $startDate = now()->subMonths(11)->startOfMonth();
        $endDate = now()->endOfMonth();

        // Data aktual
        $actual = Penjualan::select(
            DB::raw('YEAR(tanggal) as year'),
            DB::raw('MONTH(tanggal) as month'),
            DB::raw('SUM(jumlah) as total')
        )
        ->where('tanggal', '>=', $startDate)
        ->where('tanggal', '<=', $endDate)
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

        // Data prediksi
        $prediction = Prediksi::select(
            DB::raw('YEAR(periode) as year'),
            DB::raw('MONTH(periode) as month'),
            DB::raw('AVG(hasil_prediksi) as total')
        )
        ->where('periode', '>=', $startDate)
        ->where('periode', '<=', $endDate)
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

        $periods = collect();
        $actualData = collect();
        $predictionData = collect();

        $current = $startDate->copy();

        while ($current <= $endDate) {
            $actualValue = $actual->first(function ($item) use ($current) {
                return $item->year == $current->year && $item->month == $current->month;
            });

            $predictionValue = $prediction->first(function ($item) use ($current) {
                return $item->year == $current->year && $item->month == $current->month;
            });

            $periods->push($current->format('M Y'));
            $actualData->push($actualValue ? round($actualValue->total, 2) : 0);
            $predictionData->push($predictionValue ? round($predictionValue->total, 2) : 0);

            $current->addMonth();
        }

        return [
            'periods' => $periods->toArray(),
            'actual' => $actualData->toArray(),
            'prediction' => $predictionData->toArray()
        ];
    }
}