<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('الحسابات') }} - {{ $clinicName }}
            </h2>
            <div class="text-gray-600">
                د. {{ $doctorName }}
            </div>
        </div>
    </x-slot>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #invoice-modal, #invoice-modal * {
                visibility: visible;
            }
            #invoice-modal {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>

    <div class="py-12" x-data="billingData()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Filters -->
                    <div class="mb-6 flex space-x-2 space-x-reverse">
                        <a href="{{ route('billing.index') }}" class="px-4 py-2 border rounded hover:bg-gray-100 {{ !request('filter') ? 'bg-gray-200' : '' }}">الكل</a>
                        <a href="{{ route('billing.index', ['filter' => 'today']) }}" class="px-4 py-2 border rounded hover:bg-gray-100 {{ request('filter') == 'today' ? 'bg-gray-200' : '' }}">اليوم</a>
                        <a href="{{ route('billing.index', ['filter' => 'week']) }}" class="px-4 py-2 border rounded hover:bg-gray-100 {{ request('filter') == 'week' ? 'bg-gray-200' : '' }}">هذا الأسبوع</a>
                        <a href="{{ route('billing.index', ['filter' => 'month']) }}" class="px-4 py-2 border rounded hover:bg-gray-100 {{ request('filter') == 'month' ? 'bg-gray-200' : '' }}">هذا الشهر</a>
                        <a href="{{ route('billing.index', ['filter' => 'year']) }}" class="px-4 py-2 border rounded hover:bg-gray-100 {{ request('filter') == 'year' ? 'bg-gray-200' : '' }}">هذا العام</a>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-right">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-sm font-medium text-gray-500 uppercase tracking-wider">اسم المريض</th>
                                    <th scope="col" class="px-6 py-3 text-sm font-medium text-gray-500 uppercase tracking-wider">المبلغ المدفوع</th>
                                    <th scope="col" class="px-6 py-3 text-sm font-medium text-gray-500 uppercase tracking-wider">رقم الهاتف</th>
                                    <th scope="col" class="px-6 py-3 text-sm font-medium text-gray-500 uppercase tracking-wider">التاريخ</th>
                                    <th scope="col" class="px-6 py-3 text-sm font-medium text-gray-500 uppercase tracking-wider">الوقت</th>
                                    <th scope="col" class="px-6 py-3 text-sm font-medium text-gray-500 uppercase tracking-wider">إجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($appointments as $appointment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $appointment->patient_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $appointment->price }} ريال</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $appointment->phone ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $appointment->appointment_datetime->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $appointment->appointment_datetime->format('H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button @click="openInvoiceModal({{ $appointment->toJson() }}, {{ $appointment->total_paid }}, @js($clinicName))" class="text-indigo-600 hover:text-indigo-900 p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                @if($appointments->isEmpty())
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">لا يوجد سجلات مطابقة.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!-- Alpine.js Modal for Invoice -->
        <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="isModalOpen" @click="closeInvoiceModal()" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="isModalOpen" id="invoice-modal" class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start flex-col">

                            <!-- Invoice Header -->
                            <div class="w-full text-center mb-6 border-b pb-4">
                                <h3 class="text-2xl font-bold text-gray-900" x-text="clinicName"></h3>
                                <p class="text-sm text-gray-500 mt-1">فاتورة / إيصال استلام</p>
                            </div>

                            <!-- Invoice Details -->
                            <div class="w-full space-y-4">
                                <div class="flex justify-between">
                                    <span class="font-semibold text-gray-700">اسم المريض:</span>
                                    <span class="text-gray-900" x-text="currentAppointment?.patient_name"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-semibold text-gray-700">التاريخ:</span>
                                    <span class="text-gray-900" x-text="currentAppointment ? new Date(currentAppointment.appointment_datetime).toLocaleDateString('en-CA') : ''"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-semibold text-gray-700">الوقت:</span>
                                    <span class="text-gray-900" x-text="currentAppointment ? new Date(currentAppointment.appointment_datetime).toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit', hour12: false}) : ''"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-semibold text-gray-700">السبب:</span>
                                    <span class="text-gray-900">استشارة / جلسة</span>
                                </div>

                                <div class="border-t pt-4 flex justify-between items-center bg-gray-50 p-3 rounded">
                                    <span class="font-bold text-lg text-gray-900">المبلغ المدفوع:</span>
                                    <span class="font-bold text-lg text-gray-900">
                                        <span x-text="showFullHistory ? totalPaid : currentAppointment?.price"></span> ريال
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse no-print justify-between items-center">
                        <div class="flex space-x-2 space-x-reverse">
                            <button type="button" @click="printInvoice()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                طباعة
                            </button>
                            <button type="button" @click="closeInvoiceModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                إغلاق
                            </button>
                        </div>
                        <div class="flex items-center">
                            <label for="toggle-history" class="mr-2 text-sm text-gray-700 cursor-pointer pl-2">إظهار التاريخ المالي الكامل:</label>
                            <input id="toggle-history" type="checkbox" x-model="showFullHistory" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function billingData() {
            return {
                isModalOpen: false,
                currentAppointment: null,
                totalPaid: 0,
                clinicName: '',
                showFullHistory: false,

                openInvoiceModal(appointment, totalPaid, clinicName) {
                    this.currentAppointment = appointment;
                    this.totalPaid = totalPaid;
                    this.clinicName = clinicName;
                    this.showFullHistory = false; // default to current visit only
                    this.isModalOpen = true;
                },

                closeInvoiceModal() {
                    this.isModalOpen = false;
                    this.currentAppointment = null;
                },

                printInvoice() {
                    window.print();
                }
            }
        }
    </script>
</x-app-layout>
