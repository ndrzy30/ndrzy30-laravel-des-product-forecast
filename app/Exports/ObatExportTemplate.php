<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ObatExportTemplate implements FromCollection, WithHeadings
{
    // Metode ini mengembalikan data yang akan diekspor ke file Excel
    public function collection()
    {
        return new Collection([
            // Contoh data template, ini bisa disesuaikan dengan kolom yang Anda butuhkan
            ['Nama Obat', 'Jenis Obat', 'Dosis', 'Harga'],
            // Tambahkan data lain jika perlu
        ]);
    }

    // Menambahkan header di file Excel
    public function headings(): array
    {
        return ['Nama Obat', 'Jenis Obat', 'Dosis', 'Harga'];
    }
}
