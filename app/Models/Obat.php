<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'kategori',
        'satuan',
        // 'stok',
        // 'minimum_stok'
    ];

    // Relasi ke penjualan
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

    // Relasi ke prediksi
    public function prediksi()
    {
        return $this->hasMany(Prediksi::class);
    }

    // Scope untuk mendapatkan obat dengan stok di bawah minimum
    // public function scopeNeedRestock($query)
    // {
    //     return $query->whereRaw('stok <= minimum_stok');
    
}