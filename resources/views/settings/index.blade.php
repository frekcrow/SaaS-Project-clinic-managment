<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('الاعدادات') }}
        </h2>
    </x-slot>

        <div class="py-12" >
        <div x-data="{ activeTab: 'profile', currentTheme: localStorage.getItem('theme') || 'default', setTheme(theme) { this.currentTheme = theme; localStorage.setItem('theme', theme); document.documentElement.setAttribute('data-theme', theme); } }" class="flex flex-col space-y-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Subscription Details Card -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm mb-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">{{ __('تفاصيل الاشتراك') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 bg-slate-50 rounded-2xl">
                        <p class="text-sm text-slate-500 mb-1">{{ __('الخطة الحالية') }}</p>
                        <p class="font-bold text-slate-800">{{ ucfirst(auth()->user()->tenant->subscription_plan ?? 'N/A') }}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl">
                        <p class="text-sm text-slate-500 mb-1">{{ __('تاريخ الانتهاء') }}</p>
                        <p class="font-bold text-slate-800">{{ auth()->user()->tenant->subscription_expires_at ? (is_string(auth()->user()->tenant->subscription_expires_at) ? \Carbon\Carbon::parse(auth()->user()->tenant->subscription_expires_at)->format('Y-m-d') : auth()->user()->tenant->subscription_expires_at->format('Y-m-d')) : __('مدى الحياة') }}</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl flex flex-col justify-center">
                        <p class="text-sm text-slate-500 mb-1">{{ __('الحالة') }}</p>
                        <div>
                            @if(!auth()->user()->tenant->hasValidSubscription())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">{{ __('منتهي') }}</span>
                            @elseif(auth()->user()->tenant->subscription_expires_at && (is_string(auth()->user()->tenant->subscription_expires_at) ? \Carbon\Carbon::parse(auth()->user()->tenant->subscription_expires_at)->diffInDays(now()) < 7 : auth()->user()->tenant->subscription_expires_at->diffInDays(now()) < 7))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">{{ __('ينتهي قريباً') }}</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ __('نشط') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Global Actions Area -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-2">
                <!-- Broadcasting Button -->
                <a href="{{ route('secretary.broadcast.index') }}" class="w-full px-4 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl font-bold text-white hover:opacity-90 transition-opacity shadow-sm flex items-center justify-center gap-2 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    {{ __('البث الشامل') }}
                </a>

                @if(auth()->user()->role === 'Secretary' && auth()->user()->is_main_account)
                <!-- Add Sub-Secretary -->
                <a href="{{ route('settings.sub-secretary.create') }}" class="w-full px-4 py-3 bg-indigo-600 rounded-2xl font-bold text-white hover:bg-indigo-700 transition-colors shadow-sm flex items-center justify-center gap-2 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    {{ __('سيكرتير فرعي') }}
                </a>
                @endif

                <!-- About Button -->
                <div x-data="{ openAboutModal: false }" class="w-full h-full">
                    <button @click="openAboutModal = true" type="button" class="w-full h-full px-4 py-3 bg-white border border-slate-300 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm flex items-center justify-center gap-2 text-sm">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ __('حول النظام') }}
                    </button>

                    <div x-show="openAboutModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="openAboutModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="openAboutModal = false"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div x-show="openAboutModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="w-full max-w-md mx-auto bg-white rounded-2xl p-6 shadow-xl relative inline-block align-bottom text-center overflow-hidden transform transition-all sm:my-8 sm:align-middle border border-slate-100">
                                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 mb-4">
                                    <svg class="h-10 w-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <h3 class="text-2xl font-bold text-slate-800 mb-2">Version 1.0.0</h3>
                                <p class="text-slate-500 mb-6">{{ __('نظام متكامل لإدارة العيادات الطبية، مصمم بأحدث التقنيات لتقديم تجربة مستخدم سلسة وعصرية') }}.</p>
                                <p class="text-sm text-slate-400 mb-6">© {{ date('Y') }} {{ __('جميع الحقوق محفوظة') }}.</p>

                                <button @click="openAboutModal = false" type="button" class="w-full justify-center rounded-2xl border border-slate-300 shadow-sm px-4 py-3 bg-white text-base font-bold text-slate-700 hover:bg-slate-50 focus:outline-none transition-colors">
                                    {{ __('إغلاق') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="w-full h-full">
                    @csrf
                    <button type="submit" class="w-full h-full px-4 py-3 bg-white border border-slate-300 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm flex items-center justify-center gap-2 text-sm">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        {{ __('تسجيل خروج') }}
                    </button>
                </form>
            </div>

            <!-- Tabs Navigation -->
            <div class="flex gap-4 border-b border-slate-200 pb-4 mb-4 overflow-x-auto whitespace-nowrap custom-scrollbar">
                <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'bg-indigo-50 text-indigo-600 border-indigo-200' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'" class="px-6 py-2.5 rounded-2xl font-bold border transition-colors flex-shrink-0">
                    {{ __('الملف الشخصي') }}
                </button>
                <button @click="activeTab = 'clinic'" :class="activeTab === 'clinic' ? 'bg-indigo-50 text-indigo-600 border-indigo-200' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'" class="px-6 py-2.5 rounded-2xl font-bold border transition-colors flex-shrink-0">
                    {{ __('تهيئة العيادة') }}
                </button>
                <button @click="activeTab = 'themes'" :class="activeTab === 'themes' ? 'bg-indigo-50 text-indigo-600 border-indigo-200' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'" class="px-6 py-2.5 rounded-2xl font-bold border transition-colors flex-shrink-0">
                    {{ __('السمات (Themes)') }}
                </button>
            </div>
            <form id="reset-usage-form" method="POST" action="{{ route('settings.reset_usage') }}" class="hidden">
                @csrf
            </form>

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-2xl relative shadow-sm" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl relative shadow-sm" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div x-show="activeTab === 'profile'" x-cloak class="space-y-8">
            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Profile Information Card -->
                <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-white/20">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">{{ __('المعلومات الشخصية') }}</h3>

                    <div class="flex flex-col gap-8">
                        <!-- Avatar Section -->
                        <div class="flex flex-col items-center justify-start space-y-4 col-span-1" x-data="avatarPreview()">
                            <div class="relative w-32 h-32 rounded-full border-4 border-indigo-50 shadow-md overflow-hidden bg-slate-100 flex items-center justify-center">
                                <template x-if="imageUrl">
                                    <img :src="imageUrl" class="w-full h-full object-cover" alt="Avatar Preview">
                                </template>
                                <template x-if="!imageUrl">
                                    @if($user->avatar_path)
                                        <img src="{{ Storage::url($user->avatar_path) }}" class="w-full h-full object-cover" alt="Avatar">
                                    @else
                                        <svg class="h-16 w-16 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    @endif
                                </template>
                            </div>
                            <label for="avatar" class="cursor-pointer bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-xl text-sm font-medium hover:bg-slate-50 hover:text-indigo-600 transition-colors shadow-sm">
                                {{ __('تغيير الصورة') }}
                            </label>
                            <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*" @change="fileChosen">
                            <p class="text-xs text-slate-400 mt-2">JPG, PNG, GIF {{ __('أقصى حجم') }} 2MB</p>
                        </div>

                        <!-- Info Inputs -->
                        <div class="col-span-1 md:col-span-2 space-y-6">
                            <div>
                                <x-input-label for="secretary_name" :value="__('اسم السكرتير/ة')" />
                                <x-text-input id="secretary_name" name="secretary_name" type="text" class="mt-1 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('secretary_name', $user->secretary_name)" />
                                <div class="mt-1 text-xs text-slate-500">{{ __('اسم المستخدم') }} ({{ __('للتسجيل') }}): {{ $user->name }}</div>
                            </div>

                            <div>
                                <x-input-label for="clinic_name" :value="__('اسم العيادة')" />
                                <x-text-input id="clinic_name" name="clinic_name" type="text" class="mt-1 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('clinic_name', $user->clinic_name)" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('البريد الإلكتروني (غير قابل للتعديل هنا)')" />
                                <x-text-input id="email" type="email" class="mt-1 block w-full rounded-2xl border-slate-200 bg-slate-100 shadow-sm text-slate-500 cursor-not-allowed" :value="$user->email" readonly disabled />
                            </div>

                            <div>
                                <x-input-label for="bio" :value="__('نبذة عن العيادة (Bio)')" />
                                <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 resize-none">{{ old('bio', $user->bio) }}</textarea>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="text-sm text-indigo-600 font-medium">
                                    @php
                                        $diff = $user->created_at->diffForHumans(['parts' => 3, 'join' => ' ' . __('و') . ' ']);
                                    @endphp
                                    {{ __('يعمل منذ') }}: {{ str_replace(['years', 'year', 'months', 'month', 'days', 'day', 'ago', 'hours', 'hour', 'minutes', 'minute', 'seconds', 'second'], [__('سنوات'), __('سنة'), __('أشهر'), __('شهر'), __('أيام'), __('يوم'), '', __('ساعات'), __('ساعة'), __('دقائق'), __('دقيقة'), __('ثواني'), __('ثانية')], $diff) }}
                                </div>
                                <button type="submit" form="reset-usage-form" class="text-xs px-3 py-1.5 border border-red-200 text-red-600 hover:bg-red-50 hover:border-red-300 rounded-lg transition-colors font-medium">
                                    {{ __('إعادة ضبط') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
                <div class="p-6 sm:p-8 bg-red-50/50 backdrop-blur-md shadow-sm sm:rounded-3xl border border-red-100 mt-8">
                    <div class="max-w-xl mx-auto flex flex-col items-center gap-4">
                        <p class="text-sm text-slate-600">{{ __("هل ترغب بحذف حسابك نهائياً من النظام؟") }}</p>
                        <a href="{{ route('profile.edit') }}" class="block w-full text-center px-4 py-3 bg-red-600 border border-transparent rounded-2xl font-bold text-white hover:bg-red-700 transition-colors shadow-sm">
                            {{ __('حذف الحساب') }}
                        </a>
                    </div>
                </div>
            </div>

            <div x-show="activeTab === 'clinic'" x-cloak class="space-y-8">
            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                <!-- Clinic Configuration Card -->
                <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-white/20">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">{{ __('إعدادات العيادة والحجوزات') }}</h3>

                    <div class="flex flex-col gap-6">
                        <div>
                            <x-input-label for="default_consultation_price" :value="__('سعر الكشفية الثابت (د.ع)')" />
                            <x-text-input id="default_consultation_price" name="default_consultation_price" type="number" step="0.01" class="mt-1 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('default_consultation_price', $user->default_consultation_price)" required />
                        </div>

                        <div x-data="{ enabled: {{ old('has_sessions_system', $user->has_sessions_system) ? 'true' : 'false' }} }">
                            <label class="inline-flex items-center cursor-pointer mt-8">
                                <input type="checkbox" name="has_sessions_system" value="1" class="sr-only peer" x-model="enabled">
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                <span class="mr-3 text-sm font-medium text-slate-700">{{ __('تفعيل نظام الجلسات') }}</span>
                            </label>

                            <div x-show="enabled" x-collapse class="mt-4">
                                <x-input-label for="default_session_price" :value="__('سعر الجلسة الثابت (د.ع)')" />
                                <x-text-input id="default_session_price" name="default_session_price" type="number" step="0.01" class="mt-1 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('default_session_price', $user->default_session_price)" />
                            </div>
                        </div>

                        <!-- System Language -->
                        <div class="col-span-2 mt-4 pt-6 border-t border-slate-100">
                            <h4 class="text-lg font-bold text-slate-800 mb-4">{{ __('لغة النظام') }} (System Language)</h4>
                            <x-input-label for="locale" :value="__('اختر لغة واجهة المستخدم')" />
                            <select id="locale" name="locale" class="mt-1 block w-full sm:w-1/2 rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-slate-700 font-medium">
                                <option value="ar" {{ old('locale', $user->locale ?? 'ar') === 'ar' ? 'selected' : '' }}>{{ __('العربية') }} (Arabic)</option>
                                <option value="en" {{ old('locale', $user->locale) === 'en' ? 'selected' : '' }}>English</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end pt-6">
                        <button type="submit" class="px-6 py-3 bg-black text-white font-bold rounded-2xl shadow-sm hover:bg-neutral-800 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                            {{ __('حفظ الإعدادات') }}
                        </button>
                    </div>
                </div>
            </form>



    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('avatarPreview', () => ({
                imageUrl: null,
                fileChosen(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.imageUrl = URL.createObjectURL(file);
                    }
                }
            }))
        })
    </script>
    @endpush

            <form id="language-switch-form" method="POST" action="{{ route('language.switch') }}" class="hidden">
                @csrf
                <input type="hidden" name="locale" id="hidden-locale-input">
            </form>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const localeSelect = document.getElementById("locale");
                    const hiddenLocaleInput = document.getElementById("hidden-locale-input");
                    if(localeSelect && hiddenLocaleInput) {
                        localeSelect.addEventListener("change", function() {
                            hiddenLocaleInput.value = this.value;
                            document.getElementById("language-switch-form").submit();
                        });
                    }
                });
            </script>

</x-app-layout>
