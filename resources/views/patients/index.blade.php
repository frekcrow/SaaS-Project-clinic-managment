<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('سجل المرضى') }}
            </h2>
        </div>
    </x-slot>

    @php
        $formattedPatients = $patients->map(function($patient) {
            $formatted = $patient->toArray();
            $formatted['dob_formatted'] = $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('Y/m/d') : '';
            $formatted['dob_day'] = $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('d') : '';
            $formatted['dob_month'] = $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('m') : '';
            $formatted['dob_year'] = $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('Y') : '';
            $formatted['created_at_date'] = $patient->created_at ? \Carbon\Carbon::parse($patient->created_at)->format('Y-m-d') : '';
            return $formatted;
        });

        $groupedRecords = collect($formattedPatients)->sortByDesc('created_at_date')->groupBy('created_at_date');
    @endphp
    <div class="py-12" x-data="patientsGrid(@js($formattedPatients))">
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
                    <input type="text" x-model="search" placeholder="{{ __('ابحث عن مريض...') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <select x-model="sortBy" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="newest">{{ __('الأحدث') }}</option>
                        <option value="oldest">{{ __('الأقدم') }}</option>
                        <option value="az">{{ __('أ-ي') }}</option>
                        <option value="za">{{ __('ي-أ') }}</option>
                    </select>
                </div>

                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                    <a href="{{ route('patients.create') }}" class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-neutral-800 transition-colors focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 disabled:opacity-25 duration-150">
                        {{ __('اضافة +') }}
                    </a>
                    <a href="{{ route('patients.export_csv') }}" class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-neutral-800 transition-colors focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 disabled:opacity-25 duration-150">
                        {{ __('تصدير CSV') }}
                    </a>
                    <button @click.prevent="editMode = !editMode" :class="editMode ? 'bg-neutral-800 text-white' : 'bg-black text-white'" class="inline-flex items-center px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 disabled:opacity-25">
                        {{ __('تعديل') }}
                    </button>
                </div>
            </div>

            <!-- Transfer Modal -->
            <div x-show="showTransferModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showTransferModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showTransferModal = false"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div x-show="showTransferModal" x-transition.scale.origin.bottom class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full" >
                        <form @submit.prevent="submitTransfer">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:text-right w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                            {{ __('تحويل إلى العمليات') }} - <span x-text="transferPatient ? transferPatient.name : ''"></span>
                                        </h3>
                                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <x-input-label for="surgery_type_id" :value="__('نوع العملية')" />
                                                <select id="surgery_type_id" x-model="transferForm.surgery_type_id" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full" required>
                                                    <option value="" disabled>{{ __('اختر نوع العملية') }}</option>
                                                    @foreach($surgeryTypes as $type)
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <x-input-label for="surgery_date" :value="__('تاريخ العملية')" />
                                                <input type="text" id="surgery_date" x-model="transferForm.surgery_date" x-init="flatpickr($el, {allowInput: true, disableMobile: true, dateFormat: 'Y-m-d'})" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full text-left" dir="ltr" required>
                                            </div>

                                            <div>
                                                <x-input-label for="hospital_name" :value="__('اسم المستشفى')" />
                                                <x-text-input id="hospital_name" x-model="transferForm.hospital_name" type="text" class="mt-1 block w-full" required />
                                            </div>

                                            <div>
                                                <x-input-label for="surgeon_name" :value="__('اسم الجراح')" />
                                                <x-text-input id="surgeon_name" x-model="transferForm.surgeon_name" type="text" class="mt-1 block w-full" required />
                                            </div>

                                            <div>
                                                <x-input-label for="disease_name" :value="__('اسم المرض / التشخيص')" />
                                                <x-text-input id="disease_name" x-model="transferForm.disease_name" type="text" class="mt-1 block w-full" required />
                                            </div>

                                            <div>
                                                <x-input-label for="assistant_name" :value="__('اسم المساعد')" />
                                                <x-text-input id="assistant_name" x-model="transferForm.assistant_name" type="text" class="mt-1 block w-full" />
                                            </div>

                                            <div>
                                                <x-input-label for="anesthesiologist_name" :value="__('اسم طبيب التخدير')" />
                                                <x-text-input id="anesthesiologist_name" x-model="transferForm.anesthesiologist_name" type="text" class="mt-1 block w-full" />
                                            </div>

                                            <div>
                                                <x-input-label for="anesthesia_type" :value="__('نوع التخدير')" />
                                                <select id="anesthesia_type" x-model="transferForm.anesthesia_type" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full" required>
                                                    <option value="" disabled>{{ __('اختر نوع التخدير') }}</option>
                                                    <option value="{{ __('تخدير عام') }}">{{ __('تخدير عام') }}</option>
                                                    <option value="{{ __('تخدير موضعي') }}">{{ __('تخدير موضعي') }}</option>
                                                    <option value="{{ __('تخدير قطني') }}">{{ __('تخدير قطني') }}</option>
                                                    <option value="{{ __('أخرى') }}">{{ __('أخرى') }}</option>
                                                </select>
                                            </div>

                                            <div>
                                                <x-input-label for="cost" :value="__('التكلفة')" />
                                                <div class="relative mt-1">
                                                    <x-text-input id="cost" x-model="transferForm.cost" type="number" step="0.01" min="0" class="block w-full pl-10" required />
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">{{ __('د.ع') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <x-input-label for="notes" :value="__('ملاحظات')" />
                                            <textarea id="notes" x-model="transferForm.notes" rows="3" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-black text-base font-medium text-white hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-900 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                    {{ __('حفظ') }}
                                </button>
                                <button type="button" @click="showTransferModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                    {{ __('إلغاء') }}
                                </button>
                            </div>
                        </form>
                    </div>
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
                        <template x-if="filteredPatients.length === 0">
                            <div class="p-6 text-center text-gray-500">{{ __('لا توجد بيانات') }}</div>
                        </template>

                        <template x-if="filteredPatients.length > 0">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th x-show="editMode" scope="col" class="w-12 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l">
                                                <input type="checkbox" @click="toggleSelectAll" :checked="allSelected" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">
                                                {{ __('اسم المريض') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">
                                                {{ __('رقم الهاتف') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">
                                                {{ __('تاريخ الميلاد') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 whitespace-nowrap w-auto">
                                                {{ __('الإجراءات') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <template x-for="patient in filteredPatients" :key="patient.id">
                                            <tr class="hover:bg-gray-50">
                                                <td x-show="editMode" class="px-4 py-3 whitespace-nowrap border-b border-gray-200 border-l text-center">
                                                    <input type="checkbox" x-model="selected" :value="patient.id" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                </td>
                                                <td class="px-0 py-0 text-center whitespace-nowrap text-sm font-medium text-gray-900 border-b border-gray-200 border-l h-full">
                                                    <template x-if="!editMode">
                                                        <div class="px-6 py-4 text-center" x-text="patient.name"></div>
                                                    </template>
                                                    <template x-if="editMode">
                                                        <input type="text" x-model="patient.name" @blur="savePatient(patient)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0">
                                                    </template>
                                                </td>
                                                <td class="px-0 py-0 text-center whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                    <template x-if="!editMode">
                                                        <div class="px-6 py-4 text-center" x-text="patient.phone || '-'"></div>
                                                    </template>
                                                    <template x-if="editMode">
                                                        <input type="text" x-model="patient.phone" @blur="savePatient(patient)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0" placeholder="-">
                                                    </template>
                                                </td>
                                                <td class="px-0 py-0 text-center whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                    <template x-if="!editMode">
                                                        <div class="px-6 py-4 text-center" dir="ltr" x-text="patient.dob_formatted || '-'"></div>
                                                    </template>
                                                    <template x-if="editMode">
                                                        <div class="flex space-x-1 rtl:space-x-reverse h-full px-2 py-4" dir="ltr">
                                                            <input type="number" x-model="patient.dob_day" @keyup.enter="savePatient(patient)" class="w-1/3 border-gray-300 rounded focus:ring-indigo-500 p-1 text-center text-sm" placeholder="DD" min="1" max="31">
                                                            <input type="number" x-model="patient.dob_month" @keyup.enter="savePatient(patient)" class="w-1/3 border-gray-300 rounded focus:ring-indigo-500 p-1 text-center text-sm" placeholder="MM" min="1" max="12">
                                                            <input type="number" x-model="patient.dob_year" @blur="savePatient(patient)" @keyup.enter="savePatient(patient)" class="w-1/3 border-gray-300 rounded focus:ring-indigo-500 p-1 text-center text-sm" placeholder="YYYY" min="1900" max="{{ date('Y') }}">
                                                        </div>
                                                    </template>
                                                </td>
                                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium border-b border-gray-200">
                                                    <div class="flex items-center justify-center gap-2 w-max mx-auto">
                                                        <a :href="'/patients/' + patient.id" title="{{ __('ملف المريض') }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded transition-colors border border-indigo-200">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                            </svg>
                                                        </a>
                                                        <button @click="openTransferModal(patient)" title="{{ __('تحويل إلى العمليات') }}" class="text-white bg-black hover:bg-neutral-800 p-2 rounded transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 disabled:opacity-25">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                                            </svg>
                                                        </button>
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

            <div x-show="viewMode === 'grouped'" x-cloak>
                @if($groupedRecords->isEmpty())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-[1.5px] border-black/20">
                        <div class="p-6 text-center text-gray-500">{{ __('لا توجد بيانات') }}</div>
                    </div>
                @else
                    @foreach($groupedRecords as $date => $dayPatients)
                        <div class="mb-8" x-show="filteredPatients.filter(p => p.created_at_date === '{{ $date }}').length > 0">
                            <h3 class="text-lg font-bold text-gray-800 mb-3 sticky top-0 bg-gray-100/80 backdrop-blur-sm px-4 py-2 rounded-md border border-gray-200">
                                {{ \Carbon\Carbon::parse($date)->locale('ar')->translatedFormat('Y - F - d') }}
                            </h3>
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-[1.5px] border-black/20">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th x-show="editMode" scope="col" class="w-12 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l">
                                                    <input type="checkbox" @click="toggleSelectAll" :checked="allSelected" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">
                                                    {{ __('اسم المريض') }}
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">
                                                    {{ __('رقم الهاتف') }}
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">
                                                    {{ __('تاريخ الميلاد') }}
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 whitespace-nowrap w-auto">
                                                    {{ __('الإجراءات') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <template x-for="patient in filteredPatients.filter(p => p.created_at_date === '{{ $date }}')" :key="patient.id">
                                                <tr class="hover:bg-gray-50">
                                                    <td x-show="editMode" class="px-4 py-3 whitespace-nowrap border-b border-gray-200 border-l text-center">
                                                        <input type="checkbox" x-model="selected" :value="patient.id" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                    </td>
                                                    <td class="px-0 py-0 text-center whitespace-nowrap text-sm font-medium text-gray-900 border-b border-gray-200 border-l h-full">
                                                        <template x-if="!editMode">
                                                            <div class="px-6 py-4 text-center" x-text="patient.name"></div>
                                                        </template>
                                                        <template x-if="editMode">
                                                            <input type="text" x-model="patient.name" @blur="savePatient(patient)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0">
                                                        </template>
                                                    </td>
                                                    <td class="px-0 py-0 text-center whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                        <template x-if="!editMode">
                                                            <div class="px-6 py-4 text-center" x-text="patient.phone || '-'"></div>
                                                        </template>
                                                        <template x-if="editMode">
                                                            <input type="text" x-model="patient.phone" @blur="savePatient(patient)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0" placeholder="-">
                                                        </template>
                                                    </td>
                                                    <td class="px-0 py-0 text-center whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                        <template x-if="!editMode">
                                                            <div class="px-6 py-4 text-center" dir="ltr" x-text="patient.dob_formatted || '-'"></div>
                                                        </template>
                                                        <template x-if="editMode">
                                                            <div class="flex space-x-1 rtl:space-x-reverse h-full px-2 py-4" dir="ltr">
                                                                <input type="number" x-model="patient.dob_day" @keyup.enter="savePatient(patient)" class="w-1/3 border-gray-300 rounded focus:ring-indigo-500 p-1 text-center text-sm" placeholder="DD" min="1" max="31">
                                                                <input type="number" x-model="patient.dob_month" @keyup.enter="savePatient(patient)" class="w-1/3 border-gray-300 rounded focus:ring-indigo-500 p-1 text-center text-sm" placeholder="MM" min="1" max="12">
                                                                <input type="number" x-model="patient.dob_year" @blur="savePatient(patient)" @keyup.enter="savePatient(patient)" class="w-1/3 border-gray-300 rounded focus:ring-indigo-500 p-1 text-center text-sm" placeholder="YYYY" min="1900" max="{{ date('Y') }}">
                                                            </div>
                                                        </template>
                                                    </td>
                                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium border-b border-gray-200">
                                                        <div class="flex items-center justify-center gap-2 w-max mx-auto">
                                                            <a :href="'/patients/' + patient.id" title="{{ __('ملف المريض') }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded transition-colors border border-indigo-200">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                </svg>
                                                            </a>
                                                            <button @click="openTransferModal(patient)" title="{{ __('تحويل إلى العمليات') }}" class="text-white bg-black hover:bg-neutral-800 p-2 rounded transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 disabled:opacity-25">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                                                </svg>
                                                            </button>
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
            Alpine.data('patientsGrid', (initialPatients) => ({
                patients: initialPatients,
                search: '',
                sortBy: 'newest',
                viewMode: 'default',
                editMode: false,
                selected: [],
                showTransferModal: false,
                transferPatient: null,
                transferForm: {
                    surgery_type_id: '',
                    surgery_date: '',
                    hospital_name: '',
                    surgeon_name: '',
                    disease_name: '',
                    assistant_name: '',
                    anesthesiologist_name: '',
                    anesthesia_type: '',
                    cost: '',
                    notes: ''
                },

                openTransferModal(patient) {
                    this.transferPatient = patient;
                    this.transferForm.surgery_type_id = '';
                    this.transferForm.surgery_date = '';
                    this.transferForm.hospital_name = '';
                    this.transferForm.surgeon_name = '';
                    this.transferForm.disease_name = '';
                    this.transferForm.assistant_name = '';
                    this.transferForm.anesthesiologist_name = '';
                    this.transferForm.anesthesia_type = '';
                    this.transferForm.cost = '';
                    this.transferForm.notes = '';
                    this.showTransferModal = true;
                },

                async submitTransfer() {
                    if (!this.transferForm.surgery_type_id || !this.transferForm.surgery_date || !this.transferForm.hospital_name || !this.transferForm.surgeon_name || !this.transferForm.disease_name || !this.transferForm.anesthesia_type || !this.transferForm.cost) {
                        alert('{{ __('يرجى تعبئة جميع الحقول المطلوبة') }}');
                        return;
                    }
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                        const response = await fetch('{{ route('surgeries.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                patient_id: this.transferPatient.id,
                                surgery_type_id: this.transferForm.surgery_type_id,
                                surgery_date: this.transferForm.surgery_date,
                                hospital_name: this.transferForm.hospital_name,
                                surgeon_name: this.transferForm.surgeon_name,
                                disease_name: this.transferForm.disease_name,
                                assistant_name: this.transferForm.assistant_name,
                                anesthesiologist_name: this.transferForm.anesthesiologist_name,
                                anesthesia_type: this.transferForm.anesthesia_type,
                                cost: this.transferForm.cost,
                                notes: this.transferForm.notes
                            })
                        });

                        if (response.ok) {
                            this.showTransferModal = false;
                            alert('{{ __('تم تحويل المريض بنجاح') }}');
                        } else {
                            console.error('Failed to transfer patient', await response.text());
                            alert('{{ __('حدث خطأ أثناء تحويل المريض') }}');
                        }
                    } catch (error) {
                        console.error('Error transferring patient:', error);
                    }
                },

                get filteredPatients() {
                    let filtered = this.patients;

                    if (this.search) {
                        const q = this.search.toLowerCase();
                        filtered = filtered.filter(p => p.name.toLowerCase().includes(q) || (p.phone && p.phone.toLowerCase().includes(q)));
                    }

                    return filtered.sort((a, b) => {
                        if (this.sortBy === 'newest') {
                            return new Date(b.created_at || 0) < new Date(a.created_at || 0) ? -1 : 1;
                        } else if (this.sortBy === 'oldest') {
                            return new Date(a.created_at || 0) < new Date(b.created_at || 0) ? -1 : 1;
                        } else if (this.sortBy === 'az') {
                            return (a.name || '').localeCompare(b.name || '', 'ar');
                        } else if (this.sortBy === 'za') {
                            return (b.name || '').localeCompare(a.name || '', 'ar');
                        }
                        return 0;
                    });
                },

                get allSelected() {
                    return this.filteredPatients.length > 0 && this.selected.length === this.filteredPatients.length;
                },

                toggleSelectAll() {
                    if (this.allSelected) {
                        this.selected = [];
                    } else {
                        this.selected = this.filteredPatients.map(p => p.id);
                    }
                },

                async savePatient(patient) {
                    try {
                        let updatedDob = null;
                        if (patient.dob_year && patient.dob_month && patient.dob_day) {
                            updatedDob = `${patient.dob_year}-${String(patient.dob_month).padStart(2, '0')}-${String(patient.dob_day).padStart(2, '0')}`;
                            patient.dob_formatted = `${patient.dob_year}/${String(patient.dob_month).padStart(2, '0')}/${String(patient.dob_day).padStart(2, '0')}`;
                        } else if (!patient.dob_year && !patient.dob_month && !patient.dob_day) {
                            updatedDob = null;
                            patient.dob_formatted = '';
                        } else {
                            updatedDob = patient.dob_formatted ? patient.dob_formatted.replace(/\//g, '-') : null;
                        }

                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                        const response = await fetch(`/patients/${patient.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                name: patient.name,
                                phone: patient.phone,
                                dob: updatedDob
                            })
                        });

                        if (!response.ok) {
                            console.error('Failed to save patient', await response.text());
                        }
                    } catch (error) {
                        console.error('Error saving patient:', error);
                    }
                },

                async deleteSelected() {
                    if (!confirm('{{ __('هل أنت متأكد من حذف المرضى المحددين؟') }}')) return;

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                        const response = await fetch('{{ route('patients.bulk_delete') }}', {
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
                            this.patients = this.patients.filter(p => !this.selected.includes(String(p.id)) && !this.selected.includes(p.id));
                            this.selected = [];
                        } else {
                            console.error('Failed to delete patients', await response.text());
                        }
                    } catch (error) {
                        console.error('Error deleting patients:', error);
                    }
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>
