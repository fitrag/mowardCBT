<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

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
        // Apply timezone setting
        try {
            $timezone = Setting::get('timezone', 'Asia/Jakarta');
            date_default_timezone_set($timezone);
            config(['app.timezone' => $timezone]);
        } catch (\Exception $e) {
            // Settings table might not exist yet during migration
        }

        // Apply language setting
        try {
            $language = Setting::get('language', 'id');
            App::setLocale($language);
        } catch (\Exception $e) {
            // Settings table might not exist yet during migration
        }
    }
}
