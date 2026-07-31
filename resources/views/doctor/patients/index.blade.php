<x-doctor-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-slate-800 leading-tight">
                {{ __('ملفات المرضى') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12" x-data="doctorPatientsGrid()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Search Bar -->
            <div class="mb-6">
                <div class="relative max-w-md">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" x-model="searchQuery" class="block w-full pl-3 pr-10 py-3 border border-gray-300 rounded-2xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500 sm:text-sm transition duration-150 ease-in-out shadow-sm" placeholder="ابحث عن مريض بالاسم...">
                </div>
            </div>

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" x-show="filteredPatients.length > 0">
                <template x-for="patient in filteredPatients" :key="patient.id">
                    <a :href="'/doctor/patients/' + patient.id" class="block group">
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] transition-all duration-300 relative overflow-hidden group-hover:-translate-y-1">

                            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-slate-100 to-transparent rounded-bl-full -z-10 transition-transform duration-300 group-hover:scale-110"></div>

                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="h-16 w-16 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center mb-4 text-2xl font-bold shadow-inner">
                                    <span x-text="patient.name.charAt(0)"></span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 mb-1" x-text="patient.name"></h3>
                                <p class="text-sm text-gray-500 flex items-center gap-1 justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span x-text="formatDate(patient.created_at)"></span>
                                </p>
                            </div>
                        </div>
                    </a>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredPatients.length === 0" x-cloak class="bg-white rounded-3xl p-12 border border-gray-100 shadow-sm flex flex-col items-center justify-center text-center">
                <div class="w-24 h-24 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-700 mb-2">لا يوجد مرضى</h3>
                <p class="text-gray-500 max-w-sm">لم يتم العثور على أي ملفات مرضى مطابقة لبحثك.</p>
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
                    return d.toLocaleDateString('ar-IQ', { year: 'numeric', month: 'long', day: 'numeric' });
                }
            }));
        });
    </script>
    @endpush
</x-doctor-layout>
