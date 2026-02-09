<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengunjung extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengunjung';

    protected $fillable = [
        'user_id',
        'nama_instansi',
        'jenjang',
        'nama_penanggung_jawab',
        'email',
        'no_hp',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class);
    }
}