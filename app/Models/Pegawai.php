<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pegawai';

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'keahlian',
        'status_aktif',
    ];

    protected function casts(): array
    {
        return [
            'status_aktif' => 'boolean',
        ];
    }

    /**
     * Relasi many-to-many dengan Kunjungan
     * Satu pegawai bisa ditugaskan ke banyak kunjungan
     */
    public function kunjungans()
    {
        return $this->belongsToMany(Kunjungan::class, 'kunjungan_petugas', 'pegawai_id', 'kunjungan_id')
                    ->withTimestamps();
    }

    /**
     * Scope untuk filter pegawai aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }
}