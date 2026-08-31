<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
    <title>{{ config('app.name', 'Atlas Clinic') }} - {{ __('تفعيل الاشتراك') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans text-gray-900 dark:text-gray-100 antialiased selection:bg-gray-900 selection:text-white">
    <div class="min-h-screen flex flex-col items-center justify-center p-4 bg-slate-50 dark:bg-gray-900 relative overflow-hidden">
        <!-- Back Arrow Logout Form -->
        <form method="POST" action="{{ route('logout') }}" class="absolute top-6 start-6 z-30">
            @csrf
            <button type="submit"
                    title="{{ __('تسجيل الخروج والعودة') }}"
                    aria-label="{{ __('تسجيل الخروج والعودة') }}"
                    class="group flex items-center justify-center w-11 h-11 rounded-2xl bg-white dark:bg-gray-800 hover:bg-slate-100 text-slate-700 dark:text-slate-300 hover:text-slate-900 border border-slate-200 dark:border-gray-700 shadow-sm dark:shadow-none hover:shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-slate-400 cursor-pointer">
                <svg class="w-5 h-5 transition-transform duration-200 group-hover:-translate-x-0.5 rtl:group-hover:translate-x-0.5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </button>
        </form>

        <!-- Decorative Ambient Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 from-indigo-50/50 via-slate-50 to-slate-100 pointer-events-none"></div>

        <!-- Header: Logo & Typography -->
        <div class="relative z-10 flex flex-col items-center text-center mb-8 max-w-md w-full">
            <img src="{{ asset('images/logo-text.png') }}" alt="Atlas" class="h-10 w-auto mb-6">
            <h2 class="text-3xl font-bold mb-2 font-sans text-slate-900 dark:text-slate-100 tracking-tight" style="font-family: 'Ping', sans-serif;">
                قم بأدخال رمز التفعيل الخاص بك
            </h2>
            <p class="text-sm text-gray-500 mb-10">
                يتم استلام رمز التفعيل من قبل فريق الدعم فقط
            </p>

            <!-- Status & Error Alert Messages -->
            @if (session('success'))
                <div class="w-full mb-6 p-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-200/60 shadow-sm dark:shadow-none text-center" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="w-full mb-6 p-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-200/60 shadow-sm dark:shadow-none text-center" role="alert">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Form & VisaCard Container -->
        <form method="POST" action="{{ route('activation.submit') }}" class="w-full max-w-md relative z-10 flex flex-col items-center">
            @csrf

            <!-- The VisaCard / Ticket UI -->
            <div class="w-full max-w-md aspect-[1.586/1] rounded-3xl p-8 relative overflow-hidden shadow-2xl dark:shadow-none bg-gradient-to-br dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 from-gray-900 via-slate-800 to-black text-white flex flex-col justify-between border border-white/10">
                <!-- Card Background Ambient Glow -->
                <div class="absolute -top-16 -right-16 w-48 h-48 bg-indigo-500/15 rounded-full filter blur-2xl pointer-events-none"></div>
                <div class="absolute -bottom-16 -left-16 w-48 h-48 bg-blue-500/15 rounded-full filter blur-2xl pointer-events-none"></div>

                <!-- Cutout Effect (Semi-circle cutout on RIGHT edge) -->
                <div class="w-12 h-12 rounded-full absolute top-1/2 -right-6 transform -translate-y-1/2 bg-slate-50 dark:bg-gray-900 pointer-events-none z-20"></div>

                <!-- Top Row: Smart Chip & Atlas Branding -->
                <div class="flex items-center justify-between relative z-10">
                    <!-- Smart Chip Icon -->
                    <div class="w-11 h-8 rounded-md bg-gradient-to-tr from-amber-300 via-amber-400 to-yellow-200 p-0.5 shadow-sm dark:shadow-none opacity-90 flex items-center justify-center relative border border-amber-500/30">
                        <div class="w-full h-full border border-amber-700/20 rounded-[3px] flex items-center justify-around px-1">
                            <div class="w-full h-[1px] bg-amber-800/20"></div>
                        </div>
                    </div>
                    <!-- Card Brand Header -->
                    <div class="flex items-center gap-2 text-white/70 text-xs font-semibold tracking-wider">
                        <span class="uppercase">Atlas License Card</span>
                        <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                    </div>
                </div>

                <!-- Center Row: Activation Code Input Field -->
                <div class="relative z-10 my-auto pt-4">
                    <label for="activation_code" class="block text-xs uppercase tracking-widest text-slate-400 mb-2">
                        {{ __('رمز التفعيل') }}
                    </label>
                    <input id="activation_code"
                           type="text"
                           name="activation_code"
                           value="{{ old('activation_code') }}"
                           required
                           autofocus
                           placeholder="ATLAS-XXXXXXXX..."
                           class="w-full bg-transparent border-b border-white/20 focus:border-white/70 dark:bg-gray-900 dark:text-white text-white text-2xl tracking-widest placeholder:text-gray-600 focus:outline-none focus:ring-0 py-2 transition transition-colors font-mono" />
                    <x-input-error :messages="$errors->get('activation_code')" class="mt-2 text-rose-400 text-xs" />
                </div>

                <!-- Bottom Row: Card Details Placeholder -->
                <div class="flex items-center justify-between relative z-10 text-xs text-slate-400">
                    <span>OFFICIAL SYSTEM LICENSE</span>
                    <span class="font-mono">SECURE DRM</span>
                </div>
            </div>

            <!-- Submit Button (Outside & below card) -->
            <button type="submit"
                    class="mt-8 w-full max-w-md bg-black text-white font-medium py-3.5 px-6 rounded-2xl hover:bg-slate-800 active:scale-[0.99] transition duration-200 text-center shadow-lg dark:shadow-none shadow-black/5 flex items-center justify-center text-base cursor-pointer">
                متابعة
            </button>
        </form>
    </div>
</body>
</html>
