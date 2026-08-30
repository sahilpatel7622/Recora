<?php

namespace App\Providers;

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
        try {
            \Illuminate\Support\Facades\View::share('projectSettings', \App\Models\ProjectSetting::first());
        } catch (\Exception $e) {
            // Ignore during migrations if table does not exist
        }
    }

}