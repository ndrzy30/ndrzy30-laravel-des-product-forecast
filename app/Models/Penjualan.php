<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = [
        'obat_id',
        'tanggal',
        'jumlah'
    ];

    // Relasi ke tabel obat
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
