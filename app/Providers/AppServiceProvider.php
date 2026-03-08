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

        // Memaksa seluruh tautan URL yang dibuat agar menggunakan HTTPS sesuai policy keamanan
        if($this->app->environment('production') || env('APP_URL') == 'https://localhost') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}