<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('الاعدادات') }}
        </h2>
    </x-slot>

        <div class="py-12" >
        <div x-data="{ activeTab: 'profile', currentTheme: localStorage.getItem('theme') || 'default', setTheme(theme) { this.currentTheme = theme; localStorage.setItem('theme', theme); document.documentElement.setAttribute('data-theme', theme); } }" class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Global Actions Area -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 mb-2">
                <!-- About Button -->
                <div x-data="{ openAboutModal: false }" class="w-full h-full">
                    <button @click="openAboutModal = true" type="button" class="w-full h-full px-4 py-3 bg-white border border-slate-300 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm flex items-center justify-center gap-2 text-sm">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ __('حول النظام') }}
                    </button>

                    <!-- Alpine.js Modal for About -->
                    <div x-show="openAboutModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="openAboutModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="openAboutModal = false"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div x-show="openAboutModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-3xl text-center overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-100 p-8">
                                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 mb-4">
                                    <svg class="h-10 w-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <h3 class="text-2xl font-bold text-slate-800 mb-2">Atlas System v1.0</h3>
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
            <form id="reset-usage-form" method="POST" action="{{ route('doctor.settings.reset_usage') }}" class="hidden">
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
            <form method="POST" action="{{ route('doctor.settings.update') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Profile Information Card -->
                <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-white/20">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">{{ __('المعلومات الشخصية') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
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
                                <x-input-label for="name" :value="__('اسم الطبيب/ة')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('name', $user->name)" />
                            </div>

                            <div>
                                <x-input-label for="clinic_name" :value="__('اسم العيادة')" />
                                <x-text-input id="clinic_name" name="clinic_name" type="text" class="mt-1 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('clinic_name', $user->clinic_name)" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('البريد الإلكتروني')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('email', $user->email)" required />
                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <p class="text-sm mt-2 text-yellow-600">
                                        {{ __('بريدك الإلكتروني غير موثق. يرجى توثيقه.') }}
                                    </p>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="password" :value="__('كلمة المرور الجديدة (اختياري)')" />
                                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" autocomplete="new-password" />
                                </div>
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('تأكيد كلمة المرور')" />
                                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>
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

                <!-- Clinic Configuration Card -->
                <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-white/20">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">{{ __('إعدادات العيادة والحجوزات') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-black text-white font-bold rounded-2xl shadow-sm hover:bg-neutral-800 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                        {{ __('حفظ الإعدادات') }}
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Session Types Management -->
                <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-slate-100">
                    <div class="w-full">
                        <h4 class="text-lg font-bold text-slate-800 mb-4">{{ __('أنواع الجلسات') }} (Session Types)</h4>

                        <form method="POST" action="{{ route('doctor.settings.session-types.store') }}" class="flex gap-2 mb-6">
                            @csrf
                            <input type="text" name="name" placeholder="{{ __('أضف نوع جلسة جديد') }}..." class="flex-1 rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <button type="submit" class="px-6 py-2 bg-black text-white rounded-2xl font-bold shadow-sm hover:bg-neutral-800 transition-colors">{{ __('إضافة') }}</button>
                        </form>

                        <div class="space-y-2">
                            @forelse($sessionTypes as $type)
                                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                                    <span class="font-medium text-slate-700">{{ $type->name }}</span>
                                    <form method="POST" action="{{ route('doctor.settings.session-types.destroy', $type->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1" onclick="return confirm('{{ __('هل أنت متأكد من الحذف؟') }}')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <p class="text-center text-slate-500 py-4">{{ __('لا توجد أنواع جلسات مضافة') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Surgery Types Management -->
                <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-slate-100">
                    <div class="w-full">
                        <h4 class="text-lg font-bold text-slate-800 mb-4">{{ __('أنواع العمليات') }} (Surgery Types)</h4>

                        <form method="POST" action="{{ route('doctor.settings.surgery-types.store') }}" class="flex gap-2 mb-6">
                            @csrf
                            <input type="text" name="name" placeholder="{{ __('أضف نوع عملية جديد') }}..." class="flex-1 rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <button type="submit" class="px-6 py-2 bg-black text-white rounded-2xl font-bold shadow-sm hover:bg-neutral-800 transition-colors">{{ __('إضافة') }}</button>
                        </form>

                        <div class="space-y-2">
                            @forelse($surgeryTypes as $type)
                                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                                    <span class="font-medium text-slate-700">{{ $type->name }}</span>
                                    <form method="POST" action="{{ route('doctor.settings.surgery-types.destroy', $type->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1" onclick="return confirm('{{ __('هل أنت متأكد من الحذف؟') }}')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <p class="text-center text-slate-500 py-4">{{ __('لا توجد أنواع عمليات مضافة') }}</p>
                            @endforelse
                    </div>
                </div>
            </div>
            </form>

                <!-- Session Types Management -->
                <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-slate-100">
                    <div class="w-full">
                        <h4 class="text-lg font-bold text-slate-800 mb-4">{{ __('أنواع الجلسات') }} (Session Types)</h4>

                        <form method="POST" action="{{ route('doctor.settings.session-types.store') }}" class="flex gap-2 mb-6">
                            @csrf
                            <input type="text" name="name" placeholder="{{ __('أضف نوع جلسة جديد') }}..." class="flex-1 rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <button type="submit" class="px-6 py-2 bg-black text-white rounded-2xl font-bold shadow-sm hover:bg-neutral-800 transition-colors">{{ __('إضافة') }}</button>
                        </form>

                        <div class="space-y-2">
                            @forelse($sessionTypes as $type)
                                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                                    <span class="font-medium text-slate-700">{{ $type->name }}</span>
                                    <form method="POST" action="{{ route('doctor.settings.session-types.destroy', $type->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1" onclick="return confirm('{{ __('هل أنت متأكد من الحذف؟') }}')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <p class="text-center text-slate-500 py-4">{{ __('لا توجد أنواع جلسات مضافة') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Surgery Types Management -->
                <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-slate-100">
                    <div class="w-full">
                        <h4 class="text-lg font-bold text-slate-800 mb-4">{{ __('أنواع العمليات') }} (Surgery Types)</h4>

                        <form method="POST" action="{{ route('doctor.settings.surgery-types.store') }}" class="flex gap-2 mb-6">
                            @csrf
                            <input type="text" name="name" placeholder="{{ __('أضف نوع عملية جديد') }}..." class="flex-1 rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <button type="submit" class="px-6 py-2 bg-black text-white rounded-2xl font-bold shadow-sm hover:bg-neutral-800 transition-colors">{{ __('إضافة') }}</button>
                        </form>

                        <div class="space-y-2">
                            @forelse($surgeryTypes as $type)
                                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                                    <span class="font-medium text-slate-700">{{ $type->name }}</span>
                                    <form method="POST" action="{{ route('doctor.settings.surgery-types.destroy', $type->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1" onclick="return confirm('{{ __('هل أنت متأكد من الحذف؟') }}')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <p class="text-center text-slate-500 py-4">{{ __('لا توجد أنواع عمليات مضافة') }}</p>
                            @endforelse
            </div>
            </div>
            </div>

            <!-- Themes Tab -->
            <div x-show="activeTab === 'themes'" x-cloak class="space-y-6">
                <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-white/20">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">{{ __('السمات') }} (Themes)</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <button @click="setTheme('default')" :class="currentTheme === 'default' ? 'ring-2 ring-indigo-500 border-indigo-500 bg-indigo-50/50' : 'border-slate-200 hover:border-indigo-300 hover:bg-slate-50 bg-white'" class="p-4 rounded-2xl border flex items-center justify-between transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200">
                                    <div class="w-4 h-4 rounded-full bg-slate-800"></div>
                                </div>
                                <span class="font-bold text-slate-700">{{ __('الافتراضي') }} (Default)</span>
                            </div>
                            <svg x-show="currentTheme === 'default'" class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>

                        <button @click="setTheme('dark')" :class="currentTheme === 'dark' ? 'ring-2 ring-indigo-500 border-indigo-500 bg-slate-800' : 'border-slate-200 hover:border-slate-700 hover:bg-slate-800 bg-slate-900'" class="p-4 rounded-2xl border flex items-center justify-between transition-all group">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center border border-slate-600">
                                    <div class="w-4 h-4 rounded-full bg-gray-300"></div>
                                </div>
                                <span class="font-bold text-white group-hover:text-white">{{ __('الوضع الداكن') }} (Dark)</span>
                            </div>
                            <svg x-show="currentTheme === 'dark'" class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>

                        <button @click="setTheme('ocean')" :class="currentTheme === 'ocean' ? 'ring-2 ring-[#0077b6] border-[#0077b6] bg-[#e6f7ff]' : 'border-[#b3e0ff] hover:border-[#0077b6] hover:bg-[#e6f7ff] bg-[#f0f8ff]'" class="p-4 rounded-2xl border flex items-center justify-between transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center border border-[#b3e0ff]">
                                    <div class="w-4 h-4 rounded-full bg-[#004d66]"></div>
                                </div>
                                <span class="font-bold text-[#004d66]">{{ __('محيطي') }} (Ocean)</span>
                            </div>
                            <svg x-show="currentTheme === 'ocean'" class="w-6 h-6 text-[#0077b6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>

                        <button @click="setTheme('nature')" :class="currentTheme === 'nature' ? 'ring-2 ring-[#2d6a4f] border-[#2d6a4f] bg-[#e8f5e9]' : 'border-[#cce3de] hover:border-[#2d6a4f] hover:bg-[#e8f5e9] bg-[#f5fcf5]'" class="p-4 rounded-2xl border flex items-center justify-between transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center border border-[#cce3de]">
                                    <div class="w-4 h-4 rounded-full bg-[#1b4332]"></div>
                                </div>
                                <span class="font-bold text-[#1b4332]">{{ __('طبيعي') }} (Nature)</span>
                            </div>
                            <svg x-show="currentTheme === 'nature'" class="w-6 h-6 text-[#2d6a4f]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
                </div>

                <!-- Account Management (Danger Zone) -->
                <div class="p-6 sm:p-8 bg-red-50/50 backdrop-blur-md shadow-sm sm:rounded-3xl border border-red-100">
                    <div class="w-full space-y-4">
                        <h4 class="text-lg font-bold text-red-800 mb-4 text-center">{{ __('إدارة الحساب') }}</h4>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full text-center px-4 py-3 bg-white border border-red-200 rounded-2xl font-bold text-red-600 hover:bg-red-50 transition-colors shadow-sm">
                                    {{ __('تسجيل خروج') }}
                                </button>
                            </form>

                            <a href="{{ route('profile.edit') }}" class="block w-full text-center px-4 py-3 bg-red-600 border border-transparent rounded-2xl font-bold text-white hover:bg-red-700 transition-colors shadow-sm">
                                {{ __('حذف الحساب') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

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

</x-doctor-layout>