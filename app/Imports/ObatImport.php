<?php

namespace App\Imports;

use App\Models\Obat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ObatImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Obat([
            'kode_obat' => $row['kode_obat'],
            'nama_obat' => $row['nama_obat'],
            'kategori' => $row['kategori'],
            'satuan' => $row['satuan'],
            // 'stok' => $row['stok'] ?? 0
        ]);
    }
}