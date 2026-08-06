<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('الاعدادات') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="flex flex-col space-y-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

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

            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Profile Information Card -->
                <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-white/20">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">المعلومات الشخصية</h3>

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
                                تغيير الصورة
                            </label>
                            <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*" @change="fileChosen">
                            <p class="text-xs text-slate-400 mt-2">JPG, PNG, GIF أقصى حجم 2MB</p>
                        </div>

                        <!-- Info Inputs -->
                        <div class="col-span-1 md:col-span-2 space-y-6">
                            <div>
                                <x-input-label for="secretary_name" :value="__('اسم السكرتير/ة')" />
                                <x-text-input id="secretary_name" name="secretary_name" type="text" class="mt-1 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('secretary_name', $user->secretary_name)" />
                                <div class="mt-1 text-xs text-slate-500">اسم المستخدم (للتسجيل): {{ $user->name }}</div>
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

                            <div class="text-sm text-indigo-600 font-medium">
                                @php
                                    $diff = $user->created_at->diffForHumans(['parts' => 3, 'join' => ' و ']);
                                @endphp
                                يعمل منذ: {{ str_replace(['years', 'year', 'months', 'month', 'days', 'day', 'ago', 'hours', 'hour', 'minutes', 'minute', 'seconds', 'second'], ['سنوات', 'سنة', 'أشهر', 'شهر', 'أيام', 'يوم', '', 'ساعات', 'ساعة', 'دقائق', 'دقيقة', 'ثواني', 'ثانية'], $diff) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clinic Configuration Card -->
                <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-white/20">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">إعدادات العيادة والحجوزات</h3>

                    <div class="flex flex-col gap-6">
                        <div>
                            <x-input-label for="default_consultation_price" :value="__('سعر الكشفية الثابت (د.ع)')" />
                            <x-text-input id="default_consultation_price" name="default_consultation_price" type="number" step="0.01" class="mt-1 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('default_consultation_price', $user->default_consultation_price)" required />
                        </div>

                        <div x-data="{ enabled: {{ old('has_sessions_system', $user->has_sessions_system) ? 'true' : 'false' }} }">
                            <label class="inline-flex items-center cursor-pointer mt-8">
                                <input type="checkbox" name="has_sessions_system" value="1" class="sr-only peer" x-model="enabled">
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                <span class="mr-3 text-sm font-medium text-slate-700">تفعيل نظام الجلسات</span>
                            </label>

                            <div x-show="enabled" x-collapse class="mt-4">
                                <x-input-label for="default_session_price" :value="__('سعر الجلسة الثابت (د.ع)')" />
                                <x-text-input id="default_session_price" name="default_session_price" type="number" step="0.01" class="mt-1 block w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" :value="old('default_session_price', $user->default_session_price)" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end border-t border-slate-100 pt-6">
                        <button type="submit" class="px-6 py-3 bg-black text-white font-bold rounded-2xl shadow-sm hover:bg-neutral-800 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                            حفظ الإعدادات
                        </button>
                    </div>
                </div>
            </form>

            <!-- Broadcast Messages -->
            <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-white/20">
                <h3 class="text-xl font-bold text-slate-800 mb-6">بث الرسائل للمراجعين</h3>

                <div class="flex flex-col gap-4">
                    <!-- Broadcasting Button -->
                    <div x-data="{ openBroadcastingModal: false }">
                        <button @click="openBroadcastingModal = true" type="button" class="w-full px-4 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl font-bold text-white hover:opacity-90 transition-opacity shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            البث الشامل (Broadcasting)
                        </button>

                        <!-- Alpine.js Modal for Broadcasting -->
                        <div x-show="openBroadcastingModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div x-show="openBroadcastingModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="openBroadcastingModal = false"></div>

                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                <div x-show="openBroadcastingModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-3xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100 p-6">
                                    <h3 class="text-xl font-bold text-slate-800 mb-4 text-center">ربط منصات التواصل</h3>

                                    <div class="space-y-4 mt-6">
                                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-2xl border border-green-100">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                                </div>
                                                <span class="font-bold text-green-800">WhatsApp</span>
                                            </div>
                                            <button type="button" class="px-4 py-2 bg-white text-green-700 rounded-xl text-sm font-bold shadow-sm border border-green-200 hover:bg-green-100 transition-colors">ربط الان</button>
                                        </div>

                                        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-2xl border border-blue-100">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.5 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                                                </div>
                                                <span class="font-bold text-blue-800">Telegram</span>
                                            </div>
                                            <button type="button" class="px-4 py-2 bg-white text-blue-700 rounded-xl text-sm font-bold shadow-sm border border-blue-200 hover:bg-blue-100 transition-colors">ربط الان</button>
                                        </div>

                                        <div class="flex items-center justify-between p-4 bg-purple-50 rounded-2xl border border-purple-100">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 4.974 0 11.111c0 3.498 1.744 6.614 4.469 8.654V24l4.088-2.242c1.092.301 2.246.464 3.443.464 6.627 0 12-4.974 12-11.111C24 4.974 18.627 0 12 0zm1.191 14.963l-3.056-3.26-5.963 3.26 6.559-6.963 3.13 3.26 5.888-3.26-6.558 6.963z"/></svg>
                                                </div>
                                                <span class="font-bold text-purple-800">Messenger</span>
                                            </div>
                                            <button type="button" class="px-4 py-2 bg-white text-purple-700 rounded-xl text-sm font-bold shadow-sm border border-purple-200 hover:bg-purple-100 transition-colors">ربط الان</button>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <button @click="openBroadcastingModal = false" type="button" class="w-full justify-center rounded-2xl border border-slate-300 shadow-sm px-4 py-3 bg-white text-base font-bold text-slate-700 hover:bg-slate-50 focus:outline-none transition-colors">
                                            إغلاق
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- About System -->
            <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-white/20">
                <h3 class="text-xl font-bold text-slate-800 mb-6">حول النظام</h3>

                <div class="flex flex-col gap-4">
                    <!-- About Button -->
                    <div x-data="{ openAboutModal: false }">
                        <button @click="openAboutModal = true" type="button" class="w-full px-4 py-4 bg-white border border-slate-200 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            حول النظام (About)
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
                                    <p class="text-slate-500 mb-6">نظام متكامل لإدارة العيادات الطبية، مصمم بأحدث التقنيات لتقديم تجربة مستخدم سلسة وعصرية.</p>
                                    <p class="text-sm text-slate-400 mb-6">© {{ date('Y') }} جميع الحقوق محفوظة.</p>

                                    <button @click="openAboutModal = false" type="button" class="w-full justify-center rounded-2xl border border-slate-300 shadow-sm px-4 py-3 bg-white text-base font-bold text-slate-700 hover:bg-slate-50 focus:outline-none transition-colors">
                                        إغلاق
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Session Types Management -->
            <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-slate-100 mb-8">
                <div class="max-w-xl mx-auto">
                    <h4 class="text-lg font-bold text-slate-800 mb-4">أنواع الجلسات (Session Types)</h4>

                    <form method="POST" action="{{ route('settings.session-types.store') }}" class="flex gap-2 mb-6">
                        @csrf
                        <input type="text" name="name" placeholder="أضف نوع جلسة جديد..." class="flex-1 rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <button type="submit" class="px-6 py-2 bg-black text-white rounded-2xl font-bold shadow-sm hover:bg-neutral-800 transition-colors">إضافة</button>
                    </form>

                    <div class="space-y-2">
                        @forelse($sessionTypes as $type)
                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="font-medium text-slate-700">{{ $type->name }}</span>
                                <form method="POST" action="{{ route('settings.session-types.destroy', $type->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 p-1" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-center text-slate-500 py-4">لا توجد أنواع جلسات مضافة</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Surgery Types Management -->
            <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-slate-100 mb-8">
                <div class="max-w-xl mx-auto">
                    <h4 class="text-lg font-bold text-slate-800 mb-4">أنواع العمليات (Surgery Types)</h4>

                    <form method="POST" action="{{ route('settings.surgery-types.store') }}" class="flex gap-2 mb-6">
                        @csrf
                        <input type="text" name="name" placeholder="أضف نوع عملية جديد..." class="flex-1 rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <button type="submit" class="px-6 py-2 bg-black text-white rounded-2xl font-bold shadow-sm hover:bg-neutral-800 transition-colors">إضافة</button>
                    </form>

                    <div class="space-y-2">
                        @forelse($surgeryTypes as $type)
                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="font-medium text-slate-700">{{ $type->name }}</span>
                                <form method="POST" action="{{ route('settings.surgery-types.destroy', $type->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 p-1" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-center text-slate-500 py-4">لا توجد أنواع عمليات مضافة</p>
                        @endforelse
                    </div>
                </div>
            </div>

            @if(auth()->user()->role === 'Secretary' && auth()->user()->is_main_account)
            <!-- Shift Management -->
            <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-slate-100 mb-8">
                <div class="max-w-xl mx-auto">
                    <h4 class="text-lg font-bold text-slate-800 mb-4">إدارة الورديات (Shift Management)</h4>
                    <p class="text-sm text-slate-500 mb-6">إنشاء أو تحديث حساب سكرتير فرعي.</p>

                    <form method="POST" action="{{ route('settings.sub-secretary.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="sub_email" class="block text-sm font-medium text-slate-700 mb-1">البريد الإلكتروني (Email)</label>
                            <input type="email" id="sub_email" name="email" value="{{ old('email', $subSecretary->email ?? '') }}" class="w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sub_password" class="block text-sm font-medium text-slate-700 mb-1">كلمة المرور (Password)</label>
                            <input type="password" id="sub_password" name="password" class="w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ isset($subSecretary) ? '' : 'required' }}>
                            @if(isset($subSecretary))
                                <p class="mt-1 text-xs text-slate-500">اتركه فارغاً إذا لم ترغب بتغيير كلمة المرور.</p>
                            @endif
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-sm hover:bg-indigo-700 transition-colors">
                                {{ isset($subSecretary) ? 'تحديث الحساب' : 'إنشاء حساب جديد' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Account Management (Danger Zone) -->
            <div class="p-6 sm:p-8 bg-red-50/50 backdrop-blur-md shadow-sm sm:rounded-3xl border border-red-100">
                <div class="max-w-xl mx-auto space-y-4">
                    <h4 class="text-lg font-bold text-red-800 mb-4 text-center">إدارة الحساب</h4>

                    <div class="flex flex-col gap-4">
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-center px-4 py-3 bg-white border border-slate-300 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                                تسجيل خروج
                            </button>
                        </form>

                        <a href="{{ route('profile.edit') }}" class="block w-full text-center px-4 py-3 bg-red-600 border border-transparent rounded-2xl font-bold text-white hover:bg-red-700 transition-colors shadow-sm">
                            حذف الحساب
                        </a>
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
</x-app-layout>
