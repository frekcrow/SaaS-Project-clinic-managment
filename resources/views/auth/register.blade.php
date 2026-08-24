<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
    <title>{{ config('app.name', 'Atlas Clinic') }} - {{ __('إنشاء حساب جديد') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-white selection:bg-gray-900 selection:text-white">
    <div class="min-h-screen grid lg:grid-cols-2">
        <!-- Left Column (Visuals) -->
        <div class="hidden lg:flex flex-col justify-between bg-slate-50 p-12 border-e border-slate-100 relative overflow-hidden">
            <!-- Decorative Subtle Pattern / Background Glow -->
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/50 via-slate-50 to-slate-100 pointer-events-none"></div>

            <div class="relative z-10 flex items-center gap-3">
                <img src="{{ asset('images/logo-icon.png') }}" alt="Atlas Logo" class="h-8 w-auto">
                <span class="font-bold text-xl text-slate-800 tracking-tight">Atlas Clinic</span>
            </div>

            <!-- Medical Illustration / Visual Placeholder -->
            <div class="relative z-10 flex flex-col items-center justify-center my-auto py-12">
                <div class="w-full max-w-lg aspect-square rounded-3xl bg-white/70 backdrop-blur-md shadow-xl border border-slate-200/60 p-8 flex flex-col items-center justify-center text-center relative overflow-hidden group hover:shadow-2xl transition-all duration-500">
                    <div class="absolute -top-24 -right-24 w-60 h-60 bg-blue-100 rounded-full filter blur-3xl opacity-60"></div>
                    <div class="absolute -bottom-24 -left-24 w-60 h-60 bg-indigo-100 rounded-full filter blur-3xl opacity-60"></div>

                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200 mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 00-1.18.104l-.84.336a2 2 0 00-1.28 1.86v.58c0 .53.43.96.96.96h17.44c.53 0 .96-.43.96-.96v-.58a2 2 0 00-.732-1.552zM12 11a4 4 0 100-8 4 4 0 000 8z"></path>
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-slate-800 mb-2" style="font-family: 'Ping', sans-serif;">نظام إدارة العيادات الذكي</h3>
                    <p class="text-slate-500 max-w-sm text-sm leading-relaxed">منصة شاملة ومتطورة لإدارة المواعيد، السجلات الطبية، والوصفات الطبية بكل سهولة وأمان.</p>
                </div>
            </div>

            <div class="relative z-10 text-xs text-slate-400">
                &copy; {{ date('Y') }} Atlas Clinic. جميع الحقوق محفوظة.
            </div>
        </div>

        <!-- Right Column (Form) -->
        <div class="flex flex-col justify-center px-8 sm:px-12 lg:px-16 py-12 bg-white">
            <div class="w-full max-w-lg mx-auto">
                <!-- Logo -->
                <div class="mb-6">
                    <img src="{{ asset('images/logo-text.png') }}" alt="Atlas" class="h-10 w-auto mb-6">
                </div>

                <!-- Greeting -->
                <h2 class="text-3xl font-bold mb-6 text-slate-900 tracking-tight" style="font-family: 'Ping', sans-serif;">
                    إنشاء حساب جديد
                </h2>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Form Grid Wrapper -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <!-- Row 1: Name & Clinic Name -->
                        <div class="space-y-1.5">
                            <label for="name" class="block text-sm font-medium text-slate-700">
                                {{ __('الاسم الكامل') }}
                            </label>
                            <input id="name"
                                   type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required
                                   autocomplete="name"
                                   placeholder="د. محمد أحمد"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition duration-200 text-slate-900 placeholder:text-slate-400 text-sm shadow-sm" />
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        <div class="space-y-1.5">
                            <label for="clinic_code" class="block text-sm font-medium text-slate-700">
                                {{ __('اسم العيادة') }}
                            </label>
                            <input id="clinic_code"
                                   type="text"
                                   name="clinic_code"
                                   value="{{ old('clinic_code') }}"
                                   required
                                   placeholder="e.g. clinic-dr-smith"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition duration-200 text-slate-900 placeholder:text-slate-400 text-sm shadow-sm" />
                            <x-input-error :messages="$errors->get('clinic_code')" class="mt-1" />
                        </div>

                        <!-- Row 2: Email & Gender -->
                        <div class="space-y-1.5">
                            <label for="email" class="block text-sm font-medium text-slate-700">
                                {{ __('البريد الإلكتروني') }}
                            </label>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="username"
                                   placeholder="doctor@example.com"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition duration-200 text-slate-900 placeholder:text-slate-400 text-sm shadow-sm" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <div class="space-y-1.5">
                            <label for="gender" class="block text-sm font-medium text-slate-700">
                                {{ __('الجنس') }}
                            </label>
                            <select id="gender"
                                    name="gender"
                                    required
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition duration-200 text-slate-900 text-sm shadow-sm bg-white">
                                <option value="" disabled {{ old('gender') ? '' : 'selected' }}>اختر الجنس</option>
                                <option value="ذكر" {{ old('gender') == 'ذكر' ? 'selected' : '' }}>ذكر</option>
                                <option value="أنثى" {{ old('gender') == 'أنثى' ? 'selected' : '' }}>أنثى</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-1" />
                        </div>

                        <!-- Row 3: Password & Password Confirmation -->
                        <div class="space-y-1.5">
                            <label for="password" class="block text-sm font-medium text-slate-700">
                                {{ __('كلمة المرور') }}
                            </label>
                            <input id="password"
                                   type="password"
                                   name="password"
                                   required
                                   autocomplete="new-password"
                                   placeholder="••••••••"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition duration-200 text-slate-900 placeholder:text-slate-400 text-sm shadow-sm" />
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <div class="space-y-1.5">
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700">
                                {{ __('تأكيد كلمة المرور') }}
                            </label>
                            <input id="password_confirmation"
                                   type="password"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password"
                                   placeholder="••••••••"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition duration-200 text-slate-900 placeholder:text-slate-400 text-sm shadow-sm" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>

                        <!-- Row 4: Role (Spans 2 columns) -->
                        <div class="col-span-1 sm:col-span-2 space-y-1.5">
                            <label for="role" class="block text-sm font-medium text-slate-700">
                                {{ __('الصفة / الدور') }}
                            </label>
                            <select id="role"
                                    name="role"
                                    required
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition duration-200 text-slate-900 text-sm shadow-sm bg-white">
                                <option value="Doctor" {{ old('role') == 'Doctor' ? 'selected' : '' }}>طبيب</option>
                                <option value="Secretary" {{ old('role') == 'Secretary' ? 'selected' : '' }}>سكرتير / سكرتيرة</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                                class="w-full bg-black text-white font-medium py-3 px-6 rounded-2xl hover:bg-slate-800 active:scale-[0.99] transition duration-200 text-center shadow-lg shadow-black/5 flex items-center justify-center text-base">
                            إنشاء حساب
                        </button>
                    </div>

                    <!-- Footer Link -->
                    <div class="text-center mt-5">
                        <a href="{{ route('login') }}" class="text-sm text-slate-600 hover:text-black font-medium transition">
                            لديك حساب بالفعل؟ تسجيل الدخول
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
