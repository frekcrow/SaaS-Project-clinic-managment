<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Atlas</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800">
        <div class="min-h-screen flex relative overflow-hidden">

            <!-- HeroUI-inspired Floating Sidebar (RTL) -->
            <aside
                x-data="{ expanded: false }"
                @mouseenter="expanded = true"
                @mouseleave="expanded = false"
                :class="expanded ? 'w-64' : 'w-20'"
                class="hidden md:flex flex-col m-4 h-[calc(100vh-2rem)] bg-white/70 backdrop-blur-xl shadow-sm border border-white/60 rounded-3xl transition-all duration-300 ease-in-out z-20 flex-shrink-0"
            >
                <div class="h-20 flex items-center justify-center px-4">
                    <!-- Icon always visible -->
                    <svg class="w-8 h-8 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <!-- Text visible on hover -->
                    <span x-show="expanded" x-transition.opacity.duration.300ms class="mr-3 text-xl font-bold text-slate-800 whitespace-nowrap">
                        Atlas
                    </span>
                </div>

                <nav class="flex-1 px-3 py-4 space-y-2 overflow-y-auto overflow-x-hidden">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-3 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        <span x-show="expanded" x-transition.opacity.duration.300ms class="mr-4 font-medium whitespace-nowrap">الرئيسية</span>
                    </a>

                    <a href="{{ route('patients.index') }}" class="flex items-center px-3 py-3 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('patients.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span x-show="expanded" x-transition.opacity.duration.300ms class="mr-4 font-medium whitespace-nowrap">سجل المرضى</span>
                    </a>

                    <a href="{{ route('appointments.index') }}" class="flex items-center px-3 py-3 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('appointments.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span x-show="expanded" x-transition.opacity.duration.300ms class="mr-4 font-medium whitespace-nowrap">جدول المواعيد</span>
                    </a>

                    <a href="{{ route('billing.index') }}" class="flex items-center px-3 py-3 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('billing.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <span x-show="expanded" x-transition.opacity.duration.300ms class="mr-4 font-medium whitespace-nowrap">الحسابات</span>
                    </a>

                    <a href="{{ route('settings.index') }}" class="flex items-center px-3 py-3 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('settings.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span x-show="expanded" x-transition.opacity.duration.300ms class="mr-4 font-medium whitespace-nowrap">الإعدادات</span>
                    </a>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
                <!-- HeroUI-inspired Top Header (Floating) -->
                <header class="h-20 flex items-center justify-between px-6 sm:px-8 mt-4 mx-4 md:mx-6 z-10 flex-shrink-0">

                    <!-- Right empty space for balance, or could add notifications -->
                    <div class="w-20 hidden md:block"></div>

                    <!-- Floating Search Bar (Center-ish) -->
                    <div class="flex-1 flex justify-center px-4">
                        <div class="w-full max-w-md relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" class="w-full bg-white border-none rounded-full shadow-sm py-2.5 pr-11 pl-4 focus:ring-2 focus:ring-indigo-500/50 focus:outline-none text-sm text-slate-700 placeholder-slate-400 transition-shadow" placeholder="ابحث هنا...">
                        </div>
                    </div>

                    <!-- Profile Area (Top Left in RTL) -->
                    <div class="flex items-center" x-data="{ open: false }">
                        <!-- Dropdown Trigger -->
                        <button @click="open = !open" class="flex items-center space-x-3 space-x-reverse focus:outline-none bg-white shadow-sm hover:bg-slate-50 rounded-full py-1 pr-1 pl-4 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold shadow-sm">
                                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                            </div>
                            <div class="flex flex-col items-start hidden sm:flex">
                                <span class="text-sm font-semibold text-slate-800">{{ Auth::user()->name ?? 'المستخدم' }}</span>
                                <span class="text-xs text-slate-500">عيادة الشفاء</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" x-transition class="absolute top-16 left-6 w-48 bg-white shadow-lg rounded-2xl border border-slate-100 py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors">الملف الشخصي</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-right block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    تسجيل الخروج
                                </button>
                            </form>
                        </div>
                    </div>
                </header>

                <!-- Page Content (Scrollable) -->
                <main class="flex-1 overflow-y-auto px-4 md:px-6 py-6 pb-20">
                    <!-- Page Heading -->
                    @isset($header)
                        <div class="mb-6 flex items-center justify-between">
                            <h1 class="text-2xl font-bold text-slate-800">
                                {{ $header }}
                            </h1>
                        </div>
                    @endisset

                    <div class="mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
