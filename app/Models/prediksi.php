<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediksi extends Model
{
    use HasFactory;

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

    protected $casts = [
        'periode' => 'date'
    ];

    // Relasi ke tabel obat
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    // Relasi ke penjualan berdasarkan periode
    public function penjualan()
    {
        return $this->hasOne(Penjualan::class, 'tanggal', 'periode')
                    ->where('obat_id', $this->obat_id);
    }

    // Scope untuk mendapatkan prediksi terbaru
    public function scopeLatest($query)
    {
        return $query->orderBy('periode', 'desc');
    }
}