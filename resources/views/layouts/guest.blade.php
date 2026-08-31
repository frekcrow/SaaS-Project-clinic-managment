<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
        <title>{{ config('app.name', 'Atlas') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] { display: none !important; }
        </style>
        <script>
            const theme = localStorage.getItem('theme') || 'default';
            if (theme !== 'default') {
                document.documentElement.setAttribute('data-theme', theme);
            }
        </script>
    </head>
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-800">
            <div>
                <a href="/" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo-icon.png') }}" alt="Atlas Logo" class="w-12 h-12">
                    <span class="text-2xl font-bold text-gray-900 dark:text-gray-100 dark:text-white">Atlas</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md dark:shadow-none overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
