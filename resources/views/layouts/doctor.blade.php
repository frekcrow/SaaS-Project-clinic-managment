<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=tajawal:300,400,500,700,800,900&display=swap" rel="stylesheet" />

        <!-- Flatpickr for Date Inputs -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] { display: none !important; }
        </style>
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800">
        <x-dynamic-island />
        <div x-data="{ isCollapsed: {{ request()->routeIs('dashboard') ? 'false' : 'true' }}, mobileMenuOpen: false }" class="flex h-screen bg-gray-50 overflow-hidden">

            <!-- Mobile Backdrop -->
            <div x-show="mobileMenuOpen" class="fixed inset-0 z-50 bg-gray-800 bg-opacity-50 md:hidden" @click="mobileMenuOpen = false" x-cloak></div>

            <!-- Floating Sidebar (RTL) -->
            <aside
                :class="isCollapsed ? 'md:w-20' : 'md:w-44'"
                class="hidden md:flex md:flex-col md:flex-shrink-0 md:fixed md:inset-y-0 md:z-40 bg-slate-900 shadow-xl border-e border-slate-800 transition-all duration-300 ease-in-out start-0 md:translate-x-0 rtl:md:translate-x-0 ltr:md:translate-x-0"
            >
                @include('layouts.partials.doctor-sidebar-nav')
            </aside>

            <!-- Mobile Sidebar -->
            <aside x-show="mobileMenuOpen" x-transition x-cloak class="fixed inset-y-0 start-0 z-[60] flex flex-col w-64 bg-slate-900 shadow-xl border-e border-slate-800 md:hidden">
                @include('layouts.partials.doctor-sidebar-nav')
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 transition-all duration-300 h-screen overflow-hidden {{ request()->routeIs('dashboard') ? 'md:ms-44' : 'md:ms-20' }}" :class="isCollapsed ? 'md:ms-20' : 'md:ms-44'">
                <!-- Top Header (Floating) -->
                <header class="relative z-[70] h-20 flex items-center justify-between px-6 bg-white border-b border-slate-200 flex-shrink-0">

                    <!-- Mobile Menu Toggle & Logo -->
                    <div class="flex items-center gap-2 md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-slate-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <img src="{{ asset('images/logo-icon.png') }}" class="h-8 w-auto" alt="Logo Icon">
                    </div>

                    <!-- Dynamic Header Logo -->
                    <div class="hidden md:flex items-center gap-2" x-cloak x-show="isCollapsed" x-transition.opacity.duration.300ms>
                        <img src="{{ asset('images/logo-icon.png') }}" class="h-8 w-auto" alt="Logo Icon">
                        <img src="{{ asset('images/logo-text.png') }}" class="h-8 w-auto" alt="Logo Text">
                    </div>

                    <!-- Right side: Notifications -->
                    <div class="flex items-center gap-4" x-data="notificationsDropdown()" @notification-read.window="fetchNotifications()">
                        <div class="relative">
                            <button @click="open = !open" class="p-2 bg-white rounded-full shadow-sm hover:bg-slate-50 transition-colors relative">
                                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute top-0 end-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform rtl:translate-x-1/4 ltr:-translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full"></span>
                            </button>

                            <!-- Notifications Dropdown -->
                            <div x-cloak x-show="open" @click.away="open = false" x-transition class="absolute top-full mt-2 start-0 ms-2 max-w-xs w-80 !bg-white opacity-100 shadow-xl rounded-2xl border border-slate-100 py-2 z-[60]">
                                <div class="px-4 py-2 border-b border-slate-100 flex justify-between items-center">
                                    <h3 class="font-bold text-slate-800">{{ __('الإشعارات') }}</h3>
                                    <button x-show="unreadCount > 0" @click="markAllAsRead" class="text-xs text-indigo-600 hover:text-indigo-800">{{ __('تحديد الكل كمقروء') }}</button>
                                </div>
                                <div class="max-h-80 overflow-y-auto">
                                    <template x-if="notifications.length === 0">
                                        <div class="p-4 text-center text-slate-500 text-sm">{{ __('لا توجد إشعارات') }}</div>
                                    </template>
                                    <template x-for="notif in notifications" :key="notif.id">
                                        <div class="px-4 py-3 border-b border-slate-50 hover:bg-slate-50 transition-colors flex items-start gap-3 cursor-pointer" :class="{'bg-slate-50': !notif.read_at}" @click="markAsRead(notif.id)">
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
                                            <div x-show="!notif.read_at" class="flex-shrink-0 w-2 h-2 rounded-full bg-red-500 mt-2"></div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Floating Search Bar (Center-ish) -->
                    <div class="flex-1 flex justify-center px-4" x-data="globalSearch()">
                        <div class="w-auto relative" @click.away="open = false">
                            <div class="absolute inset-y-0 end-0 flex items-center pe-4 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" x-model="query" @input.debounce.300ms="search" @focus="open = true" class="w-32 focus:w-full md:w-64 md:focus:w-80 transition-all duration-300 bg-white border-[1.5px] border-black/80 rounded-full shadow-sm py-2.5 pe-11 ps-4 focus:ring-2 focus:ring-teal-500/50 focus:outline-none text-sm text-slate-700 placeholder-slate-400 transition-shadow" placeholder="{{ __('بحث') }}...">

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
                    <div class="flex items-center" x-data="{ open: false }">
                        <!-- Dropdown Trigger -->
                        <button @click="open = !open" class="flex items-center space-x-3 rtl:space-x-reverse focus:outline-none bg-white shadow-sm hover:bg-slate-50 rounded-full py-1 pe-1 ps-4 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-slate-900 text-teal-400 flex items-center justify-center font-bold shadow-sm overflow-hidden">
                                @if(Auth::user()->avatar_path)
                                    <img src="{{ Storage::url(Auth::user()->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                                @endif
                            </div>
                            <div class="flex flex-col items-start hidden sm:flex">
                                <span class="text-sm font-semibold text-slate-800">{{ __('د') }}. {{ Auth::user()->name ?? __('الطبيب') }}</span>
                                <span class="text-xs text-slate-500">{{ Auth::user()->clinic_name ?? __('عيادة الشفاء') }}</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-cloak x-show="open" @click.away="open = false" x-transition class="absolute top-full end-0 mt-2 origin-top-end w-48 bg-white shadow-lg rounded-2xl border border-slate-100 py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-teal-600 transition-colors">{{ __('الملف الشخصي') }}</a>
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
        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 4px;
            }
            .custom-scrollbar:hover::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.2);
            }
        </style>
    </body>
</html>
