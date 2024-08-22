<?php

namespace App\Providers;

use Carbon\Carbon;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(fn () => Password::min(8)->letters()->mixedCase()->numbers()->symbols());

        Carbon::setLocale(config('app.locale'));

        FilamentColor::register(['secondary' => '#8b5cf6']);
    }
}
