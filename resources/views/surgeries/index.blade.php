<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center" dir="rtl">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('سجل العمليات') }}
            </h2>
        </div>
    </x-slot>

    @php
        $surgeriesArray = clone $surgeries;
        $surgeriesArray->transform(function($surgery) {
            $surgery->surgery_date_grouped = $surgery->surgery_date ? \Carbon\Carbon::parse($surgery->surgery_date)->format('Y-m-d') : '';
            return $surgery;
        });
        $groupedRecords = collect($surgeriesArray)->sortByDesc('surgery_date_grouped')->groupBy('surgery_date_grouped');
    @endphp

    <div class="py-12" dir="rtl" x-data="surgeriesGrid(@js($surgeriesArray))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Add Surgery Modal -->
            <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showAddModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div x-show="showAddModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                        <form method="POST" action="{{ route('surgeries.store') }}">
                            @csrf
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-right w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                            {{ __('إضافة عملية جديدة') }}
                                        </h3>
                                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- Patient -->
                                            <div>
                                                <x-input-label for="patient_id" :value="__('اسم المريض')" />
                                                <select id="patient_id" name="patient_id" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full" required>
                                                    <option value="" disabled selected>{{ __('اختر المريض') }}</option>
                                                    @foreach($patients as $patient)
                                                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Surgery Type -->
                                            <div>
                                                <x-input-label for="surgery_type_id" :value="__('نوع العملية')" />
                                                <select id="surgery_type_id" name="surgery_type_id" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full" required>
                                                    <option value="" disabled selected>{{ __('اختر نوع العملية') }}</option>
                                                    @foreach($surgeryTypes as $type)
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Surgery Date -->
                                            <div>
                                                <x-input-label for="surgery_date" :value="__('تاريخ العملية')" />
                                                <input type="text" id="surgery_date" name="surgery_date" x-init="flatpickr($el, {allowInput: true, disableMobile: true, dateFormat: 'Y-m-d'})" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full text-left" dir="ltr" required>
                                            </div>

                                            <!-- Hospital Name -->
                                            <div>
                                                <x-input-label for="hospital_name" :value="__('اسم المستشفى')" />
                                                <x-text-input id="hospital_name" name="hospital_name" type="text" class="mt-1 block w-full" required />
                                            </div>

                                            <!-- Surgeon Name -->
                                            <div>
                                                <x-input-label for="surgeon_name" :value="__('اسم الجراح')" />
                                                <x-text-input id="surgeon_name" name="surgeon_name" type="text" class="mt-1 block w-full" required />
                                            </div>

                                            <!-- Disease Name -->
                                            <div>
                                                <x-input-label for="disease_name" :value="__('اسم المرض / التشخيص')" />
                                                <x-text-input id="disease_name" name="disease_name" type="text" class="mt-1 block w-full" required />
                                            </div>

                                            <!-- Assistant Name -->
                                            <div>
                                                <x-input-label for="assistant_name" :value="__('اسم المساعد')" />
                                                <x-text-input id="assistant_name" name="assistant_name" type="text" class="mt-1 block w-full" />
                                            </div>

                                            <!-- Anesthesiologist Name -->
                                            <div>
                                                <x-input-label for="anesthesiologist_name" :value="__('اسم طبيب التخدير')" />
                                                <x-text-input id="anesthesiologist_name" name="anesthesiologist_name" type="text" class="mt-1 block w-full" />
                                            </div>

                                            <!-- Anesthesia Type -->
                                            <div>
                                                <x-input-label for="anesthesia_type" :value="__('نوع التخدير')" />
                                                <select id="anesthesia_type" name="anesthesia_type" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full" required>
                                                    <option value="" disabled selected>{{ __('اختر نوع التخدير') }}</option>
                                                    <option value="تخدير عام">{{ __('تخدير عام') }}</option>
                                                    <option value="تخدير موضعي">{{ __('تخدير موضعي') }}</option>
                                                    <option value="تخدير قطني">{{ __('تخدير قطني') }}</option>
                                                    <option value="أخرى">{{ __('أخرى') }}</option>
                                                </select>
                                            </div>

                                            <!-- Cost -->
                                            <div>
                                                <x-input-label for="cost" :value="__('التكلفة')" />
                                                <div class="relative mt-1">
                                                    <x-text-input id="cost" name="cost" type="number" step="0.01" min="0" class="block w-full pl-10" required />
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">د.ع</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Notes -->
                                        <div class="mt-4">
                                            <x-input-label for="notes" :value="__('ملاحظات')" />
                                            <textarea id="notes" name="notes" rows="3" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    {{ __('حفظ') }}
                                </button>
                                <button type="button" @click="showAddModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    {{ __('إلغاء') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Top Action Bar -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 space-y-4 sm:space-y-0 sm:space-x-4 sm:space-x-reverse">

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
                <div class="flex flex-1 w-full max-w-md items-center space-x-2 space-x-reverse">
                    <input type="text" x-model="search" placeholder="{{ __('ابحث عن عملية (اسم المريض)...') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <select x-model="sortBy" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="date_desc">{{ __('تاريخ العملية (الأحدث)') }}</option>
                        <option value="date_asc">{{ __('تاريخ العملية (الأقدم)') }}</option>
                    </select>
                </div>

                <div class="flex items-center space-x-2 space-x-reverse">
                    <button @click.prevent="openAddModal" class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-neutral-800 transition-colors focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 disabled:opacity-25 duration-150">
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        {{ __('إضافة +') }}
                    </button>
                    <a href="{{ route('surgeries.export_csv') }}" class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-neutral-800 transition-colors focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 disabled:opacity-25 duration-150">
                        {{ __('تصدير CSV') }}
                    </a>
                    <button @click.prevent="editMode = !editMode" :class="editMode ? 'bg-neutral-800 text-white' : 'bg-black text-white'" class="inline-flex items-center px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 disabled:opacity-25">
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
                        <template x-if="filteredSurgeries.length === 0">
                            <div class="p-6 text-center text-gray-500">{{ __('لا توجد بيانات') }}</div>
                        </template>

                        <template x-if="filteredSurgeries.length > 0">
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
                                                {{ __('نوع العملية') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 whitespace-nowrap w-auto">
                                                {{ __('تاريخ العملية') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <template x-for="surgery in filteredSurgeries" :key="surgery.id">
                                            <tr class="hover:bg-gray-50">
                                                <td x-show="editMode" class="px-4 py-3 whitespace-nowrap border-b border-gray-200 border-l text-center">
                                                    <input type="checkbox" x-model="selected" :value="surgery.id" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-b border-gray-200 border-l">
                                                    <span x-text="surgery.patient ? surgery.patient.name : '-'"></span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l">
                                                    <span x-text="surgery.surgery_type ? surgery.surgery_type.name : '-'"></span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200">
                                                    <span x-text="surgery.surgery_date ? surgery.surgery_date.split('T')[0] : '-'" dir="ltr"></span>
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
                    @foreach($groupedRecords as $date => $surgeriesGroup)
                        <div class="mb-8" x-show="filteredSurgeries.filter(s => s.surgery_date_grouped === '{{ $date }}').length > 0">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, j F Y') }}</h3>
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-[1.5px] border-black/20">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th x-show="editMode" scope="col" class="w-12 px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l">
                                                    <input type="checkbox" x-model="selected" :value="'all_{{ $date }}'" @click="toggleGroupSelect('{{ $date }}')" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">
                                                    {{ __('اسم المريض') }}
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">
                                                    {{ __('نوع العملية') }}
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 whitespace-nowrap w-auto">
                                                    {{ __('تاريخ العملية') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <template x-for="surgery in filteredSurgeries.filter(s => s.surgery_date_grouped === '{{ $date }}')" :key="surgery.id">
                                                <tr class="hover:bg-gray-50">
                                                    <td x-show="editMode" class="px-4 py-3 whitespace-nowrap border-b border-gray-200 border-l text-center">
                                                        <input type="checkbox" x-model="selected" :value="surgery.id" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-b border-gray-200 border-l">
                                                        <span x-text="surgery.patient ? surgery.patient.name : '-'"></span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l">
                                                        <span x-text="surgery.surgery_type ? surgery.surgery_type.name : '-'"></span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200">
                                                        <span x-text="surgery.surgery_date ? surgery.surgery_date.split('T')[0] : '-'" dir="ltr"></span>
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
            Alpine.data('surgeriesGrid', (initialSurgeries) => ({
                surgeries: initialSurgeries,
                search: '',
                sortBy: 'date_desc',
                viewMode: 'default',
                editMode: false,
                selected: [],
                showAddModal: false,

                openAddModal() {
                    this.showAddModal = true;
                },

                get filteredSurgeries() {
                    let filtered = this.surgeries;

                    if (this.search) {
                        const q = this.search.toLowerCase();
                        filtered = filtered.filter(s => (s.patient && s.patient.name.toLowerCase().includes(q)));
                    }

                    if (this.sortBy.startsWith('status_')) {
                        const statusToMatch = this.sortBy.replace('status_', '');
                        filtered = filtered.filter(s => s.status === statusToMatch);
                    }

                    return filtered.sort((a, b) => {
                        const dateA = new Date(a.surgery_date || 0);
                        const dateB = new Date(b.surgery_date || 0);
                        if (this.sortBy === 'date_desc' || this.sortBy.startsWith('status_')) {
                            return dateB - dateA;
                        } else if (this.sortBy === 'date_asc') {
                            return dateA - dateB;
                        }
                        return 0;
                    });
                },

                get allSelected() {
                    return this.filteredSurgeries.length > 0 && this.selected.length === this.filteredSurgeries.length;
                },

                toggleSelectAll() {
                    if (this.allSelected) {
                        this.selected = [];
                    } else {
                        this.selected = this.filteredSurgeries.map(s => s.id);
                    }
                },

                toggleGroupSelect(date) {
                    const groupIds = this.filteredSurgeries.filter(s => s.surgery_date_grouped === date).map(s => s.id);
                    const allGroupSelected = groupIds.every(id => this.selected.includes(id));

                    if (allGroupSelected) {
                        this.selected = this.selected.filter(id => !groupIds.includes(id));
                    } else {
                        groupIds.forEach(id => {
                            if (!this.selected.includes(id)) {
                                this.selected.push(id);
                            }
                        });
                    }
                },

                async updateStatus(surgery, status) {
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                        const response = await fetch(`/surgeries/${surgery.id}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ status })
                        });

                        if (response.ok) {
                            surgery.status = status;
                            alert('{{ __('تم تحديث الحالة بنجاح') }}');
                        } else {
                            console.error('Failed to update status', await response.text());
                            alert('{{ __('حدث خطأ أثناء تحديث الحالة') }}');
                        }
                    } catch (error) {
                        console.error('Error updating status:', error);
                        alert('{{ __('حدث خطأ أثناء تحديث الحالة') }}');
                    }
                },

                async deleteSelected() {
                    if (!confirm('{{ __('هل أنت متأكد من حذف العمليات المحددة؟') }}')) return;

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                        const response = await fetch('{{ route('surgeries.bulk_delete') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                ids: this.selected.filter(id => typeof id === 'number' || !id.startsWith('all_'))
                            })
                        });

                        if (response.ok) {
                            this.surgeries = this.surgeries.filter(s => !this.selected.includes(String(s.id)) && !this.selected.includes(s.id));
                            this.selected = [];
                        } else {
                            console.error('Failed to delete surgeries', await response.text());
                            alert('{{ __('حدث خطأ أثناء الحذف') }}');
                        }
                    } catch (error) {
                        console.error('Error deleting surgeries:', error);
                        alert('{{ __('حدث خطأ أثناء الحذف') }}');
                    }
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>
