<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
    <title>{{ config('app.name', 'Atlas Clinic') }} - {{ __('تسجيل الدخول') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans text-gray-900 dark:text-gray-100 antialiased bg-white dark:bg-gray-800 selection:bg-gray-900 selection:text-white">
    <div class="min-h-screen grid lg:grid-cols-2">
        <!-- Left Column (Visuals) -->
        <div class="hidden lg:flex flex-col justify-between bg-slate-50 dark:bg-gray-900 p-12 border-e border-slate-100 dark:border-gray-700 relative overflow-hidden">
            <!-- Decorative Subtle Pattern / Background Glow -->
            <div class="absolute inset-0 bg-gradient-to-br dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 from-indigo-50/50 via-slate-50 to-slate-100 pointer-events-none"></div>

            <div class="relative z-10 flex items-center gap-3">
                <img src="{{ asset('images/logo-icon.png') }}" alt="Atlas Logo" class="h-8 w-auto">
                <span class="font-bold text-xl text-slate-800 dark:text-slate-200 tracking-tight">Atlas Clinic</span>
            </div>

            <!-- Medical Illustration / Visual Placeholder -->
            <div class="relative z-10 flex flex-col items-center justify-center my-auto py-12">
                <div class="w-full max-w-lg aspect-square rounded-3xl bg-white/70 dark:bg-gray-800 backdrop-blur-md shadow-xl dark:shadow-none border border-slate-200/60 p-8 flex flex-col items-center justify-center text-center relative overflow-hidden group hover:shadow-2xl transition-all duration-500 dark:backdrop-blur-none">
                    <div class="absolute -top-24 -right-24 w-60 h-60 bg-blue-100 rounded-full filter blur-3xl opacity-60"></div>
                    <div class="absolute -bottom-24 -left-24 w-60 h-60 bg-indigo-100 rounded-full filter blur-3xl opacity-60"></div>

                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-lg dark:shadow-none shadow-indigo-200 mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 00-1.18.104l-.84.336a2 2 0 00-1.28 1.86v.58c0 .53.43.96.96.96h17.44c.53 0 .96-.43.96-.96v-.58a2 2 0 00-.732-1.552zM12 11a4 4 0 100-8 4 4 0 000 8z"></path>
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-200 mb-2" style="font-family: 'Ping', sans-serif;">نظام إدارة العيادات الذكي</h3>
                    <p class="text-slate-500 max-w-sm text-sm leading-relaxed">منصة شاملة ومتطورة لإدارة المواعيد، السجلات الطبية، والوصفات الطبية بكل سهولة وأمان.</p>
                </div>
            </div>

            <div class="relative z-10 text-xs text-slate-400">
                &copy; {{ date('Y') }} Atlas Clinic. جميع الحقوق محفوظة.
            </div>
        </div>

        <!-- Right Column (Form) -->
        <div class="flex flex-col justify-center px-8 sm:px-12 lg:px-24 py-12 bg-white dark:bg-gray-800">
            <div class="w-full max-w-md mx-auto">
                <!-- Logo -->
                <div class="mb-8">
                    <img src="{{ asset('images/logo-text.png') }}" alt="Atlas" class="h-10 w-auto">
                </div>

                <!-- Greeting -->
                <h2 class="text-3xl font-bold mb-8 text-slate-900 dark:text-slate-100 tracking-tight" style="font-family: 'Ping', sans-serif;">
                    مرحباً بك من جديد
                </h2>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ __('البريد الإلكتروني') }}
                        </label>
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="doctor@example.com"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-gray-700 focus:outline-none focus:ring-2 dark:bg-gray-900 dark:text-white focus:ring-black focus:border-transparent transition duration-200 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 text-sm shadow-sm dark:shadow-none" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                {{ __('كلمة المرور') }}
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-slate-500 hover:text-black font-medium transition">
                                    {{ __('نسيت كلمة المرور؟') }}
                                </a>
                            @endif
                        </div>
                        <input id="password"
                               type="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-gray-700 focus:outline-none focus:ring-2 dark:bg-gray-900 dark:text-white focus:ring-black focus:border-transparent transition duration-200 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 text-sm shadow-sm dark:shadow-none" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me"
                                   type="checkbox"
                                   name="remember"
                                   class="rounded border-slate-300 dark:border-gray-600 text-black dark:text-white shadow-sm dark:shadow-none focus:ring-black dark:bg-gray-900 focus:ring-offset-0 h-4 w-4">
                            <span class="ms-2 text-sm text-slate-600 dark:text-slate-400">{{ __('تذكرني') }}</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                                class="w-full bg-black text-white font-medium py-3.5 px-6 rounded-2xl hover:bg-slate-800 active:scale-[0.99] transition duration-200 text-center shadow-lg dark:shadow-none shadow-black/5 flex items-center justify-center text-base">
                            متابعة
                        </button>
                    </div>

                    <!-- Footer Text -->
                    <p class="text-sm text-gray-500 text-center mt-6 leading-relaxed">
                        بالضغط على زر متابعة انت توافق على سياسة خصوصية وشروط الخدمة
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
