<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center print:hidden">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('ملف المريض') }}: {{ $patient->name }}
            </h2>
            <a href="{{ route('patients.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('العودة للقائمة') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12 print:py-0 print:m-0 print:p-0" x-data="{ activeVisit: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 print:max-w-full print:px-0">
            <div class="space-y-6">
                <!-- Patient Info Header Section -->
                <div class="border rounded-2xl shadow-sm bg-white overflow-hidden p-6 mb-6">
                    <h5 class="text-md font-bold text-gray-900 border-b pb-2 mb-4">{{ __('معلومات المريض الأساسية') }}</h5>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="flex flex-col items-center justify-center text-center">
                            <span class="block text-sm font-medium text-gray-500">{{ __('الاسم') }}</span>
                            <span class="block mt-1 font-semibold text-gray-900">{{ $patient->name }}</span>
                        </div>
                        <div class="flex flex-col items-center justify-center text-center">
                            <span class="block text-sm font-medium text-gray-500">{{ __('رقم الهاتف') }}</span>
                            <span class="block mt-1 font-semibold text-gray-900" dir="ltr">{{ $patient->phone ?: '-' }}</span>
                        </div>
                        <div class="flex flex-col items-center justify-center text-center">
                            <span class="block text-sm font-medium text-gray-500">{{ __('تاريخ الميلاد') }}</span>
                            <span class="block mt-1 font-semibold text-gray-900" dir="ltr">{{ $patient->dob ? $patient->dob->format('Y-m-d') : '-' }}</span>
                        </div>
                        <div class="flex flex-col items-center justify-center text-center">
                            <span class="block text-sm font-medium text-gray-500">{{ __('الجنس') }}</span>
                            <span class="block mt-1 font-semibold text-gray-900">{{ $patient->gender ?: '-' }}</span>
                        </div>
                        <div class="flex flex-col items-center justify-center text-center">
                            <span class="block text-sm font-medium text-gray-500">{{ __('التدخين') }}</span>
                            <span class="block mt-1 font-semibold text-gray-900">{{ $patient->smoking_status ?: '-' }}</span>
                        </div>
                        <div class="flex flex-col items-center justify-center text-center">
                            <span class="block text-sm font-medium text-gray-500">{{ __('زمرة الدم') }}</span>
                            <span class="block mt-1 font-semibold text-gray-900" dir="ltr">{{ $patient->blood_type ?: '-' }}</span>
                        </div>
                    </div>
                </div>

                @if($patient->medicalRecords->count() > 0)
                    @foreach($patient->medicalRecords as $record)
                        <div class="border rounded-2xl shadow-sm bg-white overflow-hidden print:border-0 print:shadow-none print:mb-8"
                             x-bind:class="{ 'ring-2 ring-black border-transparent': activeVisit === {{ $record->id }}, 'print:hidden': activeVisit !== {{ $record->id }} }">

                            <!-- Visit Header (Accordion Toggle) -->
                            <div class="px-6 py-4 bg-gray-50 cursor-pointer flex justify-between items-center hover:bg-gray-100 transition-colors print:bg-white print:border-b-2 print:border-black print:px-0 print:pb-2 print:mb-4"
                                 @click="activeVisit = activeVisit === {{ $record->id }} ? null : {{ $record->id }}">
                                <div class="flex items-center space-x-4 rtl:rtl:space-x-reverse">
                                    <div class="bg-black text-white p-2 rounded-lg print:hidden">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900">
                                            {{ $patient->name }} - {{ __('زيارة يوم') }} <span dir="ltr">{{ $record->visit_date ? $record->visit_date->format('Y-m-d') : $record->created_at->format('Y-m-d') }}</span>
                                        </h4>
                                    </div>
                                </div>
                                <div class="print:hidden text-gray-400">
                                    <svg x-show="activeVisit !== {{ $record->id }}" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                    <svg x-cloak x-show="activeVisit === {{ $record->id }}" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Visit Details (Accordion Body) -->
                            <div x-cloak x-show="activeVisit === {{ $record->id }}" x-collapse class="print:!block">
                                <div class="p-6 space-y-8">

                                    <!-- Medical History Section -->
                                    <div>
                                        <h5 class="text-md font-bold text-gray-900 border-b pb-2 mb-4">{{ __('التاريخ الطبي في وقت الزيارة') }}</h5>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <span class="block text-sm font-medium text-gray-500">{{ __('الحساسية') }}</span>
                                                <div class="mt-1 text-gray-900 prose prose-sm">{!! nl2br(e($record->allergies ?: ($patient->allergies ?: '-'))) !!}</div>
                                            </div>
                                            <div>
                                                <span class="block text-sm font-medium text-gray-500">{{ __('الأمراض المزمنة') }}</span>
                                                <div class="mt-1 text-gray-900 prose prose-sm">{!! nl2br(e($record->chronic_diseases ?: ($patient->chronic_diseases ?: '-'))) !!}</div>
                                            </div>
                                            <div>
                                                <span class="block text-sm font-medium text-gray-500">{{ __('الأدوية المنتظمة') }}</span>
                                                <div class="mt-1 text-gray-900 prose prose-sm">{!! nl2br(e($record->regular_medications ?: ($patient->regular_medications ?: '-'))) !!}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Visit Specifics Section -->
                                    <div>
                                        <h5 class="text-md font-bold text-gray-900 border-b pb-2 mb-4">{{ __('تفاصيل الزيارة') }}</h5>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                            <!-- Reason & Symptoms -->
                                            <div class="space-y-4">
                                                <div>
                                                    <span class="block text-sm font-medium text-gray-500">{{ __('اسم الطبيب المعالج للزيارة') }}</span>
                                                    <span class="block mt-1 text-gray-900">{{ $record->doctor ? $record->doctor->name : '-' }}</span>
                                                </div>
                                                <div>
                                                    <span class="block text-sm font-medium text-gray-500">{{ __('سبب الزيارة') }}</span>
                                                    <div class="mt-1 text-gray-900 prose prose-sm">{!! nl2br(e($record->visit_reason ?: '-')) !!}</div>
                                                </div>
                                                <div>
                                                    <span class="block text-sm font-medium text-gray-500">{{ __('بداية ظهور الأعراض') }}</span>
                                                    <div class="mt-1 text-gray-900">{{ $record->symptoms_onset ?: '-' }}</div>
                                                </div>
                                            </div>

                                            <!-- Diagnosis & Prescription -->
                                            <div class="space-y-4">
                                                <div>
                                                    <span class="block text-sm font-medium text-gray-500">{{ __('التشخيص') }}</span>
                                                    <div class="mt-1 text-gray-900 prose prose-sm bg-gray-50 p-3 rounded-lg print:bg-transparent print:p-0">{!! nl2br(e($record->diagnosis ?: '-')) !!}</div>
                                                </div>
                                                <div>
                                                    <span class="block text-sm font-medium text-gray-500">{{ __('الوصفة الطبية (الأدوية)') }}</span>
                                                    <div class="mt-1 text-gray-900 prose prose-sm bg-gray-50 p-3 rounded-lg print:bg-transparent print:p-0">{!! nl2br(e($record->prescription ?: '-')) !!}</div>
                                                </div>
                                                <div>
                                                    <span class="block text-sm font-medium text-gray-500">{{ __('التحاليل والفحوصات المطلوبة') }}</span>
                                                    <div class="mt-1 text-gray-900 prose prose-sm bg-gray-50 p-3 rounded-lg print:bg-transparent print:p-0">{!! nl2br(e($record->lab_tests ?: '-')) !!}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Print Action -->
                                    <div class="pt-4 border-t border-gray-100 flex justify-end print:hidden">
                                        <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-neutral-800 transition-colors focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 rtl:ml-2 rtl:mr-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            {{ __('طباعة الملف') }}
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-gray-50 p-8 rounded-2xl border text-center text-gray-500">
                        {{ __('لا توجد سجلات زيارة سابقة لهذا المريض.') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
