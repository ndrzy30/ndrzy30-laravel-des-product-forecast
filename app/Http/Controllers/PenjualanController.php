<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Obat;
use App\Imports\PenjualanImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Tambahkan ini
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;

class PenjualanController extends Controller
{
    public function index()
    {
        $data = Penjualan::with('obat')->get();
        return view('admin.penjualan.index', ['data' => $data]);
    }

    public function create()
    {
        $drugs = Obat::all();
        return view('admin.penjualan.create', compact('drugs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer',
        ]);

        Penjualan::create($validatedData);

        return redirect()->route('sales.index')->with('success', 'Data penjualan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Penjualan::findOrFail($id);
        $drugs = Obat::all();
        return view('admin.penjualan.edit', compact('data', 'drugs'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer',
        ]);

        Penjualan::findOrFail($id)->update($validatedData);

        return redirect()->route('sales.index')->with('success', 'Data penjualan berhasil diperbarui');
    }

    public function destroy($id)
    {
        Penjualan::findOrFail($id)->delete();
        return redirect()->route('sales.index')->with('success', 'Data penjualan berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx'
        ]);

        try {
            Excel::import(new PenjualanImport, $request->file('file'));
            return redirect()->route('sales.index')->with('success', 'Data penjualan berhasil diimpor');
        } catch (\Exception $e) {
            Log::error("Error Importing File: " . $e->getMessage()); // Menggunakan Log di sini
            return redirect()->route('sales.index')->with('error', 'Terjadi kesalahan saat mengimpor file');
        }
    }
}
