<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'kategori',
        'satuan',
        'stok'
    ];

    // Relasi ke tabel penjualan
    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }

    // Relasi ke tabel prediksi
    public function prediksis()
    {
        return $this->hasMany(Prediksi::class);
    }
}