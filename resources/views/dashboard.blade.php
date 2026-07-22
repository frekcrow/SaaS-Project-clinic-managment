<x-app-layout>
    <x-slot name="header">
        لوحة التحكم
    </x-slot>

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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Visits This Month -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 rounded-2xl text-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-slate-500">هذا الشهر</span>
            </div>
            <div>
                <h3 class="text-slate-500 text-sm font-medium mb-1">زيارات هذا الشهر</h3>
                <p class="text-3xl font-bold text-slate-800">124</p>
            </div>
        </div>

        <!-- Card 2: Today's Appointments -->
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
                <p class="text-3xl font-bold text-slate-800">{{ $todaysAppointments->count() ?? 15 }}</p>
            </div>
        </div>

        <!-- Card 3: Total Revenue -->
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
</x-app-layout>