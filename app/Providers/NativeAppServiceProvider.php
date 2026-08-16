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
        
        if (app()->runningInConsole()) {
            return;
        }

        if (class_exists(\Native\Laravel\Facades\Window::class)) {
            try {
                Window::open()
                    ->id('main')
                    ->title('Atlas Clinic System')
                    ->width(1280)
                    ->height(800)
                    ->minWidth(1024)
                    ->minHeight(768)
                    ->showDevTools(false)
                    ->rememberState();
            } catch (\Exception $e) {
                // Ignore errors when running without native app context
            }
        }
    }
    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [];
    }
}
