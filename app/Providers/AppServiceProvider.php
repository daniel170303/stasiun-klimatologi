<?php

namespace App\Providers;

use App\Models\Kunjungan;
use App\Policies\KunjunganPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Kunjungan::class, KunjunganPolicy::class);
    }
}