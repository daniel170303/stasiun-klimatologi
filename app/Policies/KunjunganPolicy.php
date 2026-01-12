<?php

namespace App\Policies;

use App\Models\Kunjungan;
use App\Models\User;

class KunjunganPolicy
{
    public function view(User $user, Kunjungan $kunjungan): bool
    {
        return $user->isAdmin() || 
               ($user->isPengunjung() && $kunjungan->pengunjung->user_id === $user->id);
    }

    public function update(User $user, Kunjungan $kunjungan): bool
    {
        return $user->isAdmin() || 
               ($user->isPengunjung() && $kunjungan->pengunjung->user_id === $user->id);
    }

    public function delete(User $user, Kunjungan $kunjungan): bool
    {
        return $user->isAdmin();
    }
}