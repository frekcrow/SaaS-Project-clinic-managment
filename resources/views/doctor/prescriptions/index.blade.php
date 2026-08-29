<x-doctor-layout>
    <x-slot name="header">
        {{ __('تهيئة الوصفات الطبية') }}
    </x-slot>

    <div x-data="prescriptionSetup({{ $medications->toJson() }})" class="max-w-7xl mx-auto pb-12">
        <!-- Top Action Bar -->
        <div class="flex items-center gap-4 mb-4 print:hidden">
            <button @click="isSettingsModalOpen = true" class="bg-teal-600 text-white rounded-xl px-5 py-2.5 text-sm font-bold hover:bg-teal-700 transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                {{ __('إعدادات الوصفة') }}
            </button>
            <button onclick="printPrescription()" class="bg-indigo-600 text-white rounded-xl px-5 py-2.5 text-sm font-bold hover:bg-indigo-700 transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                {{ __('طباعة الوصفة') }}
            </button>
            <button type="button" class="bg-slate-800 text-white rounded-xl px-5 py-2.5 text-sm font-bold hover:bg-slate-700 transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                </svg>
                {{ __('QR Code') }}
            </button>
        </div>

        <hr class="border-gray-200 my-6 print:hidden">

        <!-- Center Template Area -->
        <div class="flex justify-center w-full">
            <!-- The A4 Canvas -->
            <div id="prescription-print-area" class="bg-white shadow-2xl border border-gray-200 max-w-3xl w-full mx-auto flex flex-col relative overflow-hidden aspect-[1/1.414] print:break-after-avoid print:aspect-auto print:w-full print:h-[297mm] print:overflow-hidden print:block print:absolute print:inset-0 print:m-0 print:p-0 print:border-none print:bg-white text-gray-900">

                <!-- Header Section -->
                <div class="flex justify-between items-center px-10 pt-10 pb-4 bg-gradient-to-l from-emerald-500 via-emerald-500 to-white print:bg-gradient-to-l print:from-emerald-500 print:via-emerald-500 print:to-white text-white shrink-0 relative overflow-hidden">
                    <!-- Heart Image -->
                    <img src="{{ asset('images/heart.png') }}" alt="Heart" class="absolute top-0 right-0 opacity-80 w-24 h-24 pointer-events-none">

                    <!-- Doctor / Hospital Info -->
                    <div class="text-right relative z-10">
                        <h1 class="text-3xl font-extrabold text-white print:text-white mb-1 drop-shadow-sm" style="font-family: 'Tajawal', sans-serif;">{{ __('د') }}. {{ $settings->doctor_name }}</h1>
                        <h3 class="text-xl font-bold text-white/90 print:text-white/90 leading-tight mb-1">{{ $settings->clinic_name }}</h3>
                        @if($settings->doctor_specialization)
                            <h2 class="text-sm font-semibold tracking-widest text-emerald-100 print:text-emerald-100 mb-2 bg-black/10 inline-block px-3 py-1 rounded-full">{{ $settings->doctor_specialization }}</h2>
                        @endif
                    </div>

                    <!-- Logos -->
                    <div class="flex gap-4 items-center relative z-10">
                        <div class="w-24 h-24 text-emerald-500 print:text-emerald-500 bg-transparent p-2 rounded-xl backdrop-blur-sm">
                            @if($settings->logo_1_path)
                                <img src="{{ Storage::url($settings->logo_1_path) }}" alt="Logo 1" class="w-full h-full object-contain">
                            @else
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-full h-full">
                                    <path d="M4.5 4.5v5c0 3.3 2.7 6 6 6s6-2.7 6-6v-5"></path>
                                    <path d="M10.5 15.5L7 21h7l-3.5-5.5z"></path>
                                    <path d="M16.5 15.5C18 17 21 16 21 13.5c0-2-1.5-3-3-3s-3 1-3 3"></path>
                                </svg>
                            @endif
                        </div>
                        @if($settings->logo_2_path)
                        <div class="w-24 h-24 text-emerald-500 print:text-emerald-500 bg-transparent p-2 rounded-xl backdrop-blur-sm">
                            <img src="{{ Storage::url($settings->logo_2_path) }}" alt="Logo 2" class="w-full h-full object-contain">
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Patient Info Bar (Light Blue Gradient) -->
                <div class="bg-gradient-to-b from-blue-50 to-transparent print:from-blue-50 print:to-transparent px-10 py-6 text-sm font-medium shrink-0">
                    <div class="grid grid-cols-12 gap-y-4 gap-x-6 items-end">
                        <div class="col-span-12 flex items-center gap-2">
                            <span class="text-gray-700 w-24 shrink-0">{{ __('Patient Name:') }}</span>
                            <div class="flex-1 border-b border-blue-200 relative">
                                <span class="absolute bottom-1 px-2" x-text="patientName || '...........................................'"></span>
                            </div>
                        </div>

                        <div class="col-span-6 flex items-center gap-2">
                            <span class="text-gray-700 w-12 shrink-0">{{ __('Age:') }}</span>
                            <div class="flex-1 border-b border-blue-200 relative h-6">
                                <span class="absolute bottom-1 px-2" x-text="patientAge || '...................'"></span>
                            </div>
                        </div>

                        <div class="col-span-6 flex items-center gap-2">
                            <span class="text-gray-700 w-24 shrink-0">{{ __('تاريخ الميلاد:') }}</span>
                            <div class="flex-1 border-b border-blue-200 relative h-6">
                                <span class="absolute bottom-1 px-2" x-text="patientDob || '...................'" dir="ltr"></span>
                            </div>
                        </div>

                        <div class="col-span-12 flex items-center gap-2">
                            <span class="text-gray-700 w-24 shrink-0">{{ __('Diagnosis:') }}</span>
                            <div class="flex-1 border-b border-blue-200 relative h-6">
                                <span class="absolute bottom-1 px-2" x-text="patientDiagnosis || '...........................................'"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Body (Rx & Medications) -->
                <div class="flex-1 px-10 py-4 flex flex-col relative z-10 overflow-hidden rx-content-body">
                    <!-- Rx Logo -->
                    <div class="mb-4 shrink-0">
                        <svg class="w-10 h-10 text-blue-500 print:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.5 4C15.567 4 14 5.567 14 7.5c0 1.706 1.218 3.125 2.839 3.447L14.975 14H19v2h-5c-1.103 0-2-.897-2-2v-1.171l2.459-3.935C13.064 8.647 12 7.189 12 5.5 12 2.467 14.467 0 17.5 0S23 2.467 23 5.5c0 2.223-1.326 4.14-3.238 5.048L21 13v3h-2v-1.78l-1.077-2.155C18.665 11.83 21 9.92 21 7.5 21 5.567 19.433 4 17.5 4zm-7 8.5C10.5 10.015 8.485 8 6 8S1.5 10.015 1.5 12.5 3.515 17 6 17s4.5-2.015 4.5-4.5zM6 10c1.378 0 2.5 1.122 2.5 2.5S7.378 15 6 15s-2.5-1.122-2.5-2.5S4.622 10 6 10zm0 1c-.827 0-1.5.673-1.5 1.5S5.173 14 6 14s1.5-.673 1.5-1.5S6.827 11 6 11z"/>
                        </svg>
                    </div>

                    <div class="flex-1 overflow-hidden flex flex-col min-h-0 space-y-2" style="font-family: 'Times New Roman', Times, serif;">
                        <!-- Empty State -->
                        <div x-show="addedMedications.length === 0" class="text-center text-slate-400 print:hidden mt-4 text-sm font-sans shrink-0">
                            {{ __('قم بإضافة أدوية من القائمة الجانبية') }}
                        </div>

                        <!-- Medication List -->
                        <template x-for="(med, index) in addedMedications" :key="index">
                            <div class="relative group border-b border-blue-50 print:border-transparent pb-2 last:border-0 hover:bg-slate-50 print:hover:bg-transparent -mx-3 px-3 rounded-lg transition-colors shrink-0">
                                <!-- Delete Button (Hidden on Print) -->
                                <button @click="removeMedication(index)" class="absolute left-2 top-2 text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity print:hidden">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>

                                <div class="flex items-start gap-3">
                                    <div class="text-base font-bold text-gray-800 print:text-black mt-0.5 w-6 text-right" x-text="(index + 1) + '.'"></div>
                                    <div class="flex-1">
                                        <div class="text-base font-bold text-gray-900 print:text-black flex items-center gap-2">
                                            <span x-text="med.name"></span>
                                            <span x-show="med.type" class="text-xs px-2 py-0.5 bg-blue-50 text-blue-700 rounded-full print:border print:border-black print:bg-transparent font-sans" x-text="med.type"></span>
                                        </div>
                                        <div x-show="med.generic" class="text-xs text-gray-500 print:text-gray-700 mb-1 italic" x-text="med.generic"></div>

                                        <!-- Editable Dosage and Usage -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-1 mt-1">
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-400 print:hidden mb-0.5 font-sans">{{ __('الجرعة') }}</label>
                                                <input type="text" x-model="med.dosage" placeholder="{{ __('مثال') }}: {{ __('حبة واحدة') }}" class="w-full bg-transparent border-b border-gray-200 print:border-transparent focus:border-blue-500 focus:outline-none focus:ring-0 text-gray-800 print:text-black text-sm px-0 py-0.5 transition-colors font-medium">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-semibold text-gray-400 print:hidden mb-0.5 font-sans">{{ __('وقت الاستخدام') }}</label>
                                                <input type="text" x-model="med.usage" placeholder="{{ __('مثال') }}: {{ __('مرتين يومياً بعد الأكل') }}" class="w-full bg-transparent border-b border-gray-200 print:border-transparent focus:border-blue-500 focus:outline-none focus:ring-0 text-gray-800 print:text-black text-sm px-0 py-0.5 transition-colors font-medium">
                                            </div>
                                            <div class="md:col-span-2 hidden">
                                                <label class="block text-[10px] font-semibold text-gray-400 print:hidden mb-0.5 font-sans">{{ __('دواعي الاستعمال') }}</label>
                                                <input type="text" x-model="med.indications" placeholder="{{ __('مثال') }}: {{ __('مسكن للألم') }}" class="w-full bg-transparent border-b border-gray-200 print:border-transparent focus:border-blue-500 focus:outline-none focus:ring-0 text-gray-800 print:text-black text-sm px-0 py-0.5 transition-colors font-medium">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Doctor's Notes -->
                    <div class="mt-4 pt-2 border-t border-dashed border-gray-200 print:border-black shrink-0">
                        <label class="block text-xs font-bold text-gray-700 print:hidden mb-1 font-sans">{{ __('ملاحظات الطبيب') }}:</label>
                        <textarea rows="2" class="w-full bg-gray-50 print:bg-transparent border border-gray-200 print:border-0 rounded-lg p-2 text-gray-800 print:text-black focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none font-medium text-sm leading-relaxed" placeholder="{{ __('اكتب ملاحظاتك هنا') }}..."></textarea>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-auto px-10 pb-8 pt-4 relative overflow-hidden text-gray-600 print:text-black text-xs font-medium border-t-4 border-blue-500 print:border-black shrink-0">
                    <!-- Curved Abstract Shapes -->
                    <div class="absolute -bottom-10 -right-10 w-48 h-48 border-4 border-blue-200 print:border-gray-300 rounded-full opacity-50"></div>
                    <div class="absolute -bottom-16 -right-4 w-40 h-40 border-4 border-blue-300 print:border-gray-400 rounded-full opacity-50"></div>

                    <div class="grid grid-cols-2 gap-4 relative z-10">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-600 print:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span>{{ $settings->primary_phone ?? '---' }}@if($settings->secondary_phone)<br>{{ $settings->secondary_phone }}@endif</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-600 print:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>{{ $settings->clinic_address ?? __('عنوان العيادة') }}</span>
                            </div>
                        </div>
                        <div class="space-y-1 flex flex-col justify-end items-end text-left rtl:text-left">
                            <div class="flex items-center justify-end w-full">
                                <img src="{{ asset('images/logo-text.png') }}" alt="Atlas Logo" class="h-6 object-contain">
                            </div>
                            <div class="flex items-center gap-2 opacity-80">
                                <span class="font-bold text-[10px]">شركة اطلس للحلول الالكترونية</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- Settings Modal (Hidden by Default) -->
        <div x-show="isSettingsModalOpen" style="display: none;" class="fixed inset-0 z-[80] bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
            <div @click.away="isSettingsModalOpen = false" class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[80vh] flex flex-col overflow-hidden">
                <div class="p-4 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                    <h2 class="text-lg font-bold text-slate-800">{{ __('إعدادات قالب الوصفة وبياناتها') }}</h2>
                    <button @click="isSettingsModalOpen = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 overflow-y-auto flex-1 space-y-8">
                    <!-- Settings Form -->
                    <div>
                        <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ __('إعدادات قالب الوصفة') }}
                        </h3>
                        <form action="{{ route('doctor.prescriptions.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('اسم العيادة') }}</label>
                                    <input type="text" name="clinic_name" value="{{ old('clinic_name', $settings->clinic_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('اسم الطبيب') }}</label>
                                    <input type="text" name="doctor_name" value="{{ old('doctor_name', $settings->doctor_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('تخصص الطبيب') }}</label>
                                <input type="text" name="doctor_specialization" value="{{ old('doctor_specialization', $settings->doctor_specialization) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('عنوان العيادة') }}</label>
                                <input type="text" name="clinic_address" value="{{ old('clinic_address', $settings->clinic_address) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('رقم الهاتف 1') }}</label>
                                    <input type="text" name="primary_phone" value="{{ old('primary_phone', $settings->primary_phone) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('رقم الهاتف 2') }} ({{ __('اختياري') }})</label>
                                    <input type="text" name="secondary_phone" value="{{ old('secondary_phone', $settings->secondary_phone) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('الشعار الأول') }} ({{ __('اليمين') }})</label>
                                    <input type="file" name="logo_1" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition-colors">
                                    @if($settings->logo_1_path)
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($settings->logo_1_path) }}" alt="Logo 1" class="h-12 object-contain rounded">
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('الشعار الثاني') }} ({{ __('اليسار - اختياري') }})</label>
                                    <input type="file" name="logo_2" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition-colors">
                                    @if($settings->logo_2_path)
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($settings->logo_2_path) }}" alt="Logo 2" class="h-12 object-contain rounded">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-slate-900 text-white rounded-xl px-4 py-2 text-sm font-medium hover:bg-slate-800 transition-colors">
                                {{ __('حفظ الإعدادات') }}
                            </button>
                        </form>
                    </div>

                    <hr class="border-slate-200">

                    <!-- Prescription Data Entry -->
                    <div>
                        <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            {{ __('بيانات الوصفة') }}
                        </h3>
                        <div class="space-y-4">
                            <!-- Patient Selection -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('المريض') }} ({{ __('مواعيد اليوم') }})</label>
                                <select x-model="selectedAppointmentId" @change="updatePatientData" class="w-full bg-slate-50 border border-slate-200 rounded-xl ps-3.5 pe-8 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                    <option value="">-- {{ __('اختر مريض') }} --</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" data-patient="{{ $patient->name }}" data-date="{{ today()->format('Y/m/d') }}" data-booking="{{ $patient->id }}" data-dob="{{ $patient->dob ? $patient->dob->format('Y-m-d') : '' }}" data-diagnosis="{{ $patient->medicalRecords->first()->diagnosis ?? '' }}">
                                            {{ $patient->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Manual Override for Patient Details -->
                            <div x-show="selectedAppointmentId" x-collapse>
                                <div class="p-3 bg-slate-50 rounded-xl space-y-3 mt-2 border border-slate-100">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('اسم المريض') }}</label>
                                        <input type="text" x-model="patientName" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm">
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('رقم الحجز') }}</label>
                                            <input type="text" x-model="bookingNumber" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('التاريخ') }}</label>
                                            <input type="text" x-model="bookingDate" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm" dir="ltr">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Medication Selection -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('إضافة دواء') }}</label>
                                <div class="flex gap-2">
                                    <select x-model="selectedMedicationId" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl ps-3.5 pe-8 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                        <option value="">-- {{ __('اختر دواء') }} --</option>
                                        @foreach($medications as $med)
                                            <option value="{{ $med->id }}" data-name="{{ $med->name }}" data-generic="{{ $med->generic_name }}" data-type="{{ $med->medication_type }}">
                                                {{ $med->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button @click="addMedication()" type="button" class="bg-teal-600 text-white rounded-xl px-4 py-2 text-sm font-medium hover:bg-teal-700 transition-colors flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        function printPrescription() {
            // 1. Get the exact HTML of the prescription template
            const printContent = document.getElementById('prescription-print-area').innerHTML;

            // 2. Open a new temporary background window
            const printWindow = window.open('', '_blank', 'width=800,height=900');

            // 3. Write the HTML structure
            printWindow.document.write('<html dir="rtl"><head><title>طباعة الوصفة</title>');

            // 4. Clone all stylesheets from the main system so Tailwind works perfectly in the print window
            const styles = document.querySelectorAll('link[rel="stylesheet"], style');
            styles.forEach(style => {
                printWindow.document.write(style.outerHTML);
            });

            // 4.5 Inject print specific styles
            printWindow.document.write(`
            <style>
               @page { size: A4; margin: 0; }
               body { margin: 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; background: white; }
               #prescription-print-area {
                  width: 210mm !important;
                  min-height: 297mm !important;
                  height: 100% !important;
                  margin: 0 auto;
                  display: flex;
                  flex-direction: column;
                }
               /* Force the content area to grow and push the footer to the bottom */
               .rx-content-body { flex-grow: 1; }
            </style>
            `);

            // 5. Inject the prescription content into a clean white body
            printWindow.document.write('</head><body class="bg-white">');
            printWindow.document.write('<div id="prescription-print-area">');
            printWindow.document.write(printContent);
            printWindow.document.write('</div></body></html>');

            // 6. Close document, wait for styles to load, print, and auto-close the window
            printWindow.document.close();
            printWindow.focus();
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 500); // 500ms delay ensures Tailwind CSS is fully applied before the print dialog opens
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('prescriptionSetup', (medicationsData = []) => ({
                isSettingsModalOpen: false,
                selectedAppointmentId: '',
                patientName: '',
                bookingNumber: '',
                bookingDate: '{{ today()->format('Y/m/d') }}',
                patientAge: '',
                patientDob: '',
                patientDiagnosis: '',

                selectedMedicationId: '',
                medications: medicationsData,
                addedMedications: [],

                updatePatientData() {
                    if (this.selectedAppointmentId) {
                        const select = document.querySelector('select[x-model="selectedAppointmentId"]');
                        const option = select.options[select.selectedIndex];
                        this.patientName = option.dataset.patient;
                        this.bookingNumber = option.dataset.booking;
                        this.bookingDate = option.dataset.date;
                        this.patientDiagnosis = option.dataset.diagnosis;

                        const dob = option.dataset.dob;
                        if (dob) {
                            this.patientDob = dob;
                            const birthDate = new Date(dob);
                            const today = new Date();
                            let age = today.getFullYear() - birthDate.getFullYear();
                            const m = today.getMonth() - birthDate.getMonth();
                            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                                age--;
                            }
                            this.patientAge = age;
                        } else {
                            this.patientDob = '';
                            this.patientAge = '';
                        }

                    } else {
                        this.patientName = '';
                        this.bookingNumber = '';
                        this.bookingDate = '{{ today()->format('Y/m/d') }}';
                        this.patientDob = '';
                        this.patientAge = '';
                        this.patientDiagnosis = '';
                    }
                },

                addMedication() {
                    if (!this.selectedMedicationId) return;

                    const select = document.querySelector('select[x-model="selectedMedicationId"]');
                    const option = select.options[select.selectedIndex];

                    const foundMed = this.medications.find(m => m.id == this.selectedMedicationId) || {};

                    this.addedMedications.push({
                        id: this.selectedMedicationId,
                        name: option.dataset.name,
                        generic: option.dataset.generic,
                        type: option.dataset.type,
                        dosage: (foundMed.dosages && foundMed.dosages.length > 0) ? foundMed.dosages[0] : '',
                        usage: (foundMed.usage_times && foundMed.usage_times.length > 0) ? foundMed.usage_times[0] : '',
                        indications: foundMed.indications || ''
                    });

                    // Reset selection
                    this.selectedMedicationId = '';
                },

                removeMedication(index) {
                    this.addedMedications.splice(index, 1);
                }
            }));
        });
    </script>
    @endpush
</x-doctor-layout>
