<?php

namespace App\Models;

use App\Enums\StatusKunjungan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kunjungan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kunjungan';

    protected $fillable = [
        'pengunjung_id',
        'tanggal_utama',
        'tanggal_alternatif',
        'tanggal_disetujui',
        'jumlah_peserta',
        'surat_permohonan',
        'status',
        'keterangan_admin',
        'tujuan_kunjungan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_utama' => 'date',
            'tanggal_alternatif' => 'date',
            'tanggal_disetujui' => 'date',
            'status' => StatusKunjungan::class,
        ];
    }

    public function pengunjung()
    {
        return $this->belongsTo(Pengunjung::class);
    }

    public function petugas()
    {
        return $this->belongsToMany(Pegawai::class, 'kunjungan_petugas', 'kunjungan_id', 'pegawai_id')
                    ->withTimestamps();
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Check if a date is available for new visit
     */
    public static function isDateAvailable($date, $excludeId = null): bool
    {
        $query = self::where('tanggal_disetujui', $date)
                     ->whereIn('status', [
                         'menunggu_konfirmasi',
                         'dikonfirmasi',
                         'petugas_ditugaskan',
                         'terlaksana'
                     ]);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return !$query->exists();
    }

    /**
     * Get all occupied dates for the next 3 months
     */
    public static function getOccupiedDates($months = 3): array
    {
        return self::whereNotNull('tanggal_disetujui')
                   ->whereIn('status', [
                       'menunggu_konfirmasi',
                       'dikonfirmasi',
                       'petugas_ditugaskan',
                       'terlaksana'
                   ])
                   ->where('tanggal_disetujui', '>=', now())
                   ->where('tanggal_disetujui', '<=', now()->addMonths($months))
                   ->pluck('tanggal_disetujui')
                   ->map(fn($date) => $date->format('Y-m-d'))
                   ->unique()
                   ->values()
                   ->toArray();
    }
}