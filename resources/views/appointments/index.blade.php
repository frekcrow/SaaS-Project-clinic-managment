<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center" dir="rtl">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('جدول المواعيد') }}
            </h2>
            <a href="{{ route('appointments.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('إضافة موعد') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">اسم المريض</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">رقم الهاتف</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الطبيب</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ ووقت الموعد</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الوقت المتبقي</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">السعر</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">إجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($appointments as $appointment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->patient_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->phone ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->doctor->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap" dir="ltr" style="text-align: right;">{{ $appointment->appointment_datetime->format('Y-m-d H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap countdown-container" data-datetime="{{ $appointment->appointment_datetime->toIso8601String() }}" data-status="{{ $appointment->status }}">
                                            <span class="countdown-text">جاري الحساب...</span>
                                            <span class="expired-icon hidden text-red-500 font-bold">❌</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->price }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('appointments.update_status', $appointment) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                                    {{ $appointment->status === 'completed' ? 'bg-green-100' : '' }}
                                                    {{ $appointment->status === 'cancelled' ? 'bg-red-100' : '' }}
                                                    {{ $appointment->status === 'pending' ? 'bg-yellow-100' : '' }}
                                                ">
                                                    <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>قيد الانتظار (Pending)</option>
                                                    <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>مكتمل (Completed)</option>
                                                    <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>ملغي (Cancelled)</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2 space-x-reverse flex">
                                            @if($appointment->phone)
                                                <a href="tel:{{ $appointment->phone }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 p-2 rounded-full" title="اتصال">📞</a>
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $appointment->phone) }}" target="_blank" class="text-green-600 hover:text-green-900 bg-green-100 p-2 rounded-full" title="واتساب">💬</a>
                                            @else
                                                <span class="text-gray-400">لا يوجد رقم</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">لا توجد مواعيد حالياً.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateCountdowns() {
                const containers = document.querySelectorAll('.countdown-container');
                const now = new Date().getTime();

                containers.forEach(container => {
                    const datetimeStr = container.getAttribute('data-datetime');
                    const status = container.getAttribute('data-status');
                    const appointmentTime = new Date(datetimeStr).getTime();
                    const distance = appointmentTime - now;

                    const textSpan = container.querySelector('.countdown-text');
                    const iconSpan = container.querySelector('.expired-icon');

                    if (status !== 'pending') {
                        textSpan.textContent = '-';
                        iconSpan.classList.add('hidden');
                        return;
                    }

                    if (distance < 0) {
                        textSpan.classList.add('hidden');
                        iconSpan.classList.remove('hidden');
                    } else {
                        textSpan.classList.remove('hidden');
                        iconSpan.classList.add('hidden');

                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

                        let output = '';
                        if (days > 0) output += days + ' يوم ';
                        if (hours > 0) output += hours + ' س ';
                        output += minutes + ' د ';

                        textSpan.textContent = output;
                    }
                });
            }

            updateCountdowns();
            setInterval(updateCountdowns, 60000); // Update every minute
        });
    </script>
</x-app-layout>
