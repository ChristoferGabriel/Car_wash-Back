<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('login', fn (Request $request) => [
            Limit::perMinute(5)->by('minuto:'.$request->ip()),
            Limit::perHour(30)->by('hora:'.$request->ip()),
        ]);

        RateLimiter::for('agendamento', fn (Request $request) => [
            Limit::perMinute(3)->by('minuto:'.$request->ip()),
            Limit::perDay(20)->by('dia:'.$request->ip()),
        ]);
    }
}