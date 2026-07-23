<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center" dir="rtl">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('جدول المواعيد') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl" x-data="appointmentsGrid(@js($appointments))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Top Action Bar -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 space-y-4 sm:space-y-0 sm:space-x-4 sm:space-x-reverse">
                <div class="flex flex-1 w-full max-w-md items-center space-x-2 space-x-reverse">
                    <input type="text" x-model="search" placeholder="{{ __('ابحث عن موعد (اسم المريض أو رقم الهاتف)...') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <select x-model="sortBy" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="date_asc">{{ __('تاريخ الموعد (الأقرب)') }}</option>
                        <option value="date_desc">{{ __('تاريخ الموعد (الأبعد)') }}</option>
                        <option value="newest">{{ __('تاريخ الإضافة (الأحدث)') }}</option>
                        <option value="oldest">{{ __('تاريخ الإضافة (الأقدم)') }}</option>
                        <option value="status_pending">{{ __('قيد الانتظار') }}</option>
                        <option value="status_completed">{{ __('مكتمل') }}</option>
                        <option value="status_cancelled">{{ __('ملغي') }}</option>
                    </select>
                </div>

                <div class="flex items-center space-x-2 space-x-reverse">
                    <a href="{{ route('appointments.create') }}" class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-neutral-800 transition-colors focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 disabled:opacity-25 duration-150">
                        {{ __('اضافة +') }}
                    </a>
                    <a href="{{ route('appointments.export_csv') }}" class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-neutral-800 transition-colors focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 disabled:opacity-25 duration-150">
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
                        <div class="p-6 text-center text-gray-500">{{ __('لا توجد مواعيد') }}</div>
                    </template>

                    <template x-if="filteredAppointments.length > 0">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border-0">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-200">
                                        <th x-show="editMode" scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-12 text-center">
                                            <input type="checkbox" @click="toggleSelectAll" :checked="allSelected" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">اسم المريض</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">رقم الهاتف</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">الطبيب</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">تاريخ ووقت الموعد</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">الوقت المتبقي</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">السعر</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">الحالة</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 whitespace-nowrap w-auto">إجراءات</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <template x-for="appointment in filteredAppointments" :key="appointment.id">
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td x-show="editMode" class="px-4 py-3 whitespace-nowrap border-b border-gray-200 border-l text-center">
                                                <input type="checkbox" x-model="selected" :value="appointment.id" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            </td>

                                            <td class="px-0 py-0 whitespace-nowrap text-sm font-medium text-gray-900 border-b border-gray-200 border-l h-full">
                                                <div class="px-6 py-4" x-text="(appointment.patient ? appointment.patient.name : appointment.patient_name) || '-'"></div>
                                            </td>

                                            <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                <div class="px-6 py-4" x-text="(appointment.patient ? appointment.patient.phone : appointment.phone) || '-'"></div>
                                            </td>

                                            <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                <div class="px-6 py-4" x-text="appointment.doctor ? appointment.doctor.name : '-'"></div>
                                            </td>

                                            <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                <template x-if="!editMode">
                                                    <div class="px-6 py-4 text-left" dir="ltr" x-text="appointment.appointment_datetime_formatted"></div>
                                                </template>
                                                <template x-if="editMode">
                                                    <input type="datetime-local" x-model="appointment.appointment_datetime_formatted" @blur="saveAppointment(appointment)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0 text-sm text-left" dir="ltr">
                                                </template>
                                            </td>

                                            <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                <div class="px-6 py-4" x-html="renderCountdown(appointment)"></div>
                                            </td>

                                            <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                <template x-if="!editMode">
                                                    <div class="px-6 py-4" x-text="appointment.price || '-'"></div>
                                                </template>
                                                <template x-if="editMode">
                                                    <input type="number" step="0.01" x-model="appointment.price" @blur="saveAppointment(appointment)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0" placeholder="-">
                                                </template>
                                            </td>

                                            <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                <template x-if="!editMode">
                                                    <div class="px-6 py-4 flex items-center justify-center">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                            :class="{
                                                                'bg-green-100 text-green-800': appointment.status === 'completed',
                                                                'bg-red-100 text-red-800': appointment.status === 'cancelled',
                                                                'bg-yellow-100 text-yellow-800': appointment.status === 'pending'
                                                            }"
                                                            x-text="appointment.status === 'pending' ? 'قيد الانتظار' : (appointment.status === 'completed' ? 'مكتمل' : 'ملغي')">
                                                        </span>
                                                    </div>
                                                </template>
                                                <template x-if="editMode">
                                                    <select x-model="appointment.status" @change="saveAppointment(appointment)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0 text-sm">
                                                        <option value="pending">قيد الانتظار</option>
                                                        <option value="completed">مكتمل</option>
                                                        <option value="cancelled">ملغي</option>
                                                    </select>
                                                </template>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium border-b border-gray-200">
                                                <div class="flex space-x-2 space-x-reverse justify-center">
                                                    <template x-if="(appointment.patient ? appointment.patient.phone : appointment.phone)">
                                                        <div class="flex space-x-2 space-x-reverse">
                                                            <a :href="'tel:' + (appointment.patient ? appointment.patient.phone : appointment.phone)" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 p-2 rounded-full" title="اتصال">📞</a>
                                                            <a :href="'https://wa.me/' + ((appointment.patient ? appointment.patient.phone : appointment.phone) || '').replace(/[^0-9]/g, '')" target="_blank" class="text-green-600 hover:text-green-900 bg-green-100 p-2 rounded-full" title="واتساب">💬</a>
                                                        </div>
                                                    </template>
                                                    <template x-if="!(appointment.patient ? appointment.patient.phone : appointment.phone)">
                                                        <span class="text-gray-400 text-xs">لا يوجد رقم</span>
                                                    </template>
                                                </div>
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
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('appointmentsGrid', (initialAppointments) => ({
                appointments: initialAppointments.map(a => {
                    // Format datetime for datetime-local input (YYYY-MM-DDThh:mm)
                    let formattedDt = '';
                    if (a.appointment_datetime) {
                        const dt = new Date(a.appointment_datetime);
                        // Convert to local time string that datetime-local expects
                        const tzOffset = dt.getTimezoneOffset() * 60000;
                        formattedDt = (new Date(dt - tzOffset)).toISOString().slice(0, 16);
                    }

                    return {
                        ...a,
                        appointment_datetime_formatted: formattedDt
                    };
                }),
                search: '',
                sortBy: 'date_asc',
                editMode: false,
                selected: [],
                now: new Date().getTime(),

                init() {
                    setInterval(() => {
                        this.now = new Date().getTime();
                    }, 60000);
                },

                get filteredAppointments() {
                    let filtered = this.appointments;

                    if (this.search) {
                        const q = this.search.toLowerCase();
                        filtered = filtered.filter(a => {
                            const pName = (a.patient ? a.patient.name : a.patient_name) || '';
                            const pPhone = (a.patient ? a.patient.phone : a.phone) || '';
                            return pName.toLowerCase().includes(q) || pPhone.toLowerCase().includes(q);
                        });
                    }

                    return filtered.sort((a, b) => {
                        const dtA = new Date(a.appointment_datetime || 0);
                        const dtB = new Date(b.appointment_datetime || 0);
                        const caA = new Date(a.created_at || 0);
                        const caB = new Date(b.created_at || 0);

                        if (this.sortBy === 'date_asc') return dtA - dtB;
                        if (this.sortBy === 'date_desc') return dtB - dtA;
                        if (this.sortBy === 'newest') return caB - caA;
                        if (this.sortBy === 'oldest') return caA - caB;
                        if (this.sortBy === 'status_pending') return (a.status === 'pending' ? -1 : 1) - (b.status === 'pending' ? -1 : 1);
                        if (this.sortBy === 'status_completed') return (a.status === 'completed' ? -1 : 1) - (b.status === 'completed' ? -1 : 1);
                        if (this.sortBy === 'status_cancelled') return (a.status === 'cancelled' ? -1 : 1) - (b.status === 'cancelled' ? -1 : 1);

                        return 0;
                    });
                },

                get allSelected() {
                    return this.filteredAppointments.length > 0 && this.selected.length === this.filteredAppointments.length;
                },

                toggleSelectAll() {
                    if (this.allSelected) {
                        this.selected = [];
                    } else {
                        this.selected = this.filteredAppointments.map(a => String(a.id));
                    }
                },

                async saveAppointment(appointment) {
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                        // Parse back to ISO for backend if changed
                        let dtToSave = appointment.appointment_datetime_formatted;
                        if (dtToSave) {
                           dtToSave = dtToSave.replace('T', ' ') + ':00';
                           appointment.appointment_datetime = dtToSave; // update internal state
                        }

                        const response = await fetch(`/appointments/${appointment.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                appointment_datetime: dtToSave,
                                price: appointment.price || null,
                                status: appointment.status
                            })
                        });

                        if (!response.ok) {
                            console.error('Failed to save appointment', await response.text());
                        }
                    } catch (error) {
                        console.error('Error saving appointment:', error);
                    }
                },

                async deleteSelected() {
                    if (!confirm('{{ __('هل أنت متأكد من حذف المواعيد المحددة؟') }}')) return;

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                        const response = await fetch('{{ route('appointments.bulk_delete') }}', {
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
                            console.error('Failed to delete appointments', await response.text());
                        }
                    } catch (error) {
                        console.error('Error deleting appointments:', error);
                    }
                },

                renderCountdown(appointment) {
                    if (appointment.status !== 'pending') {
                        return '-';
                    }

                    if (!appointment.appointment_datetime) {
                        return '-';
                    }

                    // Use the string directly from the original data if available to avoid timezone shift issues during calc
                    // Or use the formatted one. For countdown, the original raw datetime is best.
                    const appointmentTime = new Date(appointment.appointment_datetime).getTime();
                    const distance = appointmentTime - this.now;

                    if (distance < 0) {
                        return '<span class="text-red-500 font-bold">❌</span>';
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

                    let output = '';
                    if (days > 0) output += days + ' يوم ';
                    if (hours > 0) output += hours + ' س ';
                    output += minutes + ' د ';

                    return output;
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>
