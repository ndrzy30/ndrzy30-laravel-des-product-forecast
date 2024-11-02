<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediksi extends Model
{
    protected $fillable = [
        'obat_id',
        'periode',
        'alpha',
        'beta',
        'hasil_prediksi',
        'nilai_mad',
        'nilai_mse',
        'nilai_mape'
    ];

    // Relasi ke tabel obat
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}