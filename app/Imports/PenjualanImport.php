<?php
namespace App\Imports;

use App\Models\Penjualan;
use App\Models\Obat;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;

class PenjualanImport implements ToModel
{
    public function model(array $row)
    {
        $obat = Obat::where('nama_obat', $row[1])->first();

        if ($obat) {
            return new Penjualan([
                'obat_id' => $obat->id,
                'tanggal' => is_numeric($row[0]) 
                    ? Date::excelToDateTimeObject($row[0])->format('Y-m-d') 
                    : date('Y-m-d', strtotime($row[0])),
                'jumlah' => (int) $row[3],
            ]);
        }

        return null;
    }
}
