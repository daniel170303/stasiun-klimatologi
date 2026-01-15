<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganPetugas extends Model
{
    use HasFactory;

    protected $table = 'kunjungan_petugas';

    protected $fillable = [
        'kunjungan_id',
        'pegawai_id',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}