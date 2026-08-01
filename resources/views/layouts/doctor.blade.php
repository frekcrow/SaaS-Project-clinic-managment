<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

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
        <div class="min-h-screen flex relative overflow-hidden">

            <!-- Floating Sidebar (RTL) -->
            <aside
                x-data="{ expanded: false }"
                @mouseenter="expanded = true"
                @mouseleave="expanded = false"
                :class="expanded ? 'w-64' : 'w-20'"
                class="hidden md:flex flex-col m-4 h-[calc(100vh-2rem)] bg-slate-900 shadow-xl border border-slate-800 rounded-3xl transition-all duration-300 ease-in-out z-20 flex-shrink-0"
            >
                <div class="h-20 flex items-center justify-center px-4 border-b border-slate-800">
                    <!-- Icon always visible -->
                    <svg class="w-8 h-8 text-teal-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <!-- Text visible on hover -->
                    <span x-show="expanded" x-transition.opacity.duration.300ms class="mr-3 text-xl font-bold text-white whitespace-nowrap">
                        د. {{ Auth::user()->name ?? 'الطبيب' }}
                    </span>
                </div>

                <nav class="flex-1 px-3 py-4 space-y-2 overflow-y-auto overflow-x-hidden custom-scrollbar">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-2xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-teal-400' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span x-show="expanded" x-transition.opacity.duration.300ms class="mr-4 font-medium whitespace-nowrap">لوحة التحكم</span>
                    </a>

                    <a href="{{ route('doctor.patients.index') }}" class="flex items-center px-3 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.patients.*') ? 'bg-slate-800 text-teal-400' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span x-show="expanded" x-transition.opacity.duration.300ms class="mr-4 font-medium whitespace-nowrap">ملفات المرضى</span>
                    </a>

                    <a href="{{ route('doctor.surgeries.index') }}" class="flex items-center px-3 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.surgeries.*') ? 'bg-slate-800 text-teal-400' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10m-5-4v4m0-4V7a2 2 0 00-2-2H8a2 2 0 00-2 2v10h8V7m-4-2V3a1 1 0 00-1-1H9a1 1 0 00-1 1v2"></path></svg>
                        <span x-show="expanded" x-transition.opacity.duration.300ms class="mr-4 font-medium whitespace-nowrap">العمليات</span>
                    </a>

                    <a href="{{ route('doctor.billing.index') }}" class="flex items-center px-3 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.billing.*') ? 'bg-slate-800 text-teal-400' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        <span x-show="expanded" x-transition.opacity.duration.300ms class="mr-4 font-medium whitespace-nowrap">الحسابات والفوترة</span>
                    </a>

                    <a href="{{ route('appointments.index') }}" class="flex items-center px-3 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-2xl transition-all duration-200 group {{ request()->routeIs('appointments.*') ? 'bg-slate-800 text-teal-400' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span x-show="expanded" x-transition.opacity.duration.300ms class="mr-4 font-medium whitespace-nowrap">تقويم المواعيد</span>
                    </a>

                    <a href="{{ route('doctor.prescriptions.index') }}" class="flex items-center px-3 py-3 {{ request()->routeIs('doctor.prescriptions.*') ? 'bg-teal-500/10 text-teal-400' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-2xl transition-all duration-200 group">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span x-show="expanded" x-transition.opacity.duration.300ms class="mr-4 font-medium whitespace-nowrap">تهيئة الوصفات</span>
                    </a>

                    <a href="{{ route('doctor.medications.index') }}" class="flex items-center px-3 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.medications.*') ? 'bg-slate-800 text-teal-400' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        <span x-show="expanded" x-transition.opacity.duration.300ms class="mr-4 font-medium whitespace-nowrap">الأدوية</span>
                    </a>

                    <a href="{{ route('settings.index') }}" class="flex items-center px-3 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-2xl transition-all duration-200 group {{ request()->routeIs('settings.*') ? 'bg-slate-800 text-teal-400' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span x-show="expanded" x-transition.opacity.duration.300ms class="mr-4 font-medium whitespace-nowrap">الإعدادات</span>
                    </a>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
                <!-- Top Header (Floating) -->
                <header class="h-20 flex items-center justify-between px-6 sm:px-8 mt-4 mx-4 md:mx-6 z-10 flex-shrink-0 bg-white/40 backdrop-blur-md border border-white/20 rounded-3xl">

                    <!-- Right side: Notifications -->
                    <div class="flex items-center gap-4" x-data="notificationsDropdown()" @notification-read.window="fetchNotifications()">
                        <div class="relative">
                            <button @click="open = !open" class="p-2 bg-white rounded-full shadow-sm hover:bg-slate-50 transition-colors relative">
                                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full"></span>
                            </button>

                            <!-- Notifications Dropdown -->
                            <div x-show="open" @click.away="open = false" x-transition class="absolute top-12 right-0 w-80 bg-white shadow-xl rounded-2xl border border-slate-100 py-2 z-50 overflow-hidden">
                                <div class="px-4 py-2 border-b border-slate-100 flex justify-between items-center">
                                    <h3 class="font-bold text-slate-800">الإشعارات</h3>
                                    <button x-show="unreadCount > 0" @click="markAllAsRead" class="text-xs text-indigo-600 hover:text-indigo-800">تحديد الكل كمقروء</button>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <template x-if="notifications.length === 0">
                                        <div class="p-4 text-center text-slate-500 text-sm">لا توجد إشعارات</div>
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
                    <div class="flex-1 flex justify-center px-4">
                        <div class="w-full max-w-md relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" class="w-full bg-white border-[1.5px] border-black/80 rounded-full shadow-sm py-2.5 pr-11 pl-4 focus:ring-2 focus:ring-teal-500/50 focus:outline-none text-sm text-slate-700 placeholder-slate-400 transition-shadow" placeholder="ابحث هنا...">
                        </div>
                    </div>

                    <!-- Profile Area (Top Left in RTL) -->
                    <div class="flex items-center" x-data="{ open: false }">
                        <!-- Dropdown Trigger -->
                        <button @click="open = !open" class="flex items-center space-x-3 space-x-reverse focus:outline-none bg-white shadow-sm hover:bg-slate-50 rounded-full py-1 pr-1 pl-4 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-slate-900 text-teal-400 flex items-center justify-center font-bold shadow-sm overflow-hidden">
                                @if(Auth::user()->avatar_path)
                                    <img src="{{ Storage::url(Auth::user()->avatar_path) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                                @endif
                            </div>
                            <div class="flex flex-col items-start hidden sm:flex">
                                <span class="text-sm font-semibold text-slate-800">د. {{ Auth::user()->name ?? 'الطبيب' }}</span>
                                <span class="text-xs text-slate-500">{{ Auth::user()->clinic_name ?? 'عيادة الشفاء' }}</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" x-transition class="absolute top-16 left-6 w-48 bg-white shadow-lg rounded-2xl border border-slate-100 py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-teal-600 transition-colors">الملف الشخصي</a>
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
