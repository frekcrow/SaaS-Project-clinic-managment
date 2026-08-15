<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Native\Laravel\Facades\Window;
use Native\Laravel\Contracts\ProvidesPhpIni;

class NativeAppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Executed once the native application has been booted.
     */
    public function boot(): void
    {
        // أوقفنا كود النافذة مؤقتاً ليعمل المتصفح بسلام
        // Window::open()
        //     ->id('main')
        //     ->title('Atlas Clinic System')
        //     ->width(1280)
        //     ->height(800)
        //     ->minWidth(1024)
        //     ->minHeight(768)
        //     ->showDevTools(false)
        //     ->rememberState();
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [];
    }
}