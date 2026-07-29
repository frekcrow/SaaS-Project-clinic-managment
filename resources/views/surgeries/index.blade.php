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
