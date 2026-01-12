<?php

namespace App\Enums;

enum StatusKunjungan: string
{
    case DIAJUKAN = 'diajukan';
    case DIVERIFIKASI = 'diverifikasi';
    case MENUNGGU_KONFIRMASI = 'menunggu_konfirmasi';
    case DIKONFIRMASI = 'dikonfirmasi';
    case PETUGAS_DITUGASKAN = 'petugas_ditugaskan';
    case TERLAKSANA = 'terlaksana';
    case TIDAK_TERLAKSANA = 'tidak_terlaksana';
    case SELESAI = 'selesai';

    public function label(): string
    {
        return match($this) {
            self::DIAJUKAN => 'Diajukan',
            self::DIVERIFIKASI => 'Diverifikasi',
            self::MENUNGGU_KONFIRMASI => 'Menunggu Konfirmasi',
            self::DIKONFIRMASI => 'Dikonfirmasi',
            self::PETUGAS_DITUGASKAN => 'Petugas Ditugaskan',
            self::TERLAKSANA => 'Terlaksana',
            self::TIDAK_TERLAKSANA => 'Tidak Terlaksana',
            self::SELESAI => 'Selesai',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DIAJUKAN => 'bg-blue-100 text-blue-800',
            self::DIVERIFIKASI => 'bg-indigo-100 text-indigo-800',
            self::MENUNGGU_KONFIRMASI => 'bg-yellow-100 text-yellow-800',
            self::DIKONFIRMASI => 'bg-purple-100 text-purple-800',
            self::PETUGAS_DITUGASKAN => 'bg-pink-100 text-pink-800',
            self::TERLAKSANA => 'bg-green-100 text-green-800',
            self::TIDAK_TERLAKSANA => 'bg-red-100 text-red-800',
            self::SELESAI => 'bg-gray-100 text-gray-800',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}