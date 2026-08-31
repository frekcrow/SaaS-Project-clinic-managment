<x-doctor-layout>
    <x-slot name="header">
        {{ __('تقويم المواعيد') }}
    </x-slot>

    <div class="space-y-6">
        <!-- Global Counter -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm dark:shadow-none border border-slate-100 dark:border-gray-700 p-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-teal-50 text-teal-600 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200">{{ __('المراجعين المتبقين اليوم') }}</h2>
                    <p class="text-slate-500 text-sm">{{ __('الذين لم يتم إدخالهم بعد') }}</p>
                </div>
            </div>
            <div class="text-4xl font-black text-teal-600">
                {{ $remainingPatients }}
            </div>
        </div>

        <!-- Controls & Summary -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm dark:shadow-none border border-slate-100 dark:border-gray-700 p-6 space-y-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <!-- Display Modes -->
                <div class="flex gap-2 bg-slate-100 dark:bg-gray-800 p-1 rounded-xl w-full md:w-auto">
                    <a href="{{ route('doctor.appointments.index', ['view_mode' => 'default']) }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors w-1/2 md:w-auto text-center {{ $viewMode ==='default' ? 'bg-white text-teal-600 shadow-sm' : 'text-slate-600 hover:bg-slate-200' }}">
                        {{ __('العرض الافتراضي') }}
                    </a>
                    <a href="{{ route('doctor.appointments.index', ['view_mode' => 'filter', 'date' => $filterDate]) }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors w-1/2 md:w-auto text-center {{ $viewMode ==='filter' ? 'bg-white text-teal-600 shadow-sm' : 'text-slate-600 hover:bg-slate-200' }}">
                        {{ __('حسب التاريخ') }}
                    </a>
                </div>

                <!-- Date Filter -->
                @if($viewMode === 'filter')
                <form method="GET" action="{{ route('doctor.appointments.index') }}" class="flex gap-2 w-full md:w-auto" x-data>
                    <input type="hidden" name="view_mode" value="filter">
                    <input type="date" name="date" value="{{ $filterDate }}" class="border-slate-200 dark:border-gray-700 rounded-xl text-sm focus:ring-teal-500 dark:bg-gray-900 dark:text-white focus:border-teal-500 flex-1" @change="$el.form.submit()">
                </form>
                @endif
            </div>

            <!-- Hourly Summary -->
            @if($hourlySummary->isNotEmpty())
            <div class="pt-4 border-t border-slate-100 dark:border-gray-700">
                <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">{{ __('ملخص مواعيد اليوم بالساعات') }}</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($hourlySummary as $hour => $count)
                    <div class="bg-teal-50 text-teal-700 px-3 py-1.5 rounded-lg text-sm font-medium border border-teal-100 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span dir="ltr">{{ $hour }}</span>
                        <span class="bg-teal-200 text-teal-800 text-xs px-2 py-0.5 rounded-full">{{ $count }} {{ __('مراجعين') }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Appointment Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($appointments as $appointment)
            @php
                $dateTimeString = $appointment->appointment_date->format('Y-m-d') . ' ' . $appointment->appointment_time;
                $targetTimestamp = \Carbon\Carbon::parse($dateTimeString)->timestamp * 1000;
            @endphp
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm dark:shadow-none border border-slate-100 dark:border-gray-700 p-6 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-slate-100 dark:bg-gray-800 rounded-full flex items-center justify-center text-slate-500 text-xl font-bold">
                            {{ mb_substr($appointment->patient_name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 dark:text-slate-200">{{ $appointment->patient->name ?? $appointment->patient_name }}</h3>
                            <p class="text-sm text-slate-500">{{ $appointment->patient->phone ?? $appointment->phone ?? __('لا يوجد رقم') }}</p>
                        </div>
                    </div>
                    <div class="bg-slate-100 dark:bg-gray-800 px-3 py-1 rounded-full text-xs font-semibold text-slate-600 dark:text-slate-400 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y/m/d') }}
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-50">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-slate-500">{{ __('وقت الموعد') }}</span>
                        <span class="text-lg font-bold text-slate-800 dark:text-slate-200" dir="ltr">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</span>
                    </div>

                    <!-- Live Countdown Timer -->
                    <div x-data="countdownTimer({{ $targetTimestamp }})" class="bg-slate-50 dark:bg-gray-900 rounded-xl p-3 flex flex-col items-center justify-center border border-slate-100 dark:border-gray-700">
                        <span class="text-xs text-slate-500 mb-1">{{ __('الوقت المتبقي') }}</span>
                        <div x-show="!isPast" class="text-xl font-mono font-bold text-teal-600" dir="ltr" x-text="timeLeft" x-cloak></div>
                        <div x-show="isPast" class="text-sm font-bold text-red-500" x-cloak>{{ __('تجاوز الوقت المحدد') }}</div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white dark:bg-gray-800 rounded-2xl shadow-sm dark:shadow-none border border-slate-100 dark:border-gray-700 p-12 text-center">
                <div class="w-20 h-20 bg-slate-50 dark:bg-gray-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-700 dark:text-slate-300 mb-1">{{ __('لا توجد مواعيد') }}</h3>
                <p class="text-slate-500">{{ __('لم يتم العثور على مواعيد في هذه الفترة') }}.</p>
            </div>
            @endforelse
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('countdownTimer', (targetTime) => ({
                target: targetTime,
                now: new Date().getTime(),
                interval: null,

                get isPast() {
                    return this.now >= this.target;
                },

                get timeLeft() {
                    if (this.isPast) return '00:00:00';

                    const distance = this.target - this.now;

                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                },

                init() {
                    this.interval = setInterval(() => {
                        this.now = new Date().getTime();
                        if (this.isPast) {
                            clearInterval(this.interval);
                        }
                    }, 1000);
                },

                destroy() {
                    if (this.interval) clearInterval(this.interval);
                }
            }));
        });
    </script>
    @endpush
</x-doctor-layout>
