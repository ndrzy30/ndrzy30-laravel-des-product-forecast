<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Imports\ObatImport;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ObatController extends Controller
{
    public function index()
    {
        $data = [
            'data' => Obat::all()
        ];
        return view('admin.obat.index', $data);
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'kode_obat' => 'required|unique:obats',
            'nama_obat' => 'required',
            'kategori' => 'required',
            'satuan' => 'required',
            // 'stok' => 'required|numeric'
        ]);

        Obat::create($validated);

        return redirect()
            ->route('medicine.index')
            ->with('success', 'Data obat berhasil ditambahkan');
            
    } catch (\Exception $e) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Error: ' . $e->getMessage());
    }
}

    public function edit($id)
    {
        $data = [
            'data' => Obat::findOrFail($id)
        ];
        return view('admin.obat.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'kode_obat' => 'required|unique:obats,kode_obat,'.$id,
                'nama_obat' => 'required',
                'kategori' => 'required',
                'satuan' => 'required',
                // 'stok' => 'required|numeric'
            ]);

            Obat::findOrFail($id)->update($validated);

            return redirect()
                ->route('medicine.index')
                ->with('success', 'Data obat berhasil diupdate');
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)  // Perbaikan method destroy
    {
        try {
            Obat::findOrFail($id)->delete();
            
            return redirect()
                ->route('medicine.index')
                ->with('success', 'Data obat berhasil dihapus');
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,csv,xls|max:2048'  // Batas maksimum ukuran file 2MB
            ]);
    
            Excel::import(new ObatImport, $request->file('file'));
            return redirect()->route('medicine.index')->with('success', 'Import data obat berhasil');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}