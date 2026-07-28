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

    <div class="py-12 print:py-0 print:m-0 print:p-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 print:max-w-full print:px-0">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border-[1.5px] border-black/20 print:border-none print:shadow-none print:rounded-none">

                <!-- Patient Info Header -->
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-right">
                        <div>
                            <span class="block text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('الاسم') }}</span>
                            <span class="block mt-1 text-lg font-bold text-gray-900">{{ $patient->name }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('رقم الهاتف') }}</span>
                            <span class="block mt-1 text-lg font-semibold text-gray-900" dir="ltr">{{ $patient->phone ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('تاريخ الميلاد') }}</span>
                            <span class="block mt-1 text-lg font-semibold text-gray-900" dir="ltr">{{ $patient->dob ? $patient->dob->format('Y-m-d') : '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Medical Records Timeline -->
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 border-b pb-2 print:hidden">{{ __('السجل الطبي') }}</h3>

                    @if($patient->medicalRecords->isEmpty())
                        <div class="text-center py-8 text-gray-500 print:hidden">
                            {{ __('لا توجد سجلات طبية لهذا المريض.') }}
                        </div>
                    @else
                        <div class="space-y-6" x-data="{ activeVisit: null }">
                            @foreach($patient->medicalRecords as $record)
                                <div class="border rounded-xl shadow-sm bg-white overflow-hidden print:border-0 print:shadow-none print:mb-8"
                                     x-bind:class="{ 'ring-2 ring-black border-transparent': activeVisit === {{ $record->id }} }">

                                    <!-- Visit Header -->
                                    <div class="px-6 py-4 bg-gray-50 cursor-pointer flex justify-between items-center hover:bg-gray-100 transition-colors print:bg-white print:border-b-2 print:border-black print:px-0 print:pb-2 print:mb-4"
                                         @click="activeVisit = activeVisit === {{ $record->id }} ? null : {{ $record->id }}">
                                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                            <div class="bg-black text-white p-2 rounded-lg print:hidden">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold text-gray-900">
                                                    {{ __('زيارة يوم') }} <span dir="ltr">{{ $record->visit_date ? $record->visit_date->format('Y-m-d') : $record->created_at->format('Y-m-d') }}</span>
                                                </h4>
                                                @if($record->doctor)
                                                    <p class="text-sm text-gray-500 print:hidden">{{ __('الطبيب') }}: {{ $record->doctor->name }}</p>
                                                @endif
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

                                    <!-- Visit Details -->
                                    <div x-cloak x-show="activeVisit === {{ $record->id }}" x-collapse class="print:!block">
                                        <div class="p-6 space-y-6">

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 print:grid-cols-2 print:gap-4">
                                                <!-- Diagnosis -->
                                                <div>
                                                    <h5 class="text-sm font-semibold text-gray-500 uppercase tracking-widest mb-2 border-b pb-1">{{ __('التشخيص') }}</h5>
                                                    <div class="prose prose-sm max-w-none text-gray-800 bg-gray-50 p-4 rounded-lg print:bg-transparent print:p-0">
                                                        {!! nl2br(e($record->diagnosis ?: '-')) !!}
                                                    </div>
                                                </div>

                                                <!-- Prescription -->
                                                <div>
                                                    <h5 class="text-sm font-semibold text-gray-500 uppercase tracking-widest mb-2 border-b pb-1">{{ __('الوصفة الطبية (الأدوية)') }}</h5>
                                                    <div class="prose prose-sm max-w-none text-gray-800 bg-gray-50 p-4 rounded-lg print:bg-transparent print:p-0">
                                                        {!! nl2br(e($record->prescription ?: '-')) !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Lab Tests -->
                                            <div>
                                                <h5 class="text-sm font-semibold text-gray-500 uppercase tracking-widest mb-2 border-b pb-1">{{ __('التحاليل والفحوصات المطلوبة') }}</h5>
                                                <div class="prose prose-sm max-w-none text-gray-800 bg-gray-50 p-4 rounded-lg print:bg-transparent print:p-0">
                                                    {!! nl2br(e($record->lab_tests ?: '-')) !!}
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
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
