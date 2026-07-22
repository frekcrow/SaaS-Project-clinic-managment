<x-app-layout>
    <x-slot name="header">
        لوحة التحكم
    </x-slot>

    <!-- Live Consultation Status Card -->
    <div class="mb-8 bg-white rounded-3xl p-6 shadow-sm border border-indigo-100 relative overflow-hidden"
         x-data="{
            timer: 0,
            formattedTime() {
                let m = Math.floor(this.timer / 60).toString().padStart(2, '0');
                let s = (this.timer % 60).toString().padStart(2, '0');
                return m + ':' + s;
            }
         }"
         @if($activeConsultation) x-init="setInterval(() => timer++, 1000)" @endif>
        <div class="flex items-center justify-between relative z-10">
            <div class="flex items-center space-x-4 space-x-reverse">
                <div class="p-4 rounded-2xl {{ $activeConsultation ? 'bg-indigo-100 text-indigo-600 animate-pulse' : 'bg-slate-100 text-slate-400' }}">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">حالة العيادة الآن</h2>
                    @if($activeConsultation)
                        <p class="text-indigo-600 font-medium text-lg mt-1">المريض الحالي: {{ $activeConsultation->patient_name ?? $activeConsultation->patient?->name }}</p>
                    @else
                        <p class="text-slate-500 font-medium text-lg mt-1">لا يوجد مريض في الداخل حالياً</p>
                    @endif
                </div>
            </div>

            @if($activeConsultation)
            <div class="text-center">
                <span class="block text-sm text-slate-500 mb-1">وقت الجلسة</span>
                <span class="text-3xl font-mono font-bold text-indigo-600" x-text="formattedTime()">00:00</span>
            </div>
            @endif
        </div>

        @if($activeConsultation)
        <!-- Decorative pulse background -->
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl opacity-50 animate-pulse"></div>
        @endif
    </div>

    <!-- Quick Action Buttons -->
    <div class="mb-8 flex flex-col sm:flex-row gap-4">
        <a href="{{ route('patients.index') }}" class="flex-1 bg-gradient-to-l from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white shadow-md hover:shadow-lg rounded-2xl p-4 flex items-center justify-center space-x-3 space-x-reverse transition-all transform hover:-translate-y-1">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v6m-3-3h6"></path>
            </svg>
            <span class="text-lg font-semibold">اضافة مريض</span>
        </a>

        <a href="{{ route('appointments.index') }}" class="flex-1 bg-white hover:bg-slate-50 text-indigo-600 border border-indigo-100 shadow-sm hover:shadow-md rounded-2xl p-4 flex items-center justify-center space-x-3 space-x-reverse transition-all transform hover:-translate-y-1">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v6m-3-3h6"></path>
            </svg>
            <span class="text-lg font-semibold">حجز موعد</span>
        </a>
    </div>

    <!-- Statistics Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Card 1: Today's Appointments -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-50 rounded-2xl text-purple-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-slate-500">اليوم</span>
            </div>
            <div>
                <h3 class="text-slate-500 text-sm font-medium mb-1">مواعيد اليوم</h3>
                <p class="text-3xl font-bold text-slate-800">{{ $todaysAppointments->count() }}</p>
            </div>
        </div>

        <!-- Card 2: Patients Pending Surgery -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-rose-50 rounded-2xl text-rose-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-slate-500">الآن</span>
            </div>
            <div>
                <h3 class="text-slate-500 text-sm font-medium mb-1">المرضى بانتظار عمليات</h3>
                <p class="text-3xl font-bold text-slate-800">{{ $pendingSurgeries }}</p>
            </div>
        </div>

        <!-- Card 3: Today's Sessions -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-sky-50 rounded-2xl text-sky-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-slate-500">اليوم</span>
            </div>
            <div>
                <h3 class="text-slate-500 text-sm font-medium mb-1">جلسات اليوم</h3>
                <p class="text-3xl font-bold text-slate-800">{{ $todaySessions }}</p>
            </div>
        </div>

        <!-- Card 4: Total Revenue -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="flex items-center justify-between mb-2">
                <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex items-center space-x-1 space-x-reverse bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full text-xs font-bold">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                    <span>Up 12%</span>
                </div>
            </div>
            <div class="relative z-10">
                <h3 class="text-slate-500 text-sm font-medium mb-1">إجمالي الإيرادات</h3>
                <p class="text-3xl font-bold text-slate-800">4,500 <span class="text-lg text-slate-500 font-normal">د.ك</span></p>
            </div>

            <!-- Mini Insight Diagram (Background Sparkline) -->
            <div class="absolute bottom-0 left-0 right-0 h-16 opacity-30 text-emerald-500 pointer-events-none">
                <svg viewBox="0 0 100 40" preserveAspectRatio="none" class="w-full h-full stroke-current">
                    <path d="M0,40 C20,35 30,10 50,20 C70,30 80,5 100,10" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <!-- subtle gradient fill under the line -->
                    <path d="M0,40 C20,35 30,10 50,20 C70,30 80,5 100,10 L100,40 L0,40 Z" fill="currentColor" class="opacity-20" stroke="none" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Mini Appointments Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-800">مواعيد اليوم</h2>
            <a href="{{ route('appointments.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">عرض الكل</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-sm">
                        <th class="py-3 px-6 font-medium">اسم المريض</th>
                        <th class="py-3 px-6 font-medium">الوقت</th>
                        <th class="py-3 px-6 font-medium">الحالة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($todaysAppointments as $appointment)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="py-4 px-6 text-slate-800 font-medium group-hover:text-indigo-600 transition-colors">
                                {{ $appointment->patient_name ?? ($appointment->patient ? $appointment->patient->name : 'غير محدد') }}
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                <div class="flex items-center space-x-2 space-x-reverse">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $appointment->appointment_datetime ? $appointment->appointment_datetime->format('h:i A') : 'غير محدد' }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if($appointment->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        مكتمل
                                    </span>
                                @elseif($appointment->status === 'cancelled')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        ملغي
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        قادم
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-8 px-6 text-center text-slate-500">
                                لا توجد مواعيد اليوم.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Alpine JS Omnichannel component -->
    <div x-data="{ callsModal: false, messagesModal: false }">
        <!-- Floating Omnichannel Bottom Bar -->
        <div class="fixed bottom-6 left-1/2 -translate-x-1/2 z-40 bg-white/70 backdrop-blur-xl border border-white/60 shadow-lg rounded-full px-6 py-3 flex items-center space-x-6 space-x-reverse transition-transform">

            <button @click="callsModal = true" class="text-slate-600 hover:text-indigo-600 transition-colors relative group">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                </span>
            </button>

            <div class="w-px h-6 bg-slate-200"></div>

            <button @click="messagesModal = true" class="text-slate-600 hover:text-indigo-600 transition-colors relative group">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
            </button>

            <div class="w-px h-6 bg-slate-200"></div>

            <a href="{{ route('settings.index') }}" class="text-slate-600 hover:text-indigo-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </a>
        </div>

        <!-- Calls Slide-over Modal -->
        <div x-show="callsModal"
             style="display: none;"
             class="fixed inset-0 z-50 overflow-hidden"
             aria-labelledby="slide-over-title"
             role="dialog"
             aria-modal="true">
            <div class="absolute inset-0 overflow-hidden">
                <div x-show="callsModal"
                     x-transition:enter="ease-in-out duration-500"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in-out duration-500"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"
                     @click="callsModal = false"></div>

                <div class="pointer-events-none fixed inset-y-0 left-0 flex max-w-full pr-10">
                    <div x-show="callsModal"
                         x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                         x-transition:enter-start="-translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="-translate-x-full"
                         class="pointer-events-auto w-screen max-w-md">
                        <div class="flex h-full flex-col overflow-y-scroll bg-white py-6 shadow-xl rounded-r-3xl border-r border-slate-100">
                            <div class="px-4 sm:px-6 flex items-center justify-between">
                                <h2 class="text-lg font-bold text-slate-900" id="slide-over-title">المكالمات الواردة</h2>
                                <button type="button" @click="callsModal = false" class="rounded-md bg-white text-slate-400 hover:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <span class="sr-only">Close panel</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="relative mt-6 flex-1 px-4 sm:px-6">
                                <ul class="space-y-4">
                                    @forelse($recentCalls as $call)
                                        <li class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                            <!-- Example of real data rendering -->
                                            <div class="flex items-center justify-between">
                                                <p class="font-medium text-slate-800">{{ $call->caller_name }}</p>
                                                <span class="text-xs text-slate-500">{{ $call->created_at->diffForHumans() }}</span>
                                            </div>
                                        </li>
                                    @empty
                                        <div class="flex flex-col items-center justify-center h-full text-center space-y-4 text-slate-500">
                                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            <p class="text-lg font-medium">لا توجد مكالمات واردة</p>
                                        </div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Slide-over Modal -->
        <div x-show="messagesModal"
             style="display: none;"
             class="fixed inset-0 z-50 overflow-hidden"
             aria-labelledby="slide-over-title"
             role="dialog"
             aria-modal="true">
            <div class="absolute inset-0 overflow-hidden">
                <div x-show="messagesModal"
                     x-transition:enter="ease-in-out duration-500"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in-out duration-500"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"
                     @click="messagesModal = false"></div>

                <div class="pointer-events-none fixed inset-y-0 left-0 flex max-w-full pr-10">
                    <div x-show="messagesModal"
                         x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                         x-transition:enter-start="-translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="-translate-x-full"
                         class="pointer-events-auto w-screen max-w-md">
                        <div class="flex h-full flex-col overflow-y-scroll bg-white py-6 shadow-xl rounded-r-3xl border-r border-slate-100">
                            <div class="px-4 sm:px-6 flex items-center justify-between">
                                <h2 class="text-lg font-bold text-slate-900" id="slide-over-title">الرسائل</h2>
                                <button type="button" @click="messagesModal = false" class="rounded-md bg-white text-slate-400 hover:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <span class="sr-only">Close panel</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="relative mt-6 flex-1 px-4 sm:px-6">
                                <ul class="space-y-4">
                                    @forelse($recentMessages as $message)
                                        <li class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                                            <!-- Example of real data rendering -->
                                            <p class="font-medium text-slate-800">{{ $message->sender }}</p>
                                        </li>
                                    @empty
                                        <div class="flex flex-col items-center justify-center h-full text-center space-y-4 text-slate-500">
                                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                            </svg>
                                            <p class="text-lg font-medium">لا توجد رسائل جديدة</p>
                                        </div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>