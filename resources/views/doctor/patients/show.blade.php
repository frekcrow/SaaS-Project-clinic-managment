<x-doctor-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full mb-6 print:hidden">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    {{ $patient->name ?? 'اسم المريض' }}
                </h2>
            </div>
            <div>
                <button onclick="window.print()" class="flex items-center justify-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    <span>{{ __('طباعة الملف') }}</span>
                </button>
            </div>
        </div>

        <!-- Print Header (Hidden on Screen) -->
        <div class="hidden print:flex flex-col items-center justify-center border-b-2 border-black pb-4 mb-8">
            <h1 class="text-3xl font-bold mb-2">{{ __('عيادة الطبيب') }}</h1>
            <h2 class="text-xl">{{ __('السجل الطبي الإلكتروني') }}</h2>
            <div class="mt-4 flex gap-8 text-sm">
                <span>{{ __('تاريخ الطباعة') }}: {{ now()->format('Y-m-d') }}</span>
                <span>{{ __('المريض') }}: {{ $patient->name }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 print:py-0 print:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-teal-50 border border-teal-200 text-teal-800 px-4 py-3 rounded-xl print:hidden">
                    {{ session('success') }}
                </div>
            @endif

            <!-- 1. Patient Information (Editable by Doctor) -->
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] print:shadow-none print:border-black/20 print:rounded-none">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 print:border-b print:pb-2 print:border-black/20">
                    <svg class="w-5 h-5 text-slate-400 print:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    {{ __('المعلومات الشخصية والتاريخ المرضي') }}
                </h3>

                <form action="{{ route('doctor.patients.update', $patient) }}" method="POST" class="print:hidden">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('الاسم الكامل') }}</label>
                            <input type="text" name="name" value="{{ $patient->name }}" class="w-full border-gray-300 focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('تاريخ الميلاد') }}</label>
                            <input type="text" dir="ltr" name="dob" value="{{ $patient->dob ? $patient->dob->format('Y-m-d') : '' }}" x-data x-mask="9999-99-99" placeholder="YYYY-MM-DD" class="w-full border-gray-300 focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm text-left">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('رقم الهاتف') }}</label>
                            <input type="text" name="phone" value="{{ $patient->phone }}" class="w-full border-gray-300 focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('الجنس') }}</label>
                            <select name="gender" class="w-full border-gray-300 focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm ps-3.5 pe-8">
                                <option value="">{{ __('غير محدد') }}</option>
                                <option value="male" {{ $patient->gender == 'male' ? 'selected' : '' }}>{{ __('ذكر') }}</option>
                                <option value="female" {{ $patient->gender == 'female' ? 'selected' : '' }}>{{ __('أنثى') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('فصيلة الدم') }}</label>
                            <input type="text" name="blood_type" dir="ltr" value="{{ $patient->blood_type }}" class="w-full border-gray-300 focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm text-left">
                        </div>

                        <div class="col-span-full mt-4 border-t border-gray-100 pt-4">
                            <h4 class="text-sm font-bold text-slate-600 mb-4">{{ __('التاريخ الطبي') }}</h4>
                        </div>

                        <div class="col-span-1 md:col-span-2 lg:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('الحساسية') }}</label>
                            <textarea name="allergies" rows="2" class="w-full border-gray-300 focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm">{{ $patient->allergies }}</textarea>
                        </div>
                        <div class="col-span-1 md:col-span-2 lg:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('الأمراض المزمنة') }}</label>
                            <textarea name="chronic_diseases" rows="2" class="w-full border-gray-300 focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm">{{ $patient->chronic_diseases }}</textarea>
                        </div>
                        <div class="col-span-1 md:col-span-2 lg:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('الأدوية المنتظمة') }}</label>
                            <textarea name="regular_medications" rows="2" class="w-full border-gray-300 focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm">{{ $patient->regular_medications }}</textarea>
                        </div>
                        <div class="col-span-1 md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('سبب الزيارة والأعراض') }} ({{ __('من السكرتير') }})</label>
                            <div class="grid grid-cols-2 gap-4">
                                <textarea name="reason_for_visit" rows="2" placeholder="{{ __('سبب الزيارة') }}..." class="w-full border-gray-300 focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm">{{ $patient->reason_for_visit }}</textarea>
                                <textarea name="symptoms_onset" rows="2" placeholder="{{ __('بداية الأعراض') }}..." class="w-full border-gray-300 focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm">{{ $patient->symptoms_onset }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-black text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-neutral-800 transition-colors shadow-sm">
                            {{ __('حفظ التعديلات') }}
                        </button>
                    </div>
                </form>

                <!-- Print Version of Info -->
                <div class="hidden print:block space-y-4">
                    <div class="grid grid-cols-3 gap-4 border-b border-gray-200 pb-4">
                        <div><strong class="text-gray-600 block">{{ __('الاسم') }}:</strong> {{ $patient->name }}</div>
                        <div><strong class="text-gray-600 block">{{ __('العمر') }}:</strong> {{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->age . __(' سنة') : '-' }}</div>
                        <div><strong class="text-gray-600 block">{{ __('الجنس') }}:</strong> {{ $patient->gender == 'male' ? __('ذكر') : ($patient->gender == 'female' ? __('أنثى') : '-') }}</div>
                        <div><strong class="text-gray-600 block">{{ __('فصيلة الدم') }}:</strong> {{ $patient->blood_type ?: '-' }}</div>
                        <div><strong class="text-gray-600 block">{{ __('رقم الهاتف') }}:</strong> {{ $patient->phone ?: '-' }}</div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div><strong class="text-gray-600 block mb-1">{{ __('الحساسية') }}:</strong> <p class="text-sm">{{ $patient->allergies ?: __('لا يوجد') }}</p></div>
                        <div><strong class="text-gray-600 block mb-1">{{ __('الأمراض المزمنة') }}:</strong> <p class="text-sm">{{ $patient->chronic_diseases ?: __('لا يوجد') }}</p></div>
                        <div class="col-span-2"><strong class="text-gray-600 block mb-1">{{ __('الأدوية المنتظمة') }}:</strong> <p class="text-sm">{{ $patient->regular_medications ?: __('لا يوجد') }}</p></div>
                        <div class="col-span-2"><strong class="text-gray-600 block mb-1">{{ __('سبب الزيارة والأعراض') }}:</strong> <p class="text-sm">{{ $patient->reason_for_visit }} - {{ $patient->symptoms_onset }}</p></div>
                    </div>
                </div>
            </div>

            <!-- 2. Current Medical Record (Diagnosis & Prescription) -->
            @php
                $currentRecord = $patient->medicalRecords->where('diagnosis', __('قيد الانتظار'))->first() ?? $patient->medicalRecords->first();
            @endphp
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] print:shadow-none print:border-black/20 print:rounded-none">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 print:border-b print:pb-2 print:border-black/20">
                    <svg class="w-5 h-5 text-slate-400 print:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    {{ __('التشخيص والوصفة الطبية') }}
                </h3>

                <form action="{{ route('doctor.patients.records.store', $patient) }}" method="POST" class="print:hidden">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('التشخيص') }}</label>
                            <textarea name="diagnosis" rows="3" class="w-full border-gray-300 focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm">{{ $currentRecord && $currentRecord->diagnosis !== __('قيد الانتظار') ? $currentRecord->diagnosis : '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('الوصفة الطبية والنصائح') }} (Prescription & Advice)</label>
                            <textarea name="prescription" rows="5" dir="ltr" class="w-full border-gray-300 focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm text-left font-mono">{{ $currentRecord ? $currentRecord->prescription : '' }}</textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-black text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-neutral-800 transition-colors shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ __('اعتماد التشخيص') }}
                        </button>
                    </div>
                </form>

                <!-- Print Version -->
                <div class="hidden print:block space-y-6 mt-4">
                    <div>
                        <strong class="text-xl border-b-2 border-black inline-block mb-2 pr-8 pb-1">{{ __('التشخيص') }}:</strong>
                        <p class="text-lg mt-2 whitespace-pre-line">{{ $currentRecord && $currentRecord->diagnosis !== __('قيد الانتظار') ? $currentRecord->diagnosis : __('لم يتم التشخيص بعد') }}</p>
                    </div>
                    <div class="pt-4">
                        <strong class="text-xl border-b-2 border-black inline-block mb-2 pr-8 pb-1">{{ __('الوصفة الطبية') }}:</strong>
                        <p class="text-lg mt-2 whitespace-pre-line font-mono" dir="ltr">{{ $currentRecord ? $currentRecord->prescription : '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- 3. Medical Albums (X-Rays, Prescriptions, Diagnostics) -->
            <div x-data="{ activeTab: 'xray' }" class="bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] print:hidden">
                <div class="flex items-center justify-between mb-8 border-b border-gray-100 pb-4">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ __('الصور والملفات المرفقة') }}
                    </h3>

                    <!-- Upload Button -->
                    <form action="{{ route('doctor.patients.images.upload', $patient) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-3">
                        @csrf
                        <input type="hidden" name="album_type" x-model="activeTab">
                        <input type="file" name="image" id="file_upload" class="hidden" onchange="this.form.submit()" accept="image/*">
                        <label for="file_upload" class="cursor-pointer bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-xl text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            {{ __('إضافة صورة') }}
                        </label>
                    </form>
                </div>

                <!-- Tabs Navigation -->
                <div class="flex gap-4 mb-6 border-b border-gray-100">
                    <button @click="activeTab = 'xray'" :class="{'border-black text-black': activeTab === 'xray', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'xray'}" class="pb-3 border-b-2 font-medium text-sm transition-colors">{{ __('صور الأشعة') }}</button>
                    <button @click="activeTab = 'prescription'" :class="{'border-black text-black': activeTab === 'prescription', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'prescription'}" class="pb-3 border-b-2 font-medium text-sm transition-colors">{{ __('وصفات سابقة') }}</button>
                    <button @click="activeTab = 'diagnostic'" :class="{'border-black text-black': activeTab === 'diagnostic', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'diagnostic'}" class="pb-3 border-b-2 font-medium text-sm transition-colors">{{ __('صور تشخيصية') }}</button>
                </div>

                <!-- Albums Content -->
                <div class="mt-6">
                    @foreach(['xray', 'prescription', 'diagnostic'] as $type)
                        <div x-show="activeTab === '{{ $type }}'" x-cloak>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @forelse($patient->patientImages->where('album_type', $type) as $image)
                                    <div class="group relative rounded-2xl overflow-hidden border border-gray-200 aspect-square bg-gray-50 flex items-center justify-center">
                                        <img src="{{ Storage::disk('public')->url($image->image_path) }}" alt="Medical Image" class="w-full h-full object-cover">

                                        <!-- Overlay & Delete -->
                                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center p-4">
                                            <form action="{{ route('doctor.patients.images.destroy', [$patient, $image]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition-colors shadow-sm mb-2" onclick="return confirm('{{ __('هل أنت متأكد من حذف هذه الصورة؟') }}')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Metadata banner -->
                                        <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 to-transparent p-3 pt-8">
                                            <p class="text-white text-xs text-center" dir="ltr">{{ $image->created_at->format('Y-m-d h:i A') }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-full py-12 text-center text-gray-500 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                        {{ __('لا توجد صور في هذا الألبوم') }}
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-doctor-layout>
