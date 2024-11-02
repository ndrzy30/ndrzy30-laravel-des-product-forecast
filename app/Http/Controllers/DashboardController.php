<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Prediksi;
use App\Models\Penjualan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_obat' => Obat::count(),
            'total_penjualan' => Penjualan::count(),
            'total_prediksi' => Prediksi::count(),

            // Data untuk grafik penjualan bulanan
            'monthly_sales' => Penjualan::select(
                DB::raw('YEAR(tanggal) as year'),
                DB::raw('MONTH(tanggal) as month'),
                DB::raw('SUM(jumlah) as total_quantity')
            )
                ->groupBy(DB::raw('YEAR(tanggal)'), DB::raw('MONTH(tanggal)'))
                ->orderBy(DB::raw('YEAR(tanggal)'))
                ->orderBy(DB::raw('MONTH(tanggal)'))
                ->get(),

            // Data untuk grafik prediksi
            'prediction_data' => [
                'periods' => Prediksi::pluck('periode')->toArray(),
                'actual' => Penjualan::pluck('jumlah')->toArray(),
                'prediction' => Prediksi::pluck('hasil_prediksi')->toArray()
            ]
        ];

        return view('admin.dashboard.index', $data);  // Ubah path sesuai struktur folder
    }
}