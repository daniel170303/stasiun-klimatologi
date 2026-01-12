<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case PENGUNJUNG = 'pengunjung';
    case PEGAWAI = 'pegawai';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Administrator',
            self::PENGUNJUNG => 'Pengunjung',
            self::PEGAWAI => 'Pegawai',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}