<x-doctor-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-2xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ __('ملفات المرضى') }}
            </h2>
        </div>
    </x-slot>

    @push('styles')
    <style>
        .patient-card {
            opacity: 0;
            transform: translateY(8px);
            animation: fadeIn 300ms cubic-bezier(0.25, 0.1, 0.25, 1) forwards;
            transition: all 0.3s cubic-bezier(0.25, 0.1, 0.25, 1);
        }

        .patient-card:nth-child(1) { animation-delay: 50ms; }
        .patient-card:nth-child(2) { animation-delay: 100ms; }
        .patient-card:nth-child(3) { animation-delay: 150ms; }
        .patient-card:nth-child(4) { animation-delay: 200ms; }
        .patient-card:nth-child(5) { animation-delay: 250ms; }
        .patient-card:nth-child(6) { animation-delay: 300ms; }
        .patient-card:nth-child(7) { animation-delay: 350ms; }
        .patient-card:nth-child(8) { animation-delay: 400ms; }
        .patient-card:nth-child(n+9) { animation-delay: 450ms; }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    @endpush

    <div class="py-12" x-data="doctorPatientsGrid()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Search Bar -->
            <div class="mb-8">
                <div class="relative max-w-md">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" x-model="searchQuery"
                           class="block w-full pl-4 pr-12 py-3 border border-gray-200 dark:border-gray-700 rounded-xl leading-5 bg-white dark:bg-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out text-sm"
                           placeholder="{{ __('ابحث عن مريض بالاسم') }}...">
                </div>
            </div>

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" x-show="filteredPatients.length > 0">
                <template x-for="patient in filteredPatients" :key="patient.id">
                    <a :href="'/doctor/patients/' + patient.id" class="block group patient-card active:scale-[0.97] transition-transform duration-200">
                        <!-- Redesigned Card: Flat, Solid Background, Soft Border, Shadow ONLY on Hover -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 hover:border-gray-200 hover:shadow-lg hover:shadow-gray-200/50 relative overflow-hidden h-full flex flex-col justify-between">

                            <!-- Content -->
                            <div class="flex flex-col items-center justify-center text-center">
                                <!-- Avatar -->
                                <div class="h-16 w-16 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-full flex items-center justify-center mb-4 text-2xl font-bold shadow-none">
                                    <span x-text="patient.name.charAt(0)"></span>
                                </div>

                                <!-- Details -->
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1" x-text="patient.name"></h3>

                                <div class="mt-4 inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 dark:bg-gray-900 rounded-full border border-gray-100 dark:border-gray-700">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-xs font-medium text-gray-500" x-text="formatDate(patient.created_at)"></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredPatients.length === 0" x-cloak class="bg-white dark:bg-gray-800 rounded-2xl p-12 border border-gray-100 dark:border-gray-700 flex flex-col items-center justify-center text-center">
                <div class="w-20 h-20 bg-gray-50 dark:bg-gray-900 text-gray-300 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('لا يوجد مرضى') }}</h3>
                <p class="text-sm text-gray-500 max-w-sm">{{ __('لم يتم العثور على أي ملفات مرضى مطابقة لبحثك') }}.</p>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('doctorPatientsGrid', () => ({
                searchQuery: '',
                patients: @json($patients),

                get filteredPatients() {
                    if (this.searchQuery === '') {
                        return this.patients;
                    }
                    const q = this.searchQuery.toLowerCase();
                    return this.patients.filter(p => p.name.toLowerCase().includes(q));
                },

                formatDate(dateString) {
                    if (!dateString) return '';
                    const d = new Date(dateString);
                    const year = d.getFullYear();
                    const month = String(d.getMonth() + 1).padStart(2, '0');
                    const day = String(d.getDate()).padStart(2, '0');
                    return `${year}/${month}/${day}`;
                }
            }));
        });
    </script>
    @endpush
</x-doctor-layout>