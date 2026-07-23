<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('سجل المرضى') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12" x-data="patientsGrid(@js($patients))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Top Action Bar -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 space-y-4 sm:space-y-0 sm:space-x-4 sm:space-x-reverse">
                <div class="flex flex-1 w-full max-w-md items-center space-x-2 space-x-reverse">
                    <input type="text" x-model="search" placeholder="{{ __('ابحث عن مريض...') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <select x-model="sortBy" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="newest">{{ __('الأحدث') }}</option>
                        <option value="oldest">{{ __('الأقدم') }}</option>
                        <option value="az">{{ __('أ-ي') }}</option>
                        <option value="za">{{ __('ي-أ') }}</option>
                    </select>
                </div>

                <div class="flex items-center space-x-2 space-x-reverse">
                    <a href="{{ route('patients.export_csv') }}" class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-neutral-800 transition-colors focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:ring-offset-2 disabled:opacity-25 duration-150">
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
                    <template x-if="filteredPatients.length === 0">
                        <div class="p-6 text-center text-gray-500">{{ __('لا توجد بيانات') }}</div>
                    </template>

                    <template x-if="filteredPatients.length > 0">
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
                                            {{ __('رقم الهاتف') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 border-l whitespace-nowrap w-auto">
                                            {{ __('تاريخ الميلاد') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 whitespace-nowrap w-auto">
                                            {{ __('الإجراءات') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <template x-for="patient in filteredPatients" :key="patient.id">
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td x-show="editMode" class="px-4 py-3 whitespace-nowrap border-b border-gray-200 border-l text-center">
                                                <input type="checkbox" x-model="selected" :value="patient.id" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            </td>
                                            <td class="px-0 py-0 whitespace-nowrap text-sm font-medium text-gray-900 border-b border-gray-200 border-l h-full">
                                                <template x-if="!editMode">
                                                    <div class="px-6 py-4" x-text="patient.name"></div>
                                                </template>
                                                <template x-if="editMode">
                                                    <input type="text" x-model="patient.name" @blur="savePatient(patient)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0">
                                                </template>
                                            </td>
                                            <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                <template x-if="!editMode">
                                                    <div class="px-6 py-4" x-text="patient.phone || '-'"></div>
                                                </template>
                                                <template x-if="editMode">
                                                    <input type="text" x-model="patient.phone" @blur="savePatient(patient)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0" placeholder="-">
                                                </template>
                                            </td>
                                            <td class="px-0 py-0 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200 border-l h-full">
                                                <template x-if="!editMode">
                                                    <div class="px-6 py-4" x-text="patient.dob_formatted || '-'"></div>
                                                </template>
                                                <template x-if="editMode">
                                                    <input type="date" x-model="patient.dob_formatted" @blur="savePatient(patient)" class="w-full h-full border-0 focus:ring-0 px-6 py-4 bg-transparent m-0 text-sm">
                                                </template>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium border-b border-gray-200">
                                                <a :href="'/patients/' + patient.id" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded transition-colors border border-indigo-200">
                                                    {{ __('ملف المريض') }}
                                                </a>
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
            Alpine.data('patientsGrid', (initialPatients) => ({
                patients: initialPatients.map(p => ({
                    ...p,
                    dob_formatted: p.dob ? p.dob.substring(0, 10) : ''
                })),
                search: '',
                sortBy: 'newest',
                editMode: false,
                selected: [],

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
                                dob: patient.dob_formatted || null
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
