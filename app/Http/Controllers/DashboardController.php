<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $obat = Obat::count();
        $type = Obat::distinct('jenis')->count('jenis');
        $sale = Sale::count();
        $obats = Obat::select('jenis', DB::raw('COUNT(*) as total_jumlah'))
            ->groupBy('jenis')
            ->get();

        // Modified query to get monthly sales data
        $monthlySales = Sale::selectRaw('YEAR(tanggal) as year, MONTH(tanggal) as month, SUM(jumlah) as total_quantity')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard.index', compact('obat', 'type', 'sale', 'obats', 'monthlySales'));
    }
}