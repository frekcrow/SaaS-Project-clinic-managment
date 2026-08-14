<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class NativeAppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (class_exists(\Native\Laravel\Facades\Window::class)) {
            \Native\Laravel\Facades\Window::open()
                ->title('Atlas Clinic System')
                ->width(1280)
                ->height(800)
                ->minWidth(1024)
                ->minHeight(768)
                ->showDevTools(false)
                ->rememberState(); // Remembers window position and size
        }
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
