<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center" >
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('جدول المواعيد') }}
            </h2>
        </div>
    </x-slot>

    @php
        $appointmentsArray = clone $appointments;
        $appointmentsArray->transform(function($appt) {
            $appt->appointment_date_grouped = $appt->appointment_date ? \Carbon\Carbon::parse($appt->appointment_date)->format('Y-m-d') : '';
            return $appt;
        });
        $groupedRecords = collect($appointmentsArray)->sortByDesc('appointment_date_grouped')->groupBy('appointment_date_grouped');
    @endphp

    <div class="py-12"  x-data="appointmentsGrid(@js($appointmentsArray))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Top Action Bar -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 space-y-4 sm:space-y-0 sm:space-x-4 sm:rtl:space-x-reverse">

                <!-- View Mode Toggle -->
                <div class="inline-flex rounded-md shadow-sm" role="group">
                    <button type="button" @click="viewMode = 'default'" :class="viewMode === 'default' ? 'bg-black text-white' : 'bg-white text-gray-700 hover:bg-gray-50'" class="px-4 py-2 text-sm font-medium border border-gray-200 rounded-s-lg focus:z-10 focus:ring-2 focus:ring-black focus:text-black transition-colors">
                        <svg class="w-4 h-4 inline-block mr-1 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        {{ __('العرض الافتراضي') }}
                    </button>
                    <button type="button" @click="viewMode = 'grouped'" :class="viewMode === 'grouped' ? 'bg-black text-white' : 'bg-white text-gray-700 hover:bg-gray-50'" class="px-4 py-2 text-sm font-medium border border-gray-200 rounded-e-lg focus:z-10 focus:ring-2 focus:ring-black focus:text-black transition-colors">
                        <svg class="w-4 h-4 inline-block mr-1 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ __('عرض حسب التاريخ') }}
                    </button>
                </div>
                <div class="flex flex-1 w-full max-w-md items-center space-x-2 rtl:space-x-reverse">
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

                <div class="flex items-center space-x-2 rtl:space-x-reverse">
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


            <div x-show="viewMode === 'default'">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-[1.5px] border-black/20">
                    <div class="p-0 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border-0">
                            <thead>
                                    <tr class="bg-gray-50 border-b border-gray-200">
                                        <th x-show="editMode" scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-12 text-center">
                                            <input type="checkbox" @click="toggleSelectAll" :checked="allSelected" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('اسم المريض') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('رقم الهاتف') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('رقم الحجز') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('نوع الحجز') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('الطبيب') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('تاريخ الموعد') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('وقت الموعد') }}</th>
                                        @if(auth()->user()->role === 'doctor')
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('السعر') }}</th>
                                        @endif
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('الحالة') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 whitespace-nowrap w-auto">{{ __('إجراءات') }}</th>
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

                                            <td class="px-0 py-0 whitespace-nowrap text-sm font-bold text-gray-900 border-b border-gray-200 border-l h-full text-center bg-gray-50">
                                                <div class="px-6 py-4" x-text="appointment.queue_number || '-'"></div>
                                            </td>

                                            <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                <template x-if="!editMode">
                                                    <div class="px-6 py-4">
                                                        <template x-if="appointment.is_session">
                                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                                                {{ __('جلسة') }} <span x-show="appointment.session_type" x-text="' - ' + (appointment.session_type ? appointment.session_type.name : '')"></span>
                                                            </span>
                                                        </template>
                                                        <template x-if="!appointment.is_session">
                                                            <span class="text-gray-400">-</span>
                                                        </template>
                                                    </div>
                                                </template>
                                                <template x-if="editMode">
                                                    <div class="px-4 py-2 flex flex-col gap-2">
                                                        <label class="inline-flex items-center">
                                                            <input type="checkbox" x-model="appointment.is_session" @change="saveAppointment(appointment)" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                            <span class="ml-2 mr-2 text-xs text-gray-600">{{ __('جلسة؟') }}</span>
                                                        </label>
                                                        <select x-show="appointment.is_session" x-model="appointment.session_type_id" @change="saveAppointment(appointment)" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-xs py-1">
                                                            <option value="">{{ __('اختر النوع') }}</option>
                                                            @foreach($sessionTypes as $type)
                                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </template>
                                            </td>

                                            <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                <div class="px-6 py-4" x-text="appointment.doctor ? appointment.doctor.name : '-'"></div>
                                            </td>

                                            <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                <template x-if="!editMode">
                                                    <div class="px-6 py-4 text-left" dir="ltr" x-text="appointment.appointment_date_formatted"></div>
                                                </template>
                                                <template x-if="editMode">
                                                    <input type="date" x-model="appointment.appointment_date_formatted" @blur="saveAppointment(appointment)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0 text-sm text-left" dir="ltr">
                                                </template>
                                            </td>

                                            <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                <template x-if="!editMode">
                                                    <div class="px-6 py-4 text-left" dir="ltr" x-text="appointment.appointment_time_display"></div>
                                                </template>
                                                <template x-if="editMode">
                                                    <input type="time" x-model="appointment.appointment_time_formatted" @blur="saveAppointment(appointment)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0 text-sm text-left" dir="ltr">
                                                </template>
                                            </td>

                                            @if(auth()->user()->role === 'doctor')
                                            <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                <template x-if="!editMode">
                                                    <div class="px-6 py-4" x-text="appointment.price || '-'"></div>
                                                </template>
                                                <template x-if="editMode">
                                                    <input type="number" step="0.01" x-model="appointment.price" @blur="saveAppointment(appointment)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0" placeholder="-">
                                                </template>
                                            </td>
                                            @endif

                                            <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                <template x-if="!editMode">
                                                    <div class="px-6 py-4 flex items-center justify-center h-full">
                                                        <template x-if="appointment.status !== 'pending'">
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm border"
                                                                :class="{
                                                                    'bg-green-50 text-green-700 border-green-200': appointment.status === 'completed',
                                                                    'bg-red-50 text-red-700 border-red-200': appointment.status === 'cancelled'
                                                                }"
                                                                x-text="appointment.status === 'completed' ? '{{ __('مكتمل') }}' : '{{ __('ملغي') }}'">
                                                            </span>
                                                        </template>
                                                        <template x-if="appointment.status === 'pending'">
                                                            <div class="flex gap-2">
                                                                <button type="button" @click="quickUpdateStatus(appointment, 'completed')" class="inline-flex items-center px-2 py-1 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm" title="{{ __('مكتمل') }}">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                </button>
                                                                <button type="button" @click="quickUpdateStatus(appointment, 'cancelled')" class="inline-flex items-center px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm" title="{{ __('إلغاء') }}">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                </button>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </template>
                                                <template x-if="editMode">
                                                    <select x-model="appointment.status" @change="saveAppointment(appointment)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0 text-sm">
                                                        <option value="pending">{{ __('قيد الانتظار') }}</option>
                                                        <option value="completed">{{ __('مكتمل') }}</option>
                                                        <option value="cancelled">{{ __('ملغي') }}</option>
                                                    </select>
                                                </template>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium border-b border-gray-200">
                                                <div class="flex space-x-2 rtl:space-x-reverse justify-center">
                                                    <template x-if="(appointment.patient ? appointment.patient.phone : appointment.phone)">
                                                        <div class="flex space-x-2 rtl:space-x-reverse">
                                                            <a :href="'tel:' + (appointment.patient ? appointment.patient.phone : appointment.phone)" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded transition-colors border border-indigo-200" title="{{ __('اتصال') }}">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                            </a>
                                                            <a :href="'https://wa.me/' + ((appointment.patient ? appointment.patient.phone : appointment.phone) || '').replace(/[^0-9]/g, '')" target="_blank" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 p-2 rounded transition-colors border border-emerald-200" title="{{ __('واتساب') }}">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                                            </a>
                                                        </div>
                                                    </template>
                                                    <template x-if="!(appointment.patient ? appointment.patient.phone : appointment.phone)">
                                                        <span class="text-gray-400 text-xs">{{ __('لا يوجد رقم') }}</span>
                                                    </template>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <template x-if="filteredAppointments.length === 0">
                                        <tr>
                                            <td colspan="10" class="p-6 text-center text-gray-500">{{ __('لا توجد بيانات') }}</td>
                                        </tr>
                                    </template>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>

            <div x-show="viewMode === 'grouped'" x-cloak>
                @if($groupedRecords->isEmpty())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-[1.5px] border-black/20">
                        <div class="p-6 text-center text-gray-500">{{ __('لا توجد بيانات') }}</div>
                    </div>
                @else
                    @foreach($groupedRecords as $date => $dayAppointments)
                        <div class="mb-8" x-show="filteredAppointments.filter(a => a.appointment_date_grouped === '{{ $date }}').length > 0">
                            <h3 class="text-lg font-bold text-gray-800 mb-3 sticky top-0 bg-gray-100/80 backdrop-blur-sm px-4 py-2 rounded-md border border-gray-200">
                                {{ \Carbon\Carbon::parse($date)->locale('ar')->translatedFormat('Y - F - d') }}
                            </h3>
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-[1.5px] border-black/20">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white border-0">
                                        <thead>
                                                <tr class="bg-gray-50 border-b border-gray-200">
                                                    <th x-show="editMode" scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-12 text-center">
                                                        <input type="checkbox" @click="toggleSelectAll" :checked="allSelected" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                    </th>
                                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('اسم المريض') }}</th>
                                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('رقم الهاتف') }}</th>
                                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('رقم الحجز') }}</th>
                                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('نوع الحجز') }}</th>
                                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('الطبيب') }}</th>
                                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('تاريخ الموعد') }}</th>
                                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('وقت الموعد') }}</th>
                                                    @if(auth()->user()->role === 'doctor')
                                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('السعر') }}</th>
                                                    @endif
                                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">{{ __('الحالة') }}</th>
                                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 whitespace-nowrap w-auto">{{ __('إجراءات') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                <template x-for="appointment in filteredAppointments.filter(a => a.appointment_date_grouped === '{{ $date }}')" :key="appointment.id">
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

                                                        <td class="px-0 py-0 whitespace-nowrap text-sm font-bold text-gray-900 border-b border-gray-200 border-l h-full text-center bg-gray-50">
                                                            <div class="px-6 py-4" x-text="appointment.queue_number || '-'"></div>
                                                        </td>

                                                        <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                            <template x-if="!editMode">
                                                                <div class="px-6 py-4">
                                                                    <template x-if="appointment.is_session">
                                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                                                            {{ __('جلسة') }} <span x-show="appointment.session_type" x-text="' - ' + (appointment.session_type ? appointment.session_type.name : '')"></span>
                                                                        </span>
                                                                    </template>
                                                                    <template x-if="!appointment.is_session">
                                                                        <span class="text-gray-400">-</span>
                                                                    </template>
                                                                </div>
                                                            </template>
                                                            <template x-if="editMode">
                                                                <div class="px-4 py-2 flex flex-col gap-2">
                                                                    <label class="inline-flex items-center">
                                                                        <input type="checkbox" x-model="appointment.is_session" @change="saveAppointment(appointment)" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                                        <span class="ml-2 mr-2 text-xs text-gray-600">{{ __('جلسة؟') }}</span>
                                                                    </label>
                                                                    <select x-show="appointment.is_session" x-model="appointment.session_type_id" @change="saveAppointment(appointment)" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-xs py-1">
                                                                        <option value="">{{ __('اختر النوع') }}</option>
                                                                        @foreach($sessionTypes as $type)
                                                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </template>
                                                        </td>

                                                        <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                            <div class="px-6 py-4" x-text="appointment.doctor ? appointment.doctor.name : '-'"></div>
                                                        </td>

                                                        <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                            <template x-if="!editMode">
                                                                <div class="px-6 py-4 text-left" dir="ltr" x-text="appointment.appointment_date_formatted"></div>
                                                            </template>
                                                            <template x-if="editMode">
                                                                <input type="date" x-model="appointment.appointment_date_formatted" @blur="saveAppointment(appointment)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0 text-sm text-left" dir="ltr">
                                                            </template>
                                                        </td>

                                                        <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                            <template x-if="!editMode">
                                                                <div class="px-6 py-4 text-left" dir="ltr" x-text="appointment.appointment_time_display"></div>
                                                            </template>
                                                            <template x-if="editMode">
                                                                <input type="time" x-model="appointment.appointment_time_formatted" @blur="saveAppointment(appointment)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0 text-sm text-left" dir="ltr">
                                                            </template>
                                                        </td>

                                                        @if(auth()->user()->role === 'doctor')
                                                        <td class="px-0 py-0 whitespace-nowrap text-sm font-medium border-b border-gray-200 border-l h-full">
                                                            <template x-if="!editMode">
                                                                <div class="px-6 py-4">
                                                                    <span x-show="appointment.price" class="text-green-600 bg-green-50 px-2.5 py-1 rounded-md border border-green-200 inline-flex items-center space-x-1 rtl:space-x-reverse" dir="ltr">
                                                                        <span x-text="Number(appointment.price).toLocaleString()"></span>
                                                                        <span class="text-xs">{{ __('د.ع') }}</span>
                                                                    </span>
                                                                    <span x-show="!appointment.price" class="text-gray-400">-</span>
                                                                </div>
                                                            </template>
                                                            <template x-if="editMode">
                                                                <input type="number" x-model="appointment.price" @blur="saveAppointment(appointment)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0 text-sm" placeholder="0">
                                                            </template>
                                                        </td>
                                                        @endif

                                                        <td class="px-0 py-0 whitespace-nowrap text-sm border-b border-gray-200 border-l h-full">
                                                            <template x-if="!editMode">
                                                                <div class="px-6 py-4 flex items-center justify-center h-full">
                                                                    <template x-if="appointment.status !== 'pending'">
                                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm border"
                                                                            :class="{
                                                                                'bg-green-50 text-green-700 border-green-200': appointment.status === 'completed',
                                                                                'bg-red-50 text-red-700 border-red-200': appointment.status === 'cancelled'
                                                                            }"
                                                                            x-text="appointment.status === 'completed' ? '{{ __('مكتمل') }}' : '{{ __('ملغي') }}'">
                                                                        </span>
                                                                    </template>
                                                                    <template x-if="appointment.status === 'pending'">
                                                                        <div class="flex gap-2">
                                                                            <button type="button" @click="quickUpdateStatus(appointment, 'completed')" class="inline-flex items-center px-2 py-1 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm" title="{{ __('مكتمل') }}">
                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                            </button>
                                                                            <button type="button" @click="quickUpdateStatus(appointment, 'cancelled')" class="inline-flex items-center px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm" title="{{ __('إلغاء') }}">
                                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                            </button>
                                                                        </div>
                                                                    </template>
                                                                </div>
                                                            </template>
                                                            <template x-if="editMode">
                                                                <select x-model="appointment.status" @change="saveAppointment(appointment)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0 text-sm">
                                                                    <option value="pending">{{ __('قيد الانتظار') }}</option>
                                                                    <option value="completed">{{ __('مكتمل') }}</option>
                                                                    <option value="cancelled">{{ __('ملغي') }}</option>
                                                                </select>
                                                            </template>
                                                        </td>

                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium border-b border-gray-200 text-center">
                                                            <div class="flex space-x-2 rtl:space-x-reverse justify-center">
                                                                <template x-if="(appointment.patient ? appointment.patient.phone : appointment.phone)">
                                                                    <div class="flex space-x-2 rtl:space-x-reverse">
                                                                        <a :href="'tel:' + (appointment.patient ? appointment.patient.phone : appointment.phone)" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded transition-colors border border-indigo-200" title="{{ __('اتصال') }}">
                                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                                        </a>
                                                                        <a :href="'https://wa.me/' + ((appointment.patient ? appointment.patient.phone : appointment.phone) || '').replace(/[^0-9]/g, '')" target="_blank" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 p-2 rounded transition-colors border border-emerald-200" title="{{ __('واتساب') }}">
                                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                                                        </a>
                                                                    </div>
                                                                </template>
                                                                <template x-if="!(appointment.patient ? appointment.patient.phone : appointment.phone)">
                                                                    <span class="text-gray-400 text-xs">{{ __('لا يوجد رقم') }}</span>
                                                                </template>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('appointmentsGrid', (initialAppointments) => ({
                viewMode: 'default',
                appointments: initialAppointments.map(a => {
                    let time_str = a.appointment_time ? a.appointment_time.substring(0, 5) : '';
                    let time_display = '';
                    if (time_str) {
                        let parts = time_str.split(':');
                        let h = parseInt(parts[0], 10);
                        let m = parts[1];
                        let ampm = h >= 12 ? 'PM' : 'AM';
                        h = h % 12;
                        h = h ? h : 12;
                        time_display = h.toString().padStart(2, '0') + ':' + m + ' ' + ampm;
                    }

                    return {
                        ...a,
                        appointment_date_formatted: a.appointment_date ? a.appointment_date.substring(0, 10) : '',
                        appointment_time_formatted: time_str,
                        appointment_time_display: time_display
                    };
                }),
                search: '',
                sortBy: 'date_asc',
                editMode: false,
                selected: [],
                now: new Date().getTime(),

                init() {
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
                        const dtA = new Date((a.appointment_date || '1970-01-01') + 'T' + (a.appointment_time || '00:00:00'));
                        const dtB = new Date((b.appointment_date || '1970-01-01') + 'T' + (b.appointment_time || '00:00:00'));
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

                async quickUpdateStatus(appointment, status) {
                    try {
                        appointment.status = status;
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                        const response = await fetch(`/appointments/${appointment.id}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Cache-Control': 'no-cache'
                            },
                            body: JSON.stringify({
                                status: appointment.status
                            })
                        });

                        if (!response.ok) {
                            console.error('Failed to update status', await response.text());
                        } else {
                            const data = await response.json();
                            if (data.redirect_url) {
                                window.location.href = data.redirect_url;
                            } else {
                                window.location.reload();
                            }
                        }
                    } catch (error) {
                        console.error('Error updating status:', error);
                    }
                },

                async saveAppointment(appointment) {
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                        appointment.appointment_date = appointment.appointment_date_formatted;
                        appointment.appointment_time = appointment.appointment_time_formatted;

                        const response = await fetch(`/appointments/${appointment.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Cache-Control': 'no-cache'
                            },
                            body: JSON.stringify({
                                appointment_date: appointment.appointment_date,
                                appointment_time: appointment.appointment_time,
                                price: appointment.price || null,
                                status: appointment.status,
                                is_session: appointment.is_session ? 1 : 0,
                                session_type_id: appointment.session_type_id || null
                            })
                        });

                        if (!response.ok) {
                            console.error('Failed to save appointment', await response.text());
                        } else {
                            const data = await response.json();
                            if (data.appointment && data.appointment.status) {
                                appointment.status = data.appointment.status;
                            }
                            window.location.reload(); // Reload to refresh relations like session_type name
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

            }));
        });
    </script>
    @endpush
</x-app-layout>
