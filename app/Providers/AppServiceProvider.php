<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        $configJsonPath = storage_path('app/config.json');
        if (file_exists($configJsonPath)) {
            $data = json_decode(file_get_contents($configJsonPath), true);
            if (!empty($data['database_path'])) {
                config(['database.connections.sqlite.database' => $data['database_path']]);
                \Illuminate\Support\Facades\DB::purge('sqlite');
            }
        }

        Blade::if('feature', function (string $feature) {
            return auth()->check() && auth()->user()->tenant && auth()->user()->tenant->hasFeature($feature);
        });
    }
}
