<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
        <title>{{ config('app.name', 'Atlas') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Flatpickr for Date Inputs -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <!-- Scripts -->
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] { display: none !important; }
        </style>
        <script>
            const theme = localStorage.getItem('theme') || 'default';
            if (theme !== 'default') {
                document.documentElement.setAttribute('data-theme', theme);
            }
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        </script>
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-slate-800 dark:text-gray-200">
        <x-dynamic-island />
        @if(isset($subscriptionWarning) && $subscriptionWarning)
            <div class="bg-yellow-500 text-white text-center py-2 font-bold z-[100] relative">
                {{ __('Warning: Your subscription will expire soon. Please renew.') }}
            </div>
        @endif
        <div x-data="{ isCollapsed: {{ request()->routeIs('dashboard') ? 'false' : 'true' }}, darkMode: localStorage.getItem('theme') === 'dark', toggleDarkMode() { this.darkMode = !this.darkMode; const theme = this.darkMode ? 'dark' : 'default'; localStorage.setItem('theme', theme); document.documentElement.setAttribute('data-theme', theme); document.documentElement.classList.toggle('dark', this.darkMode); } }" class="flex h-screen bg-gray-50 dark:bg-gray-900 overflow-hidden">

            <!-- HeroUI-inspired Floating Sidebar (RTL) -->
            <aside
                :class="isCollapsed ? 'w-20' : 'w-44'"
                class="fixed flex flex-col h-screen bg-white dark:bg-gray-800 border-e border-slate-100 dark:border-gray-700 shadow-md transition-all duration-300 ease-in-out z-50 flex-shrink-0"
            >
                <!-- Sidebar Header -->
                <div class="h-20 border-b border-slate-100 dark:border-gray-700 flex items-center px-4" :class="isCollapsed ? 'justify-center' : 'justify-between'">
                    <!-- Logo Area -->
                    <div x-cloak x-show="!isCollapsed" x-transition.opacity.duration.300ms class="flex items-center gap-2 me-4">
                        <img src="{{ asset('images/logo-icon.png') }}" class="h-8 w-auto" alt="Logo Icon">
                        <img src="{{ asset('images/logo-text.png') }}" class="h-6 w-auto" alt="Logo Text">
                    </div>
                    <!-- Toggle Button -->
                    <button @click="isCollapsed = !isCollapsed" class="text-slate-400 hover:text-slate-600 transition-colors z-50 flex items-center justify-center p-1 rounded-lg hover:bg-slate-100 flex-shrink-0">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto overflow-x-hidden">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        <span x-cloak x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('الرئيسية') }}</span>
                    </a>

                    <a href="{{ route('doctor.patients.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.patients.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span x-cloak x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('ملفات المرضى') }}</span>
                    </a>

                    <a href="{{ route('doctor.surgeries.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.surgeries.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10m-5-4v4m0-4V7a2 2 0 00-2-2H8a2 2 0 00-2 2v10h8V7m-4-2V3a1 1 0 00-1-1H9a1 1 0 00-1 1v2"></path>
                        </svg>
                        <span x-cloak x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('العمليات') }}</span>
                    </a>

                    <a href="{{ route('doctor.billing.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.billing.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                       <span x-cloak x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('الحسابات والفوترة') }}</span>
                    </a>

                    <a href="{{ route('doctor.appointments.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.appointments.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span x-cloak x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('تقويم المواعيد') }}</span>
                    </a>

                    <a href="{{ route('doctor.prescriptions.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.prescriptions.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span x-cloak x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('تهيئة الوصفات') }}</span>
                    </a>

                    <a href="{{ route('doctor.medications.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.medications.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                        <span x-cloak x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('الأدوية') }}</span>
                    </a>

                    <a href="{{ route('doctor.settings.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.settings.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span x-cloak x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('الإعدادات') }}</span>
                    </a>

                    <div x-data="{ openSupport: false }" class="relative">
                        <button @click="openSupport = !openSupport" class="w-full flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span x-cloak x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('الدعم الفني') }}</span>
                        </button>
                        <div x-cloak x-show="openSupport" x-transition @click.away="openSupport = false" class="mt-2 bg-slate-50 rounded-2xl p-2 flex justify-around shadow-sm border border-slate-100 mx-2">
                            <a href="tel:000000000" class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-white rounded-xl transition-colors shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </a>
                            <a href="https://wa.me/000000000" target="_blank" class="p-2 text-slate-500 hover:text-green-500 hover:bg-white rounded-xl transition-colors shadow-sm">
                                <!-- WhatsApp Icon -->
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                            </a>
                            <a href="https://t.me/username" target="_blank" class="p-2 text-slate-500 hover:text-sky-500 hover:bg-white rounded-xl transition-colors shadow-sm">
                                <!-- Telegram Icon -->
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('api.notifications.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('api.notifications.index') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span x-cloak x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('إشعارات النظام') }}</span>
                    </a>

                    <!-- Promotional Card Block -->
                    <div x-cloak x-show="!isCollapsed" class="mt-4 pt-4 border-t border-gray-200">
                        <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100 flex flex-col gap-3">
                            <div class="h-24 w-full bg-slate-200 rounded-xl overflow-hidden relative flex items-center justify-center">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="text-center">
                                <h4 class="text-sm font-bold text-slate-800">{{ __('ترقية النظام') }}</h4>
                                <p class="text-xs text-slate-500 mt-1">{{ __('احصل على الميزات الجديدة الآن') }}</p>
                            </div>
                        </div>
                    </div>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 transition-all duration-300 h-screen overflow-hidden" :class="isCollapsed ? 'ms-20' : 'ms-44'">
                <!-- HeroUI-inspired Top Header (Floating) -->
                <header class="relative z-[70] h-20 flex items-center justify-between px-6 bg-white dark:bg-gray-800 border-b border-slate-200 dark:border-gray-700 flex-shrink-0">

                    <!-- Dynamic Header Logo -->
                    <div class="flex items-center gap-2" x-cloak x-show="isCollapsed" x-transition.opacity.duration.300ms>
                        <img src="{{ asset('images/logo-icon.png') }}" class="h-8 w-auto" alt="Logo Icon">
                        <img src="{{ asset('images/logo-text.png') }}" class="h-8 w-auto" alt="Logo Text">
                    </div>

                    <!-- Right side: Notifications -->
                    <div class="flex items-center gap-4" x-data="notificationsDropdown()" @notification-read.window="fetchNotifications()">
                        <!-- Dark Mode Toggle -->
                        <button @click="toggleDarkMode()" class="p-2 bg-white dark:bg-gray-800 rounded-full shadow-sm hover:bg-slate-50 dark:hover:bg-gray-700 transition-colors border border-transparent dark:border-gray-600">
                            <!-- Sun icon for dark mode (to switch to light) -->
                            <svg x-cloak x-show="darkMode" class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <!-- Moon icon for light mode (to switch to dark) -->
                            <svg x-cloak x-show="!darkMode" class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                        </button>

                        <div class="relative">
                            <button @click="open = !open" class="p-2 bg-white dark:bg-gray-800 rounded-full shadow-sm hover:bg-slate-50 dark:hover:bg-gray-700 transition-colors border border-transparent dark:border-gray-600 relative">
                                <svg class="w-6 h-6 text-slate-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                <span x-cloak x-show="unreadCount > 0" x-text="unreadCount" class="absolute top-0 end-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform rtl:translate-x-1/4 ltr:-translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full"></span>
                            </button>

                            <!-- Notifications Dropdown -->
                            <div x-cloak x-show="open" @click.away="open = false" x-transition class="absolute top-full mt-2 start-0 ms-2 max-w-xs w-80 !bg-white opacity-100 shadow-xl rounded-2xl border border-slate-100 py-2 z-[60]">
                                <div class="px-4 py-2 border-b border-slate-100 flex justify-between items-center">
                                    <h3 class="font-bold text-slate-800">{{ __('الإشعارات') }}</h3>
                                    <button x-cloak x-show="unreadCount > 0" @click="markAllAsRead" class="text-xs text-indigo-600 hover:text-indigo-800">{{ __('تحديد الكل كمقروء') }}</button>
                                </div>
                                <div class="max-h-80 overflow-y-auto">
                                    <template x-if="notifications.length === 0">
                                        <div class="p-4 text-center text-slate-500 text-sm">{{ __('لا توجد إشعارات') }}</div>
                                    </template>
                                    <template x-for="notif in notifications" :key="notif.id">
                                        <div class="px-4 py-3 border-b border-slate-50 hover:bg-slate-50 transition-colors flex items-start gap-3 cursor-pointer"
                                             :class="{'bg-slate-50': !notif.read_at}"
                                             @click="markAsRead(notif.id)">

                                            <!-- Icon -->
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center mt-1">
                                                <template x-if="notif.data.icon === 'clock'">
                                                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </template>
                                                <template x-if="notif.data.icon === 'play'">
                                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </template>
                                                <template x-if="notif.data.icon === 'check-circle'">
                                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </template>
                                                <template x-if="!['clock', 'play', 'check-circle'].includes(notif.data.icon)">
                                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </template>
                                            </div>

                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm text-slate-800" :class="{'font-bold': !notif.read_at}" x-text="notif.data.message"></p>
                                                <p class="text-xs text-slate-500 mt-1" x-text="new Date(notif.created_at).toLocaleString('ar-IQ')"></p>
                                            </div>

                                            <div x-cloak x-show="!notif.read_at" class="flex-shrink-0 w-2 h-2 rounded-full bg-red-500 mt-2"></div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Floating Search Bar (Center-ish) -->
                    <div class="flex-1 flex justify-center px-4 items-center gap-2" x-data="globalSearch()">
                        <!-- Fullscreen Toggle -->
                        <div x-data="{ isFullscreen: false }" @fullscreenchange.window="isFullscreen = !!document.fullscreenElement">
                            <button @click="if (!document.fullscreenElement) { document.documentElement.requestFullscreen(); isFullscreen = true; } else { document.exitFullscreen(); isFullscreen = false; }" class="p-2 bg-white dark:bg-gray-800 rounded-full shadow-sm hover:bg-slate-50 dark:hover:bg-gray-700 transition-colors border border-transparent dark:border-gray-600" title="{{ __('وضع ملء الشاشة') }}">
                                <svg x-cloak x-show="!isFullscreen" class="w-6 h-6 text-slate-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"></path>
                                </svg>
                                <svg x-cloak x-show="isFullscreen" class="w-6 h-6 text-slate-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 14h6v6m10-10h-6V4m6 6l-7-7M4 20l7-7"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="w-full max-w-md relative" @click.away="open = false">
                            <div class="absolute inset-y-0 end-0 flex items-center pe-4 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" x-model="query" @input.debounce.300ms="search" @focus="open = true" class="w-full bg-white border-[1.5px] border-black/80 rounded-full shadow-sm py-2.5 pe-11 ps-4 focus:ring-2 focus:ring-indigo-500/50 focus:outline-none text-sm text-slate-700 placeholder-slate-400 transition-shadow" placeholder="{{ __('بحث') }}...">

                            <!-- Search Results Dropdown -->
                            <div x-cloak x-show="open && results.length > 0" x-transition class="absolute top-14 w-full bg-white shadow-xl rounded-2xl border border-slate-100 py-2 z-[60] overflow-hidden">
                                <div class="max-h-80 overflow-y-auto">
                                    <template x-for="(result, index) in results" :key="index">
                                        <a :href="result.url" class="px-4 py-3 border-b border-slate-50 hover:bg-slate-50 transition-colors flex items-center gap-3 cursor-pointer">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center">
                                                <template x-if="result.icon === 'user'">
                                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                </template>
                                                <template x-if="result.icon === 'calendar'">
                                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </template>
                                                <template x-if="result.icon === 'folder'">
                                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                                </template>
                                                <template x-if="!['user', 'calendar', 'folder'].includes(result.icon)">
                                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </template>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-base font-medium text-slate-800" x-text="result.title"></p>
                                                <p class="text-xs text-slate-500 mt-0.5" x-text="result.subtitle"></p>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Area (Top Left in RTL) -->
                    <div class="flex items-center relative" x-data="{ open: false }">
                        <!-- Dropdown Trigger -->
                        <button @click="open = !open" class="flex items-center space-x-3 rtl:space-x-reverse focus:outline-none bg-white shadow-sm hover:bg-slate-50 rounded-full py-1 pe-1 ps-4 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold shadow-sm overflow-hidden">
                                @if(Auth::user()->avatar_path)
                                    <img src="{{ Storage::url(Auth::user()->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                                @endif
                            </div>
                            <div class="flex flex-col items-start">
                                <span class="text-sm font-semibold text-slate-800">{{ __('د') }}. {{ Auth::user()->name ?? __('الطبيب') }}</span>
                                <span class="text-xs text-slate-500">{{ Auth::user()->clinic_name ?? __('عيادة الشفاء') }}</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-cloak x-show="open" @click.away="open = false" x-transition class="absolute top-full end-0 mt-2 w-48 bg-white shadow-lg rounded-2xl border border-slate-100 py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors">{{ __('الملف الشخصي') }}</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-right block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    {{ __('تسجيل الخروج') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </header>

                <!-- Page Content (Scrollable) -->
                <main class="flex-1 overflow-y-auto px-6 py-6 pb-20 bg-gray-50 dark:bg-gray-900">
                    <!-- Page Heading -->
                    @isset($header)
                        <div class="mb-6 flex items-center justify-between">
                            <h1 class="text-2xl font-bold text-slate-800 dark:text-gray-100">
                                {{ $header }}
                            </h1>
                        </div>
                    @endisset

                    <div class="w-full">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
        @stack('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('notificationsDropdown', () => ({
                    open: false,
                    notifications: [],
                    unreadCount: 0,

                    init() {
                        this.fetchNotifications();
                        setInterval(() => {
                            this.fetchNotifications();
                        }, 10000); // Check every 10s
                    },

                    async fetchNotifications() {
                        try {
                            const response = await fetch('/api/notifications');
                            if (response.ok) {
                                const data = await response.json();
                                this.notifications = data.notifications || [];
                                this.unreadCount = data.unreadCount || 0;
                            }
                        } catch (error) {
                            console.error('Error fetching notifications list:', error);
                        }
                    },

                    async markAsRead(id) {
                        try {
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            await fetch(`/api/notifications/${id}/read`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                }
                            });
                            this.fetchNotifications();
                        } catch (error) {}
                    },


                    async markAllAsRead() {
                        try {
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            await fetch(`/api/notifications/read-all`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                }
                            });
                            this.fetchNotifications();
                        } catch (error) {}
                    }
                }));

                Alpine.data('globalSearch', () => ({
                    query: '',
                    results: [],
                    open: false,

                    async search() {
                        if (this.query.trim().length === 0) {
                            this.results = [];
                            this.open = false;
                            return;
                        }

                        try {
                            const response = await fetch(`/api/global-search?q=${encodeURIComponent(this.query)}`);
                            if (response.ok) {
                                this.results = await response.json();
                                this.open = this.results.length > 0;
                            }
                        } catch (error) {
                            console.error('Error fetching search results:', error);
                        }
                    }
                }));
            });

        </script>

    </body>
</html>
