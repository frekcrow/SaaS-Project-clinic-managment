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

    <div class="py-12" x-data="billingData(@js($appointments), @js($clinicName))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Top Action Bar -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 space-y-4 sm:space-y-0 sm:space-x-4 sm:space-x-reverse">
                <div class="flex flex-1 w-full max-w-md items-center space-x-2 space-x-reverse">
                    <input type="text" x-model="search" placeholder="{{ __('ابحث في السجلات...') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <select x-model="filter" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="all">{{ __('الكل') }}</option>
                        <option value="today">{{ __('اليوم') }}</option>
                        <option value="week">{{ __('هذا الأسبوع') }}</option>
                        <option value="month">{{ __('هذا الشهر') }}</option>
                        <option value="year">{{ __('هذا العام') }}</option>
                    </select>
                </div>

                <div class="flex items-center space-x-2 space-x-reverse">
                    <a href="{{ route('appointments.create') }}" class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-neutral-800 transition-colors focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 disabled:opacity-25 duration-150">
                        {{ __('اضافة +') }}
                    </a>
                    <a href="{{ route('billing.export_csv') }}" class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-neutral-800 transition-colors focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 disabled:opacity-25 duration-150">
                        {{ __('تصدير CSV') }}
                    </a>
                    <button @click="editMode = !editMode" :class="editMode ? 'bg-neutral-800 text-white' : 'bg-black text-white'" class="inline-flex items-center px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm transition-colors hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 disabled:opacity-25 duration-150">
                        {{ __('تعديل') }}
                    </button>
                </div>
            </div>

            <!-- Bulk Actions -->
            <div x-show="editMode && selected.length > 0" x-cloak class="mb-4">
                <button @click="deleteSelected" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('حذف المحدد') }} (<span x-text="selected.length"></span>)
                </button>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-[1.5px] border-black/20">
                <div class="p-0 text-gray-900">
                    <template x-if="filteredAppointments.length === 0">
                        <div class="p-6 text-center text-gray-500">{{ __('لا توجد سجلات مطابقة.') }}</div>
                    </template>

                    <template x-if="filteredAppointments.length > 0">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th x-show="editMode" scope="col" class="w-12 px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l">
                                            <input type="checkbox" @click="toggleSelectAll" :checked="allSelected" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">
                                            {{ __('اسم المريض') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">
                                            {{ __('المبلغ المدفوع') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">
                                            {{ __('رقم الهاتف') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">
                                            {{ __('التاريخ') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">
                                            {{ __('الوقت') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 whitespace-nowrap w-auto">
                                            {{ __('الإجراءات') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <template x-for="appointment in filteredAppointments" :key="appointment.id">
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td x-show="editMode" class="px-4 py-3 whitespace-nowrap border-b border-gray-200 border-l text-center">
                                                <input type="checkbox" x-model="selected" :value="appointment.id" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-b border-gray-200 border-l">
                                                <span x-text="appointment.patient?.name || appointment.patient_name || '-'"></span>
                                            </td>
                                            <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-900 border-b border-gray-200 border-l h-full">
                                                <template x-if="!editMode">
                                                    <div class="px-6 py-4">
                                                        <span x-text="appointment.price || '0'"></span> ريال
                                                    </div>
                                                </template>
                                                <template x-if="editMode">
                                                    <input type="number" x-model="appointment.price" @blur="saveAppointment(appointment)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0" step="0.01">
                                                </template>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l">
                                                <span x-text="appointment.patient?.phone || appointment.phone || '-'"></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l">
                                                <span x-text="appointment.appointment_datetime.substring(0, 10)"></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l">
                                                <span x-text="appointment.appointment_datetime.substring(11, 16)"></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium border-b border-gray-200">
                                                <button @click="openInvoiceModal(appointment, appointment.total_paid, clinicName)" class="text-indigo-600 hover:text-indigo-900 p-2 bg-indigo-50 hover:bg-indigo-100 rounded transition-colors border border-indigo-200">
                                                    {{ __('عرض الفاتورة') }}
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </template>
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
                                    <span class="text-gray-900" x-text="currentAppointment?.patient?.name || currentAppointment?.patient_name"></span>
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

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('billingData', (initialAppointments, initialClinicName) => ({
                appointments: initialAppointments,
                clinicName: initialClinicName,
                search: '',
                filter: 'all',
                editMode: false,
                selected: [],

                isModalOpen: false,
                currentAppointment: null,
                totalPaid: 0,
                showFullHistory: false,

                get filteredAppointments() {
                    let filtered = this.appointments;

                    if (this.search) {
                        const q = this.search.toLowerCase();
                        filtered = filtered.filter(a => {
                            const name = a.patient?.name || a.patient_name || '';
                            const phone = a.patient?.phone || a.phone || '';
                            return name.toLowerCase().includes(q) || phone.toLowerCase().includes(q);
                        });
                    }

                    const now = new Date();
                    if (this.filter !== 'all') {
                        filtered = filtered.filter(a => {
                            const apptDate = new Date(a.appointment_datetime);
                            if (this.filter === 'today') {
                                return apptDate.toDateString() === now.toDateString();
                            } else if (this.filter === 'week') {
                                const startOfWeek = new Date(now);
                                startOfWeek.setDate(now.getDate() - now.getDay());
                                const endOfWeek = new Date(startOfWeek);
                                endOfWeek.setDate(startOfWeek.getDate() + 6);
                                return apptDate >= startOfWeek && apptDate <= endOfWeek;
                            } else if (this.filter === 'month') {
                                return apptDate.getMonth() === now.getMonth() && apptDate.getFullYear() === now.getFullYear();
                            } else if (this.filter === 'year') {
                                return apptDate.getFullYear() === now.getFullYear();
                            }
                            return true;
                        });
                    }

                    return filtered;
                },

                get allSelected() {
                    return this.filteredAppointments.length > 0 && this.selected.length === this.filteredAppointments.length;
                },

                toggleSelectAll() {
                    if (this.allSelected) {
                        this.selected = [];
                    } else {
                        this.selected = this.filteredAppointments.map(a => a.id);
                    }
                },

                async deleteSelected() {
                    if (!confirm('{{ __('هل أنت متأكد من حذف السجلات المحددة؟') }}')) return;

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                        const response = await fetch('{{ route('billing.bulk_delete') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                ids: this.selected
                            })
                        });

                        if (response.ok) {
                            this.appointments = this.appointments.filter(a => !this.selected.includes(String(a.id)) && !this.selected.includes(a.id));
                            this.selected = [];
                        } else {
                            console.error('Failed to delete billing records', await response.text());
                        }
                    } catch (error) {
                        console.error('Error deleting billing records:', error);
                    }
                },

                async saveAppointment(appointment) {
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                        const response = await fetch(`/appointments/${appointment.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                price: appointment.price
                            })
                        });

                        if (!response.ok) {
                            console.error('Failed to save appointment price', await response.text());
                        }
                    } catch (error) {
                        console.error('Error saving appointment price:', error);
                    }
                },

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
            }));
        });
    </script>
    @endpush
</x-app-layout>
