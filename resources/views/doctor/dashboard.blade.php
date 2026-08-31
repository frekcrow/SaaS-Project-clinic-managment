<x-doctor-layout>
    @push('styles')

    <style>
        /* Fix the Z index of modals */
        .z-50 { z-index: 100 !important; }

        /* Premium Entrance Animations */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-up {
            animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
    </style>

    @endpush
    <x-slot name="header">
        {{ $greeting ?? __('Doctor Dashboard Workspace') }} - {{ __('هل أنت مستعد ليومك؟') }}
    </x-slot>

    <div class="grid-wrapper dark:bg-[#0a0a0a]">
        <div class="grid-background"></div>
        <div class="relative z-10 p-4 sm:p-6 h-full w-full">
            <div class="space-y-6">
                @php
                    $pendingAppt = $todaysAppointments->where('status', 'arrived')->sortBy('queue_number')->first();
            $pendingBookingsCount = $todaysAppointments->where('status', 'pending')->count();
            $arrivedCount = $todaysAppointments->where('status', 'arrived')->count();
        @endphp

        <div>

<!-- Dashboard Cards: Bento Grid -->
<div class="grid grid-cols-12 gap-6 w-full">

    <!-- Row 1: Compact Cards -->
    <div class="col-span-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm dark:shadow-none p-6 overflow-hidden">
        <div class="flex w-full flex-col">
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-teal-50 border-4 border-white shadow-sm dark:shadow-none flex items-center justify-center flex-shrink-0 relative">
                        <svg class="w-8 h-8 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        @if($pendingAppt)
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-black text-white rounded-full flex items-center justify-center font-bold text-xs shadow-sm dark:shadow-none border-2 border-white">
                                #{{ $pendingAppt->queue_number }}
                            </div>
                        @endif
                    </div>

                    <div class="overflow-hidden">
                        <div class="text-xs font-bold tracking-wide text-teal-600 mb-1 uppercase flex items-center gap-2">
                            <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                            </span>
                            {{ __('المراجع القادم') }} ({{ __('الانتظار') }})
                        </div>
                        <h2 class="text-lg sm:text-xl font-bold text-slate-800 dark:text-slate-200 mb-1 truncate">
                            {{ $pendingAppt ? ($pendingAppt->patient_name ?? ($pendingAppt->patient ? $pendingAppt->patient->name : '-')) : __('لا يوجد مراجعين في الانتظار') }}
                        </h2>
                        @if($pendingAppt && $pendingAppt->patient)
                            <a href="{{ route('doctor.patients.show', $pendingAppt->patient->id) }}" class="inline-flex items-center text-xs text-slate-500 hover:text-teal-600 transition-colors gap-1 group">
                                <svg class="w-3 h-3 group-hover:-translate-x-1 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                {{ __('عرض الملف الطبي الكامل') }}
                            </a>
                        @endif
                    </div>
                </div>

                @if($pendingAppt)
                    <div class="flex flex-wrap gap-2 mt-2 w-full">
                        <form method="POST" action="{{ route('doctor.appointments.update_status', $pendingAppt) }}" class="flex-grow sm:flex-grow-0">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="in_progress">
                            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-black text-white rounded-xl font-bold text-sm shadow-sm dark:shadow-none hover:bg-neutral-800 hover:shadow-md transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ __('بدء الجلسة') }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('doctor.appointments.update_status', $pendingAppt) }}" class="flex-grow sm:flex-grow-0">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-white dark:bg-gray-800 text-red-600 border border-slate-200 dark:border-gray-700 rounded-xl font-bold text-sm shadow-sm dark:shadow-none hover:bg-red-50 hover:border-red-100 transition-all">
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
                <div class="mt-4 border-t border-slate-100 dark:border-gray-700 bg-slate-50 dark:bg-gray-900 p-4 rounded-xl flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-indigo-600 mb-1">{{ __('جلسة نشطة حالياً') }}</div>
                            <div class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $inProgressAppt->patient_name ?? ($inProgressAppt->patient ? $inProgressAppt->patient->name : '-') }}</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div x-data="liveTimer('{{ $inProgressAppt->session_started_at ? $inProgressAppt->session_started_at->toIso8601String() : now()->toIso8601String() }}')" class="text-indigo-600 font-mono font-bold text-lg flex items-center gap-2 bg-white dark:bg-gray-800 px-3 py-1.5 rounded-xl border border-indigo-100 shadow-sm dark:shadow-none" dir="ltr">
                            <span x-text="timeString"></span>
                            <svg class="w-4 h-4 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>

                        <form method="POST" action="{{ route('doctor.appointments.update_status', $inProgressAppt) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-xl font-bold text-sm shadow-sm dark:shadow-none hover:bg-indigo-700 transition-colors">
                                {{ __('إنهاء') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Today's Surgeries Card -->
    <div class="col-span-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm dark:shadow-none p-4 relative overflow-hidden group">
        <div class="flex w-full flex-col">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10m-5-4v4m0-4V7a2 2 0 00-2-2H8a2 2 0 00-2 2v10h8V7m-4-2V3a1 1 0 00-1-1H9a1 1 0 00-1 1v2"></path></svg>
                </div>
                <div>
                    <h3 class="text-slate-500 font-medium text-sm mb-1 flex items-center gap-2">
                        {{ __('عمليات اليوم') }}
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </h3>
                    <div class="text-2xl font-black text-slate-800 dark:text-slate-200">{{ $pendingSurgeries ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Appointments Card -->
    <div class="col-span-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm dark:shadow-none p-4 relative overflow-hidden group">
        <div class="relative z-10 flex flex-col h-full w-full gap-4">
            <!-- Header with Title and Button -->
            <div class="flex justify-between items-center mb-2">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-slate-800 dark:text-slate-200 font-bold text-sm">{{ __('حالة المراجعين اليوم') }}</h3>
                </div>
                <a href="{{ route('doctor.appointments.index') }}" class="text-xs font-bold text-white bg-black hover:bg-neutral-800 shadow-sm dark:shadow-none px-3 py-1 rounded-lg transition-colors flex items-center gap-1">
                    {{ __('القائمة') }}
                </a>
            </div>

            <!-- Split Content -->
            <div class="grid grid-cols-2 divide-x divide-x-reverse flex-1 items-center mt-2">
                <div class="flex flex-col px-2">
                    <h4 class="text-slate-500 font-medium text-xs mb-1">{{ __('قيد الانتظار') }}</h4>
                    <div class="text-2xl font-black text-slate-800 dark:text-slate-200">{{ $pendingBookingsCount }}</div>
                </div>
                <div class="flex flex-col px-2">
                    <h4 class="text-slate-500 font-medium text-xs mb-1">{{ __('حاضر') }}</h4>
                    <div class="text-2xl font-black text-slate-800 dark:text-slate-200">{{ $arrivedCount }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Medical Analytics Chart -->
    <div class="col-span-6 bg-white/60 dark:bg-gray-800 backdrop-blur-2xl border border-white/80 rounded-2xl shadow-lg dark:shadow-none p-4 animate-fade-up dark:backdrop-blur-none" style="animation-delay: 100ms;" x-data="medicalAnalytics()">
        <div class="w-full flex flex-col">
            <!-- Top Controls -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mb-3 animate-fade-up" style="animation-delay: 150ms;">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-teal-50 flex items-center justify-center text-teal-600">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h2 class="text-base font-bold text-slate-800 dark:text-slate-200 tracking-tight">{{ __('المخطط الطبي') }}</h2>
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto bg-slate-50 dark:bg-gray-900 p-1 rounded-xl border border-slate-100 dark:border-gray-700">
                    <!-- Dropdown Filter -->
                    <select x-model="timeFilter" @change="updateChart" class="border-none bg-transparent rounded-lg focus:ring-0 dark:bg-gray-900 dark:text-white text-xs py-1 ltr:pl-2 ltr:pr-6 rtl:pr-2 rtl:pl-6 ltr:text-left rtl:text-right ltr:bg-[position:right_0.25rem_center] rtl:bg-[position:left_0.25rem_center] font-medium text-slate-600 dark:text-slate-400 cursor-pointer w-full sm:w-auto transition-transform active:scale-[0.97]">
                        <option value="today">{{ __('اليوم') }}</option>
                        <option value="week">{{ __('اسبوع') }}</option>
                        <option value="month">{{ __('شهر') }}</option>
                        <option value="year">{{ __('سنة') }}</option>
                        <option value="all">{{ __('الكل') }}</option>
                    </select>

                    <div class="w-px h-5 bg-slate-200 dark:bg-gray-700"></div>

                    <!-- Date Picker -->
                    <div class="relative w-full sm:w-auto">
                        <input type="text" x-model="customDate" x-ref="datePicker" placeholder="{{ __('تاريخ محدد') }}" class="border-none bg-transparent rounded-lg focus:ring-0 dark:bg-gray-900 dark:text-white text-xs py-1 px-2 w-full sm:w-24 text-left font-medium text-slate-600 dark:text-slate-400 cursor-pointer placeholder-slate-400 transition-transform active:scale-[0.97]" dir="ltr">
                    </div>
                </div>
            </div>

            <!-- Chart Container -->
            <div class="flex-1 w-full animate-fade-up" style="animation-delay: 200ms;" x-ref="chartContainer"></div>

            <!-- Bottom Tabs -->
            <div class="flex flex-wrap items-center justify-center gap-1.5 mt-3 pt-2 border-t border-slate-100 dark:border-gray-700 animate-fade-up" style="animation-delay: 250ms;">
                <template x-for="tab in tabs" :key="tab.id">
                    <button
                        @click="activeTab = tab.id; updateChart()"
                        :class="activeTab === tab.id ?'bg-black text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200'"
                        class="px-3 py-1.5 rounded-xl font-bold text-xs transition-all duration-200 active:scale-[0.97]"
                        x-text="tab.name"
                    ></button>
                </template>
            </div>
        </div>
    </div>

    <!-- Financial Stats Card -->
    <div class="col-span-6 bg-white dark:bg-gray-800 rounded-2xl shadow-sm dark:shadow-none p-4">
        <div class="flex w-full flex-col">
            <div class="mb-3 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-slate-100/80 dark:bg-gray-800 text-slate-700 dark:text-slate-300">
                        <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>

                    <div>
                        <h2 class="text-base font-bold text-slate-900 dark:text-slate-100">
                            {{ __('الإحصائيات المالية الشاملة') }}
                        </h2>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <!-- Income -->
                <div class="bg-slate-50 dark:bg-gray-900 p-3 rounded-2xl border border-slate-100 dark:border-gray-700">
                    <div class="text-xs text-slate-500 mb-1 font-medium">{{ __('الدخل العام') }}</div>
                    <div class="text-xl font-black text-slate-800 dark:text-slate-200">{{ number_format($totalIncome ?? 0) }} <span class="text-xs font-normal text-slate-500">{{ __('د.ع') }}</span></div>
                </div>

                <!-- Net Worth -->
                <div class="bg-teal-50 p-3 rounded-2xl border border-teal-100">
                    <div class="text-xs text-teal-600 mb-1 font-medium">{{ __('صافي الثروة') }}</div>
                    <div class="text-xl font-black text-teal-700">{{ number_format($netWorth ?? 0) }} <span class="text-xs font-normal text-teal-500">{{ __('د.ع') }}</span></div>
                </div>

                <!-- Total Expenses -->
                <div class="bg-red-50 p-3 rounded-2xl border border-red-100">
                    <div class="text-xs text-red-600 mb-1 font-medium">{{ __('إجمالي المصاريف') }}</div>
                    <div class="text-xl font-black text-red-700">{{ number_format($totalExpenses ?? 0) }} <span class="text-xs font-normal text-red-500">{{ __('د.ع') }}</span></div>
                </div>

                <!-- Surgery Income -->
                <div class="bg-purple-50 p-3 rounded-2xl border border-purple-100">
                    <div class="text-xs text-purple-600 mb-1 font-medium">{{ __('أموال العمليات') }}</div>
                    <div class="text-xl font-black text-purple-700">{{ number_format($totalSurgeryIncome ?? 0) }} <span class="text-xs font-normal text-purple-500">{{ __('د.ع') }}</span></div>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 pt-3 border-t border-slate-100 dark:border-gray-700">
                <div>
                    <div class="text-xs text-slate-500 mb-1 font-medium">{{ __('متوسط دخل العملية الواحدة') }}</div>
                    <div class="font-bold text-slate-800 dark:text-slate-200 text-base">{{ number_format($avgSurgeryIncome ?? 0) }} <span class="text-xs font-normal text-slate-500">{{ __('د.ع') }}</span></div>
                </div>
                <div>
                    <div class="text-xs text-slate-500 mb-1 font-medium">{{ __('تفصيل المصاريف') }} ({{ __('مدفوعة') }} / {{ __('غير مدفوعة') }})</div>
                    <div class="font-bold text-base flex items-center gap-1.5">
                        <span class="text-emerald-500">{{ number_format($paidExpenses ?? 0) }}</span>
                        <span class="text-slate-400">/</span>
                        <span class="text-rose-500">{{ number_format($unpaidExpenses ?? 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Centered Financial Growth (Redesigned Apple-like) -->
    <div class="col-span-12 bg-white/[0.85] dark:bg-gray-800 backdrop-blur-2xl rounded-[32px] border border-white shadow-[0_12px_40px_-12px_rgba(0,0,0,0.08)] p-8 overflow-hidden relative animate-fade-up dark:backdrop-blur-none" style="animation-delay: 0.15s;" x-data="financialAnalytics()">
        <!-- Decorative Ambient Glows -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-400/10 blur-[80px] rounded-full pointer-events-none -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-teal-400/10 blur-[100px] rounded-full pointer-events-none translate-y-1/3 -translate-x-1/3"></div>

        <div class="flex w-full flex-col gap-8 relative z-10">
            <!-- Top Header & Controls -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <!-- Title Section -->
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-[20px] bg-gradient-to-br dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 from-slate-900 to-slate-800 flex items-center justify-center text-white shadow-lg dark:shadow-none shadow-slate-900/20 border border-slate-700/50 relative overflow-hidden group transition-transform duration-300 hover:scale-105 active:scale-95">
                        <div class="absolute inset-0 bg-white/10 dark:bg-gray-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-out"></div>
                        <svg class="w-7 h-7 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-slate-100" style="font-weight: 600; letter-spacing: -0.02em;">
                            {{ __('مؤشر النمو المالي') }}
                        </h2>
                        <p class="text-sm font-medium text-slate-500 mt-0.5">تحليل الإيرادات والنمو الاقتصادي</p>
                    </div>
                </div>

                <!-- Modern Controls -->
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                    <!-- Dropdown Filter -->
                    <div class="relative w-full sm:w-auto bg-slate-100/80 dark:bg-gray-800 backdrop-blur-md rounded-2xl border border-slate-200/50 shadow-sm dark:shadow-none p-1.5 transition-all duration-300 hover:shadow-md hover:bg-slate-100 dark:backdrop-blur-none">
                        <select x-model="timeFilter" @change="updateChart" class="appearance-none outline-none border-none bg-transparent focus:ring-0 dark:bg-gray-900 dark:text-white text-sm py-2 ltr:pl-4 ltr:pr-10 rtl:pr-4 rtl:pl-10 font-semibold text-slate-700 dark:text-slate-300 cursor-pointer w-full sm:w-auto transition-transform duration-200 active:scale-95">
                            <option value="today">{{ __('اليوم') }}</option>
                            <option value="week">{{ __('اسبوع') }}</option>
                            <option value="month">{{ __('شهر') }}</option>
                            <option value="year">{{ __('سنة') }}</option>
                            <option value="all">{{ __('الكل') }}</option>
                        </select>
                        <!-- Custom Select Arrow -->
                        <div class="absolute top-1/2 -translate-y-1/2 ltr:right-3 rtl:left-3 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                        </div>
                    </div>

                    <!-- Date Picker -->
                    <div class="relative w-full sm:w-auto bg-white dark:bg-gray-800 backdrop-blur-md rounded-2xl border border-slate-200/60 shadow-sm dark:shadow-none transition-all duration-300 hover:shadow-md hover:border-slate-300 dark:backdrop-blur-none">
                        <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center ltr:pl-3 rtl:pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <input type="text" x-model="customDate" x-ref="financeDatePicker" placeholder="{{ __('تاريخ محدد') }}" class="block w-full sm:w-40 outline-none border-none bg-transparent focus:ring-0 dark:bg-gray-900 dark:text-white text-sm py-2.5 ltr:pl-10 ltr:pr-4 rtl:pr-10 rtl:pl-4 font-semibold text-slate-700 dark:text-slate-300 placeholder-slate-400 cursor-pointer transition-transform duration-200 active:scale-[0.98]" dir="ltr">
                    </div>
                </div>
            </div>

            <!-- Chart Container Wrapper -->
            <div class="w-full bg-slate-50/50 dark:bg-gray-900 rounded-2xl border border-slate-100 dark:border-gray-700 p-2 sm:p-4 transition-all duration-500 hover:shadow-[0_8px_30px_rgb(0,0,0,0.03)] hover:bg-slate-50/80">
                <div class="w-full" style="min-height: 220px;" x-ref="financeChartContainer"></div>
            </div>
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
                            height: 200,
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
                            height: 200,
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
