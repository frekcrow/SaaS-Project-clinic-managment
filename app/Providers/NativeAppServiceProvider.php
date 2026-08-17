<?php

namespace App\Providers;

use Native\Laravel\Facades\Window;
use Native\Laravel\Contracts\ProvidesPhpIni;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     */
    public function boot(): void
    {
        
         Window::open()
             ->id('main')
             ->title('Atlas Clinic System')
             ->width(1280)
             ->height(800)
             ->minWidth(1024)
             ->minHeight(768)
             ->showDevTools(false)
             ->rememberState();
        
        
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [];
    }
}
