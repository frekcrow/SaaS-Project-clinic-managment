<x-doctor-layout>
    @push('styles')

    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <style>
        .bento-font {
            font-family: 'IBM Plex Sans Arabic', sans-serif;
        }
        /* Fix the Z index of modals */
        .z-50 { z-index: 100 !important; }
    </style>

    @endpush
    <x-slot name="header">
        {{ $greeting ?? __('Doctor Dashboard Workspace') }} - {{ __('هل أنت مستعد ليومك؟') }}
    </x-slot>

    <div class="space-y-6 bento-font">
        @php
            $pendingAppt = $todaysAppointments->where('status', 'pending')->first();
            $pendingCount = $todaysAppointments->where('status', 'pending')->count();
        @endphp

        <div>

            <!-- 1. The Live Patient Queue Card & Today's Surgeries Grid -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 relative z-10">
                <!-- Patient Queue Card spans 8 columns on lg -->
                <div class="col-span-12 md:col-span-4 aspect-square md:aspect-auto bg-white dark:bg-gray-800 shadow-md border border-slate-100 rounded-2xl flex flex-col justify-between overflow-hidden">
                    <!-- Top accent line -->
                    <div class="h-1 w-full bg-gradient-to-r from-teal-400 to-blue-500"></div>

                    <div class="p-6 flex flex-col md:flex-row items-center justify-between gap-4 h-full">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-teal-50 border-4 border-white shadow-sm flex items-center justify-center flex-shrink-0 relative">
                                <svg class="w-8 h-8 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                @if($pendingAppt)
                                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-black text-white rounded-full flex items-center justify-center font-bold text-xs shadow-sm border-2 border-white">
                                        #{{ $pendingAppt->queue_number }}
                                    </div>
                                @endif
                            </div>

                            <div>
                                <div class="text-xs font-bold tracking-wide text-teal-600 mb-1 uppercase flex items-center gap-2">
                                    <span class="relative flex h-2 w-2">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                                    </span>
                                    {{ __('المراجع القادم') }} ({{ __('الانتظار') }})
                                </div>
                                <h2 class="text-xl font-black text-slate-800 mb-1">
                                    {{ $pendingAppt ? ($pendingAppt->patient_name ?? ($pendingAppt->patient ? $pendingAppt->patient->name : '-')) : __('لا يوجد مراجعين في الانتظار') }}
                                </h2>
                                @if($pendingAppt && $pendingAppt->patient)
                                    <a href="{{ route('doctor.patients.show', $pendingAppt->patient->id) }}" class="inline-flex items-center text-xs text-slate-500 hover:text-teal-600 transition-colors gap-1 group">
                                        <svg class="w-3 h-3 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                        {{ __('عرض الملف الطبي الكامل') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        @if($pendingAppt)
                            <div class="flex items-center gap-2 w-full md:w-auto">
                                <form method="POST" action="{{ route('doctor.appointments.update_status', $pendingAppt) }}" class="w-full md:w-auto">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="in_progress">
                                    <button type="submit" class="w-full md:w-auto px-6 py-2 bg-black text-white rounded-xl font-bold text-sm shadow-sm hover:bg-neutral-800 hover:shadow-md transition-all flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ __('بدء الجلسة') }}
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('doctor.appointments.update_status', $pendingAppt) }}" class="w-full md:w-auto">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="w-full md:w-auto px-4 py-2 bg-white text-red-600 border border-slate-200 rounded-xl font-bold text-sm shadow-sm hover:bg-red-50 hover:border-red-100 transition-all">
                                        {{ __('تخطي') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <!-- Active Sessions Display (If any are in_progress) -->
                    @php
                        $inProgressAppt = $todaysAppointments->where('status', 'in_progress')->first();
                    @endphp

                    @if($inProgressAppt)
                        <div class="border-t border-slate-100 bg-slate-50 p-4 flex flex-col md:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-indigo-600 mb-1">{{ __('جلسة نشطة حالياً') }}</div>
                                    <div class="text-sm font-semibold text-slate-800">{{ $inProgressAppt->patient_name ?? ($inProgressAppt->patient ? $inProgressAppt->patient->name : '-') }}</div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div x-data="liveTimer('{{ $inProgressAppt->session_started_at ? $inProgressAppt->session_started_at->toIso8601String() : now()->toIso8601String() }}')" class="text-indigo-600 font-mono font-bold text-lg flex items-center gap-2 bg-white px-3 py-1.5 rounded-xl border border-indigo-100 shadow-sm" dir="ltr">
                                    <span x-text="timeString"></span>
                                    <svg class="w-4 h-4 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>

                                <form method="POST" action="{{ route('doctor.appointments.update_status', $inProgressAppt) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-xl font-bold text-sm shadow-sm hover:bg-indigo-700 transition-colors">
                                        {{ __('إنهاء') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Today's Surgeries Card -->
                <div class="col-span-12 md:col-span-4 aspect-square md:aspect-auto bg-white dark:bg-gray-800 shadow-md border border-slate-100 rounded-2xl p-6 flex flex-col justify-between group hover:shadow-lg transition-all relative overflow-hidden">
                    <div class="relative z-10 flex flex-col justify-between h-full w-full">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10m-5-4v4m0-4V7a2 2 0 00-2-2H8a2 2 0 00-2 2v10h8V7m-4-2V3a1 1 0 00-1-1H9a1 1 0 00-1 1v2"></path></svg>
                            </div>
                            <h3 class="text-slate-500 font-medium text-sm mb-1">{{ __('عمليات اليوم') }}</h3>
                            <div class="text-3xl font-black text-slate-800">{{ $pendingSurgeries ?? 0 }}</div>
                        </div>

                        <div class="mt-4" x-data="{ showAddModal: false }">
                            <button @click="showAddModal = true" class="w-full justify-center text-sm font-bold text-white bg-purple-600 hover:bg-purple-700 shadow-sm px-4 py-2.5 rounded-xl transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                {{ __('إضافة عملية') }}
                            </button>

                            <!-- Add Surgery Modal -->
                            <div x-show="showAddModal" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div x-show="showAddModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showAddModal = false"></div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <div x-show="showAddModal" x-transition class="inline-block align-bottom bg-white rounded-2xl text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                                        <form method="POST" action="{{ route('surgeries.store') }}">
                                            @csrf
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-slate-100">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mt-3 text-center sm:mt-0 sm:text-right w-full">
                                                        <h3 class="text-xl font-bold text-gray-900 mb-6" id="modal-title">
                                                            {{ __('إضافة عملية جديدة') }}
                                                        </h3>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-right">
                                                            <!-- Patient -->
                                                            <div>
                                                                <x-input-label for="patient_id" :value="__('اسم المريض')" class="mb-1" />
                                                                <select id="patient_id" name="patient_id" class="border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block w-full py-2.5" required>
                                                                    <option value="" disabled selected>{{ __('اختر المريض') }}</option>
                                                                    @foreach($patients ?? [] as $patient)
                                                                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <!-- Surgery Type -->
                                                            <div>
                                                                <x-input-label for="surgery_type_id" :value="__('نوع العملية')" class="mb-1" />
                                                                <select id="surgery_type_id" name="surgery_type_id" class="border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block w-full py-2.5" required>
                                                                    <option value="" disabled selected>{{ __('اختر نوع العملية') }}</option>
                                                                    @foreach($surgeryTypes ?? [] as $type)
                                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <!-- Surgery Date -->
                                                            <div>
                                                                <x-input-label for="surgery_date" :value="__('تاريخ العملية')" class="mb-1" />
                                                                <input type="text" id="surgery_date" name="surgery_date" x-init="flatpickr($el, {allowInput: true, disableMobile: true, dateFormat: 'Y-m-d', defaultDate: 'today'})" class="border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block w-full text-left py-2.5" dir="ltr" required>
                                                            </div>

                                                            <!-- Hospital Name -->
                                                            <div>
                                                                <x-input-label for="hospital_name" :value="__('اسم المستشفى')" class="mb-1" />
                                                                <x-text-input id="hospital_name" name="hospital_name" type="text" class="block w-full rounded-xl py-2.5" required />
                                                            </div>

                                                            <!-- Surgeon Name -->
                                                            <div>
                                                                <x-input-label for="surgeon_name" :value="__('اسم الجراح')" class="mb-1" />
                                                                <x-text-input id="surgeon_name" name="surgeon_name" type="text" class="block w-full rounded-xl py-2.5" required value="{{ auth()->user()->name }}" />
                                                            </div>

                                                            <!-- Disease Name -->
                                                            <div>
                                                                <x-input-label for="disease_name" :value="__('اسم المرض / التشخيص')" class="mb-1" />
                                                                <x-text-input id="disease_name" name="disease_name" type="text" class="block w-full rounded-xl py-2.5" required />
                                                            </div>

                                                            <!-- Assistant Name -->
                                                            <div>
                                                                <x-input-label for="assistant_name" :value="__('اسم المساعد')" class="mb-1" />
                                                                <x-text-input id="assistant_name" name="assistant_name" type="text" class="block w-full rounded-xl py-2.5" />
                                                            </div>

                                                            <!-- Anesthesiologist Name -->
                                                            <div>
                                                                <x-input-label for="anesthesiologist_name" :value="__('اسم طبيب التخدير')" class="mb-1" />
                                                                <x-text-input id="anesthesiologist_name" name="anesthesiologist_name" type="text" class="block w-full rounded-xl py-2.5" />
                                                            </div>

                                                            <!-- Anesthesia Type -->
                                                            <div>
                                                                <x-input-label for="anesthesia_type" :value="__('نوع التخدير')" class="mb-1" />
                                                                <select id="anesthesia_type" name="anesthesia_type" class="border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block w-full py-2.5" required>
                                                                    <option value="" disabled selected>{{ __('اختر نوع التخدير') }}</option>
                                                                    <option value="{{ __('تخدير عام') }}">{{ __('تخدير عام') }}</option>
                                                                    <option value="{{ __('تخدير موضعي') }}">{{ __('تخدير موضعي') }}</option>
                                                                    <option value="{{ __('تخدير قطني') }}">{{ __('تخدير قطني') }}</option>
                                                                    <option value="{{ __('أخرى') }}">{{ __('أخرى') }}</option>
                                                                </select>
                                                            </div>

                                                            <!-- Cost -->
                                                            <div>
                                                                <x-input-label for="cost" :value="__('التكلفة')" class="mb-1" />
                                                                <div class="relative mt-1">
                                                                    <x-text-input id="cost" name="cost" type="number" step="0.01" min="0" class="block w-full pl-10 rounded-xl py-2.5" required />
                                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                        <span class="text-gray-500 sm:text-sm">{{ __('د.ع') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="md:col-span-2">
                                                                <x-input-label for="notes" :value="__('ملاحظات')" class="mb-1" />
                                                                <textarea id="notes" name="notes" rows="3" class="border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block w-full"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl">
                                                <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                    {{ __('إضافة العملية') }}
                                                </button>
                                                <button type="button" @click="showAddModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                    {{ __('إلغاء') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Decorative element matching Secretary style -->
                    <div class="absolute -left-6 -bottom-6 w-32 h-32 bg-purple-50 rounded-full opacity-50 group-hover:scale-110 transition-transform pointer-events-none"></div>
                </div>

                <!-- Pending Appointments Card -->
                <div class="col-span-12 md:col-span-4 aspect-square md:aspect-auto bg-white dark:bg-gray-800 shadow-md border border-slate-100 rounded-2xl p-6 flex flex-col justify-between group hover:shadow-lg transition-all relative overflow-hidden">
                    <div class="relative z-10 flex flex-col justify-between h-full w-full gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-slate-500 font-medium text-sm mb-1">{{ __('المراجعين في الانتظار') }}</h3>
                                <div class="text-2xl font-black text-slate-800">{{ $pendingCount }}</div>
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('doctor.appointments.index') }}" class="w-full justify-center text-sm font-bold text-white bg-black hover:bg-neutral-800 shadow-sm px-4 py-2.5 rounded-xl transition-colors flex items-center gap-2">
                                {{ __('عرض القائمة كاملة') }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </a>
                        </div>
                    </div>
                    <div class="absolute -left-6 -bottom-6 w-32 h-32 bg-orange-50 rounded-full opacity-50 group-hover:scale-110 transition-transform pointer-events-none"></div>
                </div>

                <!-- 3. Medical Analytics Chart -->
                <div class="col-span-12 md:col-span-6 bg-white dark:bg-gray-800 shadow-md border border-slate-100 rounded-2xl overflow-hidden flex flex-col min-h-[400px]" x-data="medicalAnalytics()">
                    <div class="p-6 h-full flex flex-col">
                        <!-- Top Controls -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-teal-50 flex items-center justify-center text-teal-600">
                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </div>
                                <h2 class="text-lg font-bold text-slate-800">{{ __('المخطط الطبي') }}</h2>
                            </div>

                            <div class="flex items-center gap-2 w-full sm:w-auto bg-slate-50 p-1.5 rounded-xl border border-slate-100">
                                <!-- Dropdown Filter -->
                                <select x-model="timeFilter" @change="updateChart" class="border-none bg-transparent rounded-lg focus:ring-0 text-sm py-1.5 px-3 font-medium text-slate-600 cursor-pointer w-full sm:w-auto">
                                    <option value="today">{{ __('اليوم') }}</option>
                                    <option value="week">{{ __('اسبوع') }}</option>
                                    <option value="month">{{ __('شهر') }}</option>
                                    <option value="year">{{ __('سنة') }}</option>
                                    <option value="all">{{ __('الكل') }}</option>
                                </select>

                                <div class="w-px h-6 bg-slate-200"></div>

                                <!-- Date Picker -->
                                <div class="relative w-full sm:w-auto">
                                    <input type="text" x-model="customDate" x-ref="datePicker" placeholder="{{ __('تاريخ محدد') }}" class="border-none bg-transparent rounded-lg focus:ring-0 text-sm py-1.5 px-2 w-full sm:w-28 text-left font-medium text-slate-600 cursor-pointer placeholder-slate-400" dir="ltr">
                                </div>
                            </div>
                        </div>

                        <!-- Chart Container -->
                        <div class="flex-1 w-full" x-ref="chartContainer"></div>

                        <!-- Bottom Tabs -->
                        <div class="flex flex-wrap items-center justify-center gap-2 mt-6 pt-4 border-t border-slate-100">
                            <template x-for="tab in tabs" :key="tab.id">
                                <button
                                    @click="activeTab = tab.id; updateChart()"
                                    :class="activeTab === tab.id ? 'bg-black text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200'"
                                    class="px-4 py-2 rounded-xl font-bold text-xs transition-all duration-200"
                                    x-text="tab.name"
                                ></button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- 5. Financial Stats Section -->
                <div class="col-span-12 md:col-span-6 bg-slate-900 rounded-2xl shadow-xl border border-slate-800 p-6 sm:p-8 text-white relative overflow-hidden flex flex-col justify-between min-h-[400px]">
                    <!-- Decor -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="relative z-10 mb-8 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center backdrop-blur-md border border-white/20">
                                <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h2 class="text-xl font-bold">{{ __('الإحصائيات المالية الشاملة') }}</h2>
                        </div>
                    </div>

                    <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Income -->
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                            <div class="text-sm text-slate-400 mb-2">{{ __('الدخل العام') }}</div>
                            <div class="text-2xl font-black text-white">{{ number_format($totalIncome ?? 0) }} <span class="text-sm font-normal text-slate-400">{{ __('د.ع') }}</span></div>
                        </div>

                        <!-- Net Worth -->
                        <div class="bg-teal-500/10 p-4 rounded-2xl border border-teal-500/20">
                            <div class="text-sm text-teal-200 mb-2">{{ __('صافي الثروة') }}</div>
                            <div class="text-2xl font-black text-teal-400">{{ number_format($netWorth ?? 0) }} <span class="text-sm font-normal text-teal-200/50">{{ __('د.ع') }}</span></div>
                        </div>

                        <!-- Total Expenses -->
                        <div class="bg-red-500/10 p-4 rounded-2xl border border-red-500/20">
                            <div class="text-sm text-red-200 mb-2">{{ __('إجمالي المصاريف') }}</div>
                            <div class="text-2xl font-black text-red-400">{{ number_format($totalExpenses ?? 0) }} <span class="text-sm font-normal text-red-200/50">{{ __('د.ع') }}</span></div>
                        </div>

                        <!-- Surgery Income -->
                        <div class="bg-purple-500/10 p-4 rounded-2xl border border-purple-500/20">
                            <div class="text-sm text-purple-200 mb-2">{{ __('أموال العمليات') }}</div>
                            <div class="text-2xl font-black text-purple-400">{{ number_format($totalSurgeryIncome ?? 0) }} <span class="text-sm font-normal text-purple-200/50">{{ __('د.ع') }}</span></div>
                        </div>
                    </div>

                    <div class="relative z-10 grid grid-cols-2 md:grid-cols-3 gap-6 pt-6 border-t border-white/10">
                        <div>
                            <div class="text-sm text-slate-400 mb-1">{{ __('متوسط دخل العملية الواحدة') }}</div>
                            <div class="font-bold text-white text-lg">{{ number_format($avgSurgeryIncome ?? 0) }} <span class="text-xs font-normal text-slate-500">{{ __('د.ع') }}</span></div>
                        </div>
                        <div>
                            <div class="text-sm text-slate-400 mb-1">{{ __('تفصيل المصاريف') }} ({{ __('مدفوعة') }} / {{ __('غير مدفوعة') }})</div>
                            <div class="font-bold text-lg flex items-center gap-2">
                                <span class="text-emerald-400">{{ number_format($paidExpenses ?? 0) }}</span>
                                <span class="text-slate-600">/</span>
                                <span class="text-rose-400">{{ number_format($unpaidExpenses ?? 0) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Financial Analytics Chart -->
                <div class="col-span-12 md:col-span-8 md:col-start-3 bg-white dark:bg-gray-800 shadow-md border border-slate-100 rounded-2xl overflow-hidden flex flex-col min-h-[400px]" x-data="financialAnalytics()">
                    <div class="p-6 h-full flex flex-col">
                        <!-- Top Controls -->
                        <div class="flex flex-col items-start gap-4 mb-6">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h2 class="text-lg font-bold text-slate-800">{{ __('مؤشر النمو المالي') }}</h2>
                            </div>

                            <div class="flex items-center gap-2 w-full bg-slate-50 p-1.5 rounded-xl border border-slate-100">
                                <select x-model="timeFilter" @change="updateChart" class="border-none bg-transparent rounded-lg focus:ring-0 text-sm py-1.5 px-3 font-medium text-slate-600 cursor-pointer flex-1">
                                    <option value="today">{{ __('اليوم') }}</option>
                                    <option value="week">{{ __('اسبوع') }}</option>
                                    <option value="month">{{ __('شهر') }}</option>
                                    <option value="year">{{ __('سنة') }}</option>
                                    <option value="all">{{ __('الكل') }}</option>
                                </select>
                                <div class="w-px h-6 bg-slate-200"></div>
                                <div class="relative w-28">
                                    <input type="text" x-model="customDate" x-ref="financeDatePicker" placeholder="{{ __('محدد') }}" class="border-none bg-transparent rounded-lg focus:ring-0 text-sm py-1.5 px-2 w-full text-left font-medium text-slate-600 cursor-pointer placeholder-slate-400" dir="ltr">
                                </div>
                            </div>
                        </div>

                        <!-- Chart Container -->
                        <div class="flex-1 w-full" x-ref="financeChartContainer">


    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('financialAnalytics', () => ({
                chart: null,
                timeFilter: 'month',
                customDate: '',
                // Dummy Data for Financial Trends
                financeSeries: [{
                    name: '{{ __('الدخل') }}',
                    data: @json($financeData)
                }],
                financeLabels: @json($financeLabels),

                init() {
                    flatpickr(this.$refs.financeDatePicker, {
                        allowInput: true,
                        disableMobile: true,
                        dateFormat: 'Y-m-d',
                        onChange: (selectedDates, dateStr) => {
                            this.customDate = dateStr;
                            this.timeFilter = '';
                            this.updateChart();
                        }
                    });

                    this.$nextTick(() => {
                        this.renderChart();
                    });
                },

                renderChart() {
                    const options = {
                        series: this.financeSeries,
                        chart: {
                            type: 'area',
                            height: '100%',
                            fontFamily: 'inherit',
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800,
                                dynamicAnimation: {
                                    enabled: true,
                                    speed: 350
                                }
                            },
                            toolbar: { show: false },
                            parentHeightOffset: 0
                        },
                        colors: ['#0f172a'], // slate-900 (matches black buttons)
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.1,
                                opacityTo: 0.0,
                                stops: [0, 90, 100]
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 3
                        },
                        xaxis: {
                            categories: this.financeLabels,
                            labels: {
                                style: { fontWeight: 600, colors: '#64748b' }
                            },
                            axisBorder: { show: false },
                            axisTicks: { show: false }
                        },
                        yaxis: {
                            labels: {
                                style: { colors: '#64748b' },
                                formatter: (value) => {
                                    return Number(value).toLocaleString('ar-IQ');
                                }
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return Number(val).toLocaleString('ar-IQ') + " {{ __('د.ع') }}";
                                }
                            }
                        },
                        grid: {
                            borderColor: '#f1f5f9',
                            strokeDashArray: 4,
                            padding: { top: 0, right: 0, bottom: 0, left: 10 }
                        }
                    };

                    this.chart = new window.ApexCharts(this.$refs.financeChartContainer, options);
                    this.chart.render();
                },

                updateChart() {
                    // Logic to update chart based on this.timeFilter / this.customDate
                    // Requires AJAX call for real dynamic update, omitted for now since we pass json
                }
            }));

            Alpine.data('medicalAnalytics', () => ({
                chart: null,
                timeFilter: 'month',
                customDate: '',
                activeTab: 'gender',
                tabs: [
                    { id: 'gender', name: '{{ __('نسبة الذكور والإناث') }}' },
                    { id: 'diseases', name: '{{ __('الأمراض الشائعة') }}' },
                    { id: 'age', name: '{{ __('أعمار المراجعين') }}' },
                    { id: 'medications', name: '{{ __('الأدوية الموصوفة') }}' },
                    { id: 'surgeries', name: '{{ __('العمليات') }}' }
                ],
                // Real Data passed from Controller
                medicalData: {
                    gender: { type: 'pie', series: [@json($maleCount), @json($femaleCount)], labels: ['{{ __('ذكور') }}', '{{ __('إناث') }}'] },
                    diseases: { type: 'bar', series: [{ name: '{{ __('الحالات') }}', data: @json($diseasesData) }], labels: @json($diseasesLabels) },
                    age: { type: 'bar', series: [{ name: '{{ __('العدد') }}', data: [@json($ageGroups['0-18']), @json($ageGroups['19-30']), @json($ageGroups['31-45']), @json($ageGroups['46-60']), @json($ageGroups['60+'])] }], labels: ['0-18', '19-30', '31-45', '46-60', '60+'] },
                    medications: { type: 'donut', series: @json($medicationsData), labels: @json($medicationsLabels) },
                    surgeries: { type: 'bar', series: [{ name: '{{ __('العمليات') }}', data: @json($surgeriesData) }], labels: @json($surgeriesLabels) }
                },

                init() {
                    flatpickr(this.$refs.datePicker, {
                        allowInput: true,
                        disableMobile: true,
                        dateFormat: 'Y-m-d',
                        onChange: (selectedDates, dateStr) => {
                            this.customDate = dateStr;
                            this.timeFilter = ''; // clear dropdown
                            this.updateChart();
                        }
                    });

                    this.$nextTick(() => {
                        this.renderChart();
                    });
                },

                renderChart() {
                    const data = this.medicalData[this.activeTab];

                    const options = {
                        series: data.series,
                        chart: {
                            type: data.type,
                            height: 280,
                            fontFamily: 'inherit',
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800,
                                dynamicAnimation: {
                                    enabled: true,
                                    speed: 350
                                }
                            },
                            toolbar: { show: false }
                        },
                        labels: data.labels,
                        colors: ['#0f172a', '#4f46e5', '#14b8a6', '#f59e0b', '#8b5cf6'],
                        dataLabels: {
                            enabled: data.type === 'pie' || data.type === 'donut',
                            style: { fontFamily: 'inherit' }
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 6,
                                horizontal: false,
                                columnWidth: '45%'
                            }
                        },
                        xaxis: {
                            categories: data.type === 'bar' ? data.labels : [],
                            labels: {
                                style: { fontWeight: 600, colors: '#64748b' }
                            },
                            axisBorder: { show: false },
                            axisTicks: { show: false }
                        },
                        yaxis: {
                            labels: { style: { colors: '#64748b' } }
                        },
                        legend: {
                            position: 'bottom',
                            fontFamily: 'inherit',
                            fontWeight: 600
                        },
                        stroke: {
                            curve: 'smooth',
                            width: data.type === 'bar' ? 0 : 2
                        },
                        grid: {
                            borderColor: '#f1f5f9',
                            strokeDashArray: 4,
                        }
                    };

                    this.chart = new window.ApexCharts(this.$refs.chartContainer, options);
                    this.chart.render();
                },

                updateChart() {
                    const data = this.medicalData[this.activeTab];

                    if (this.chart) {
                        this.chart.destroy();
                    }
                    this.renderChart();
                }
            }));

            if(!Alpine.data('liveTimer')) {
                Alpine.data('liveTimer', (startedAtIso) => ({
                    startedAt: new Date(startedAtIso),
                    now: new Date(),
                    timeString: '00:00',
                    interval: null,
                    init() {
                        this.updateTimer();
                        this.interval = setInterval(() => {
                            this.now = new Date();
                            this.updateTimer();
                        }, 1000);
                    },
                    updateTimer() {
                        const diffMs = this.now - this.startedAt;
                        if (diffMs < 0) {
                            this.timeString = '00:00';
                            return;
                        }
                        const totalSeconds = Math.floor(diffMs / 1000);
                        const minutes = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
                        const seconds = (totalSeconds % 60).toString().padStart(2, '0');
                        this.timeString = `${minutes}:${seconds}`;
                    },
                    destroy() {
                        if (this.interval) clearInterval(this.interval);
                    }
                }));
            }
        });
    </script>
</x-doctor-layout>
