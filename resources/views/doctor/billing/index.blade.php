<x-doctor-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-slate-800 leading-tight">
                {{ __('الحسابات والفوترة') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Top Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Patients Today -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col justify-between relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-teal-50 to-transparent rounded-bl-full -z-10 transition-transform duration-300 group-hover:scale-110"></div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-slate-800 mb-1 tracking-tight" dir="ltr">
                            {{ $totalPatientsToday }}
                        </h3>
                        <p class="text-sm font-medium text-slate-500">إجمالي مرضى اليوم</p>
                    </div>
                </div>

                <!-- Today's Income -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col justify-between relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-50 to-transparent rounded-bl-full -z-10 transition-transform duration-300 group-hover:scale-110"></div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-slate-800 mb-1 tracking-tight" dir="ltr">
                            {{ number_format($todayIncome, 0) }} <span class="text-lg font-medium text-slate-400">د.ع</span>
                        </h3>
                        <p class="text-sm font-medium text-slate-500">دخل اليوم (الجلسات)</p>
                    </div>
                </div>

                <!-- Total Surgeries Income -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col justify-between relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-50 to-transparent rounded-bl-full -z-10 transition-transform duration-300 group-hover:scale-110"></div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-slate-800 mb-1 tracking-tight" dir="ltr">
                            {{ number_format($totalSurgeriesIncome, 0) }} <span class="text-lg font-medium text-slate-400">د.ع</span>
                        </h3>
                        <p class="text-sm font-medium text-slate-500">إجمالي دخل العمليات</p>
                    </div>
                </div>

                <!-- Net Worth -->
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-6 border border-slate-700 shadow-lg flex flex-col justify-between relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-full -z-0 transition-transform duration-500 group-hover:scale-110"></div>
                    <div class="flex justify-between items-start mb-4 relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 text-emerald-400 flex items-center justify-center backdrop-blur-sm border border-white/10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-3xl font-black text-white mb-1 tracking-tight" dir="ltr">
                            {{ number_format($netWorth, 0) }} <span class="text-lg font-medium text-slate-400">د.ع</span>
                        </h3>
                        <p class="text-sm font-medium text-slate-400">إجمالي الدخل (الصافي)</p>
                    </div>
                </div>
            </div>

            <!-- Top Paying Patients Table -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">المرضى الأكثر دفعاً</h3>
                        <p class="text-sm text-gray-500 mt-1">قائمة بالمرضى مرتبة حسب إجمالي المبالغ المدفوعة.</p>
                    </div>
                    <div>
                        <form method="GET" action="{{ route('doctor.billing.index') }}" x-data="{ sort: '{{ $sortOrder }}' }" class="flex items-center gap-2">
                            <label for="sort" class="text-sm font-medium text-slate-700">ترتيب حسب:</label>
                            <select name="sort" id="sort" x-model="sort" @change="$event.target.form.submit()" class="border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 text-sm pl-8 pr-4 py-2 bg-white shadow-sm cursor-pointer">
                                <option value="desc">الأعلى دخلاً</option>
                                <option value="asc">الأدنى دخلاً</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-right border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-gray-100">
                                <th class="py-4 px-6 text-sm font-bold text-slate-600 w-16">#</th>
                                <th class="py-4 px-6 text-sm font-bold text-slate-600">اسم المريض</th>
                                <th class="py-4 px-6 text-sm font-bold text-slate-600">رقم الهاتف</th>
                                <th class="py-4 px-6 text-sm font-bold text-slate-600 text-left">إجمالي المدفوعات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($patientsData as $index => $patient)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="py-4 px-6 text-sm font-medium text-slate-400">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center font-bold text-lg">
                                                {{ mb_substr($patient->name, 0, 1) }}
                                            </div>
                                            <span class="font-bold text-slate-800">{{ $patient->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-slate-600" dir="ltr">
                                        {{ $patient->phone ?: '-' }}
                                    </td>
                                    <td class="py-4 px-6 text-left">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 font-bold text-sm">
                                            <span dir="ltr">{{ number_format($patient->total_paid, 0) }}</span>
                                            <span>د.ع</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 px-6 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4M8 16l-4-4 4-4M16 8l4 4-4 4"></path></svg>
                                            <span class="font-medium text-lg text-slate-600">لا توجد بيانات مالية</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-doctor-layout>
