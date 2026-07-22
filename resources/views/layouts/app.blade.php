<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Atlas</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex">

            <!-- Sidebar Placeholder -->
            <aside class="w-64 bg-white border-l border-gray-200 hidden md:block">
                <div class="h-full flex flex-col">
                    <div class="h-16 flex items-center px-4 border-b border-gray-200">
                        <span class="text-xl font-bold text-gray-800">Atlas</span>
                    </div>
                    <nav class="flex-1 px-4 py-4 space-y-2">
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Dashboard</a>
                        <a href="{{ route('patients.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">سجل المرضى</a>
                        <a href="{{ route('appointments.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">جدول المواعيد</a>
                        <a href="{{ route('billing.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">الحسابات</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">Settings</a>
                    </nav>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Top Header -->
                <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                    <!-- Global Search Placeholder -->
                    <div class="flex-1 max-w-lg">
                        <div class="relative">
                            <input type="text" class="w-full bg-gray-100 border-transparent rounded-md focus:border-indigo-500 focus:bg-white focus:ring-0 text-sm" placeholder="Search...">
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 space-x-reverse">
                        @include('layouts.navigation')
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto">
                    <!-- Page Heading -->
                    @isset($header)
                        <div class="bg-white shadow mb-6">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </div>
                    @endisset

                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
