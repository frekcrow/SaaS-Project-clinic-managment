<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $greeting ?? __('Doctor Dashboard Workspace') }} - {{ __('هل أنت مستعد ليومك؟') }}
        </h2>
    </x-slot>

    <div class="h-[calc(100vh-10rem)] flex flex-col overflow-hidden">
        <div class="max-w-7xl mx-auto w-full flex-1 flex flex-col min-h-0">
            <div class="mb-4 shrink-0">
                <h1 class="text-2xl font-bold text-slate-800">{{ $greeting ?? __('مرحباً د. :name', ['name' => auth()->user()->name]) }}</h1>
                <p class="text-slate-500 mt-1 text-sm">{{ __('هنا ملخص لجدولك اليوم، نتمنى لك يوماً سعيداً وناجحاً') }}.</p>
            </div>

            @php
                $pendingAppt = $todaysAppointments->where('status', 'pending')->first();
                $pendingCount = $todaysAppointments->where('status', 'pending')->count();
            @endphp

            <div class="flex-1 overflow-y-auto pr-2 space-y-4">
            <!-- 1. The Live Patient Queue Card and Quick Stats Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 shrink-0">
                <!-- Patient Queue Card spans 2 columns on lg -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-slate-100 overflow-hidden relative">
                    <!-- Top accent line -->
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-teal-400 to-blue-500"></div>

                    <div class="p-4 flex flex-col md:flex-row items-center justify-between gap-4">
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
                                    <a href="{{ route('patients.show', $pendingAppt->patient->id) }}" class="inline-flex items-center text-xs text-slate-500 hover:text-teal-600 transition-colors gap-1 group">
                                        <svg class="w-3 h-3 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                        {{ __('عرض الملف الطبي الكامل') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        @if($pendingAppt)
                            <div class="flex items-center gap-2 w-full md:w-auto">
                                <form method="POST" action="{{ route('appointments.update_status', $pendingAppt) }}" class="w-full md:w-auto">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="in_progress">
                                    <button type="submit" class="w-full md:w-auto px-4 py-2 bg-black text-white rounded-xl font-bold text-sm shadow-sm hover:bg-neutral-800 hover:shadow-md transition-all flex items-center justify-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ __('بدء الجلسة') }}
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('appointments.update_status', $pendingAppt) }}" class="w-full md:w-auto">
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
                        <div class="border-t border-slate-100 bg-slate-50/50 p-4 flex flex-col md:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-blue-600 mb-1">{{ __('جلسة نشطة حالياً') }}</div>
                                    <div class="text-sm font-semibold text-slate-800">{{ $inProgressAppt->patient_name ?? ($inProgressAppt->patient ? $inProgressAppt->patient->name : '-') }}</div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div x-data="liveTimer('{{ $inProgressAppt->session_started_at ? $inProgressAppt->session_started_at->toIso8601String() : now()->toIso8601String() }}')" class="text-blue-600 font-mono font-bold text-lg flex items-center gap-2 bg-white px-3 py-1.5 rounded-xl border border-blue-100 shadow-sm" dir="ltr">
                                    <span x-text="timeString"></span>
                                    <svg class="w-4 h-4 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>

                                <form method="POST" action="{{ route('appointments.update_status', $inProgressAppt) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="px-4 py-1.5 bg-blue-600 text-white rounded-xl font-bold text-sm shadow-sm hover:bg-blue-700 transition-colors">
                                        {{ __('إنهاء') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Card 1 (Today's Surgeries) -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-slate-100 p-4 flex items-center justify-between group hover:shadow-md transition-shadow relative overflow-hidden">
                    <div class="relative z-10 flex flex-col justify-between h-full w-full">
                        <div>
                            <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center mb-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10m-5-4v4m0-4V7a2 2 0 00-2-2H8a2 2 0 00-2 2v10h8V7m-4-2V3a1 1 0 00-1-1H9a1 1 0 00-1 1v2"></path></svg>
                            </div>
                            <h3 class="text-slate-500 font-medium text-sm mb-1">{{ __('عمليات اليوم') }}</h3>
                            <div class="text-2xl font-black text-slate-800">{{ $pendingSurgeries ?? 0 }}</div>
                        </div>

                        <div class="mt-4" x-data="{ showAddModal: false }">
                            <button @click="showAddModal = true" class="text-xs font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                {{ __('إضافة عملية') }}
                            </button>

                            <!-- Add Surgery Modal -->
                            <div x-show="showAddModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div x-show="showAddModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <div x-show="showAddModal" x-transition class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                                        <form method="POST" action="{{ route('surgeries.store') }}">
                                            @csrf
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-right w-full">
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                            {{ __('إضافة عملية جديدة') }}
                                                        </h3>
                                                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-right">
                                                            <!-- Patient -->
                                                            <div>
                                                                <x-input-label for="patient_id" :value="__('اسم المريض')" />
                                                                <select id="patient_id" name="patient_id" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full" required>
                                                                    <option value="" disabled selected>{{ __('اختر المريض') }}</option>
                                                                    @foreach($patients ?? [] as $patient)
                                                                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <!-- Surgery Type -->
                                                            <div>
                                                                <x-input-label for="surgery_type_id" :value="__('نوع العملية')" />
                                                                <select id="surgery_type_id" name="surgery_type_id" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full" required>
                                                                    <option value="" disabled selected>{{ __('اختر نوع العملية') }}</option>
                                                                    @foreach($surgeryTypes ?? [] as $type)
                                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <!-- Surgery Date -->
                                                            <div>
                                                                <x-input-label for="surgery_date" :value="__('تاريخ العملية')" />
                                                                <input type="text" id="surgery_date" name="surgery_date" x-init="flatpickr($el, {allowInput: true, disableMobile: true, dateFormat: 'Y-m-d', defaultDate: 'today'})" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full text-left" dir="ltr" required>
                                                            </div>

                                                            <!-- Hospital Name -->
                                                            <div>
                                                                <x-input-label for="hospital_name" :value="__('اسم المستشفى')" />
                                                                <x-text-input id="hospital_name" name="hospital_name" type="text" class="mt-1 block w-full" required />
                                                            </div>

                                                            <!-- Surgeon Name -->
                                                            <div>
                                                                <x-input-label for="surgeon_name" :value="__('اسم الجراح')" />
                                                                <x-text-input id="surgeon_name" name="surgeon_name" type="text" class="mt-1 block w-full" required value="{{ auth()->user()->name }}" />
                                                            </div>

                                                            <!-- Disease Name -->
                                                            <div>
                                                                <x-input-label for="disease_name" :value="__('اسم المرض / التشخيص')" />
                                                                <x-text-input id="disease_name" name="disease_name" type="text" class="mt-1 block w-full" required />
                                                            </div>

                                                            <!-- Assistant Name -->
                                                            <div>
                                                                <x-input-label for="assistant_name" :value="__('اسم المساعد')" />
                                                                <x-text-input id="assistant_name" name="assistant_name" type="text" class="mt-1 block w-full" />
                                                            </div>

                                                            <!-- Anesthesiologist Name -->
                                                            <div>
                                                                <x-input-label for="anesthesiologist_name" :value="__('اسم طبيب التخدير')" />
                                                                <x-text-input id="anesthesiologist_name" name="anesthesiologist_name" type="text" class="mt-1 block w-full" />
                                                            </div>

                                                            <!-- Anesthesia Type -->
                                                            <div>
                                                                <x-input-label for="anesthesia_type" :value="__('نوع التخدير')" />
                                                                <select id="anesthesia_type" name="anesthesia_type" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full" required>
                                                                    <option value="" disabled selected>{{ __('اختر نوع التخدير') }}</option>
                                                                    <option value="{{ __('تخدير عام') }}">{{ __('تخدير عام') }}</option>
                                                                    <option value="{{ __('تخدير موضعي') }}">{{ __('تخدير موضعي') }}</option>
                                                                    <option value="{{ __('تخدير قطني') }}">{{ __('تخدير قطني') }}</option>
                                                                    <option value="{{ __('أخرى') }}">{{ __('أخرى') }}</option>
                                                                </select>
                                                            </div>

                                                            <!-- Cost -->
                                                            <div>
                                                                <x-input-label for="cost" :value="__('التكلفة')" />
                                                                <div class="relative mt-1">
                                                                    <x-text-input id="cost" name="cost" type="number" step="0.01" min="0" class="block w-full pl-10" required />
                                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                        <span class="text-gray-500 sm:text-sm">{{ __('د.ع') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="md:col-span-2">
                                                                <x-input-label for="notes" :value="__('ملاحظات')" />
                                                                <textarea id="notes" name="notes" rows="3" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200">
                                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                    {{ __('إضافة العملية') }}
                                                </button>
                                                <button type="button" @click="showAddModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                    {{ __('إلغاء') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -left-6 -bottom-6 w-32 h-32 bg-indigo-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                </div>

                <!-- Card 2 (Pending Appointments) -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-slate-100 p-4 flex items-center justify-between group hover:shadow-md transition-shadow relative overflow-hidden">
                    <div class="relative z-10 flex flex-col justify-between h-full w-full">
                        <div>
                            <div class="w-8 h-8 rounded-xl bg-orange-50 flex items-center justify-center mb-2">
                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-slate-500 font-medium text-sm mb-1">{{ __('المراجعين في الانتظار') }}</h3>
                            <div class="text-2xl font-black text-slate-800">{{ $pendingCount }}</div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('appointments.index') }}" class="text-xs font-bold text-orange-600 bg-orange-50 hover:bg-orange-100 px-3 py-1.5 rounded-lg transition-colors inline-flex items-center gap-1">
                                {{ __('عرض القائمة كاملة') }}
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </a>
                        </div>
                    </div>
                    <div class="absolute -left-6 -bottom-6 w-32 h-32 bg-orange-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 shrink-0 pb-4">
                <!-- 3. Medical Analytics Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-slate-100 overflow-hidden shrink-0 flex flex-col justify-between" x-data="medicalAnalytics()">
                    <div class="p-4 h-full flex flex-col">
                        <!-- Top Controls -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-2 mb-4">
                            <h2 class="text-lg font-bold text-slate-800">{{ __('المخطط الطبي') }}</h2>

                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                <!-- Dropdown Filter -->
                                <select x-model="timeFilter" @change="updateChart" class="border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500 text-xs py-1.5 px-2">
                                    <option value="today">{{ __('اليوم') }}</option>
                                    <option value="week">{{ __('اسبوع') }}</option>
                                    <option value="month">{{ __('شهر') }}</option>
                                    <option value="year">{{ __('سنة') }}</option>
                                    <option value="all">{{ __('الكل') }}</option>
                                </select>

                                <!-- Date Picker -->
                                <div class="relative w-full sm:w-auto">
                                    <input type="text" x-model="customDate" x-ref="datePicker" placeholder="{{ __('تاريخ محدد') }}" class="border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500 text-xs py-1.5 px-2 w-full sm:w-28 text-left" dir="ltr">
                                </div>
                            </div>
                        </div>

                        <!-- Chart Container -->
                        <div class="flex-1 min-h-[200px] w-full" x-ref="chartContainer"></div>

                        <!-- Bottom Tabs -->
                        <div class="flex flex-wrap items-center justify-center gap-2 mt-4">
                            <template x-for="tab in tabs" :key="tab.id">
                                <button
                                    @click="activeTab = tab.id; updateChart()"
                                    :class="activeTab === tab.id ? 'bg-teal-600 text-white shadow-md' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'"
                                    class="px-3 py-1.5 rounded-xl font-bold text-xs transition-all duration-200"
                                    x-text="tab.name"
                                ></button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- 4. Financial Analytics Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-slate-100 overflow-hidden" x-data="financialAnalytics()">
                    <div class="p-4 h-full flex flex-col">
                        <!-- Top Controls -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-2 mb-4">
                            <h2 class="text-lg font-bold text-slate-800">{{ __('مؤشر النمو المالي') }}</h2>

                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                <select x-model="timeFilter" @change="updateChart" class="border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500 text-xs py-1.5 px-2">
                                    <option value="today">{{ __('اليوم') }}</option>
                                    <option value="week">{{ __('اسبوع') }}</option>
                                    <option value="month">{{ __('شهر') }}</option>
                                    <option value="year">{{ __('سنة') }}</option>
                                    <option value="all">{{ __('الكل') }}</option>
                                </select>
                                <div class="relative w-full sm:w-auto">
                                    <input type="text" x-model="customDate" x-ref="financeDatePicker" placeholder="{{ __('تاريخ محدد') }}" class="border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500 text-xs py-1.5 px-2 w-full sm:w-28 text-left" dir="ltr">
                                </div>
                            </div>
                        </div>

                        <!-- Chart Container -->
                        <div class="flex-1 min-h-[200px] w-full" x-ref="financeChartContainer"></div>
                    </div>
                </div>
            </div>

            <!-- 5. Financial Stats Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 shrink-0 pb-4">
                <!-- Financial Stats Card -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl shadow-lg border border-slate-700 p-4 text-white relative overflow-hidden flex flex-col justify-between">
                    <!-- Decor -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-[100px]"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-teal-500/20 rounded-tr-[80px] blur-2xl"></div>

                    <div class="relative z-10 mb-4">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h2 class="text-lg font-bold">{{ __('الإحصائيات المالية') }}</h2>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Income -->
                            <div>
                                <div class="text-xs text-slate-400 mb-1">{{ __('الدخل العام') }}</div>
                                <div class="text-xl font-black text-white">{{ number_format($totalIncome ?? 0) }} {{ __('د.ع') }}</div>
                            </div>

                            <!-- Net Worth -->
                            <div>
                                <div class="text-xs text-slate-400 mb-1">{{ __('صافي الثروة') }}</div>
                                <div class="text-lg font-bold text-teal-400">{{ number_format($netWorth ?? 0) }} {{ __('د.ع') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10 grid grid-cols-2 gap-4 pt-4 border-t border-white/10">
                        <div>
                            <div class="text-xs text-slate-400 mb-1">{{ __('مجموع أموال العمليات') }}</div>
                            <div class="font-bold text-white text-sm">{{ number_format($totalSurgeryIncome ?? 0) }} {{ __('د.ع') }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400 mb-1">{{ __('متوسط الدخل للعملية') }}</div>
                            <div class="font-bold text-white text-sm">{{ number_format($avgSurgeryIncome ?? 0) }} {{ __('د.ع') }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400 mb-1">{{ __('إجمالي المصاريف') }}</div>
                            <div class="font-bold text-red-400 text-sm">{{ number_format($totalExpenses ?? 0) }} {{ __('د.ع') }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-400 mb-1">{{ __('المصاريف') }} ({{ __('مدفوعة') }}/{{ __('غير مدفوعة') }})</div>
                            <div class="font-bold text-white text-xs">
                                <span class="text-green-400">{{ number_format($paidExpenses ?? 0) }}</span> /
                                <span class="text-red-400">{{ number_format($unpaidExpenses ?? 0) }}</span>
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
                            fontFamily: 'Tajawal, sans-serif',
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
                        colors: ['#0d9488'], // teal-600
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.4,
                                opacityTo: 0.05,
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
                                style: { fontFamily: 'Tajawal', fontWeight: 600 }
                            }
                        },
                        yaxis: {
                            labels: {
                                style: { fontFamily: 'Tajawal' },
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
                            fontFamily: 'Tajawal, sans-serif',
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
                        colors: ['#0d9488', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6'],
                        dataLabels: {
                            enabled: data.type === 'pie' || data.type === 'donut',
                            style: { fontFamily: 'Tajawal' }
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 4,
                                horizontal: false,
                                columnWidth: '45%'
                            }
                        },
                        xaxis: {
                            categories: data.type === 'bar' ? data.labels : [],
                            labels: {
                                style: { fontFamily: 'Tajawal', fontWeight: 600 }
                            }
                        },
                        yaxis: {
                            labels: { style: { fontFamily: 'Tajawal' } }
                        },
                        legend: {
                            position: 'bottom',
                            fontFamily: 'Tajawal, sans-serif',
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