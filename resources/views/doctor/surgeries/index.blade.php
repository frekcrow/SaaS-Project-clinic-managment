<x-doctor-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-slate-800 leading-tight">
                {{ __('العمليات') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12" x-data="doctorSurgeriesGrid()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Bar -->
            <div class="mb-6">
                <div class="relative max-w-md">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" x-model="searchQuery" class="block w-full pl-3 pr-10 py-3 border border-gray-300 rounded-2xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500 sm:text-sm transition duration-150 ease-in-out shadow-sm" placeholder="{{ __('ابحث عن مريض بالاسم') }}...">
                </div>
            </div>

            <!-- Session Status Message -->
            @if (session('success'))
                <div class="mb-4 bg-teal-50 border border-teal-200 text-teal-700 px-4 py-3 rounded-xl relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" x-show="filteredSurgeries.length > 0">
                <template x-for="surgery in filteredSurgeries" :key="surgery.id">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] overflow-hidden transition-all duration-300" x-data="{ expanded: false }">
                        <!-- Card Header (Collapsed State) -->
                        <div class="p-6 cursor-pointer hover:bg-slate-50 transition-colors" @click="expanded = !expanded">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800 mb-1" x-text="surgery.patient ? surgery.patient.name : '{{ __('مريض غير معروف') }}'"></h3>
                                    <p class="text-sm text-gray-500 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span x-text="formatDate(surgery.surgery_date)"></span>
                                    </p>
                                </div>
                                <div class="text-slate-400 transform transition-transform duration-300" :class="{ 'rotate-180': expanded }">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body (Expanded Form) -->
                        <div x-show="expanded" x-collapse x-cloak class="border-t border-gray-100 bg-slate-50/50 p-6">
                            <form :action="`/doctor/surgeries/${surgery.id}`" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Hospital Name -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('المستشفى') }}</label>
                                        <input type="text" name="hospital_name" :value="surgery.hospital_name" required class="w-full border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                                    </div>

                                    <!-- Surgeon Name -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('الجراح') }}</label>
                                        <input type="text" name="surgeon_name" :value="surgery.surgeon_name" required class="w-full border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                                    </div>

                                    <!-- Disease Name -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('التشخيص') }} / {{ __('المرض') }}</label>
                                        <input type="text" name="disease_name" :value="surgery.disease_name" required class="w-full border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                                    </div>

                                    <!-- Assistant Name -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('المساعد') }}</label>
                                        <input type="text" name="assistant_name" :value="surgery.assistant_name" class="w-full border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                                    </div>

                                    <!-- Anesthesiologist Name -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('طبيب التخدير') }}</label>
                                        <input type="text" name="anesthesiologist_name" :value="surgery.anesthesiologist_name" class="w-full border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                                    </div>

                                    <!-- Anesthesia Type -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('نوع التخدير') }}</label>
                                        <select name="anesthesia_type" required class="w-full border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 sm:text-sm ps-3.5 pe-8">
                                            <option value="{{ __('تخدير عام') }}" :selected="surgery.anesthesia_type === '{{ __('تخدير عام') }}'">{{ __('تخدير عام') }}</option>
                                            <option value="{{ __('تخدير موضعي') }}" :selected="surgery.anesthesia_type === '{{ __('تخدير موضعي') }}'">{{ __('تخدير موضعي') }}</option>
                                            <option value="{{ __('تخدير قطني') }}" :selected="surgery.anesthesia_type === '{{ __('تخدير قطني') }}'">{{ __('تخدير قطني') }}</option>
                                            <option value="{{ __('أخرى') }}" :selected="surgery.anesthesia_type === '{{ __('أخرى') }}'">{{ __('أخرى') }}</option>
                                        </select>
                                    </div>

                                    <!-- Cost -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('التكلفة') }}</label>
                                        <input type="number" step="0.01" name="cost" :value="surgery.cost" required class="w-full border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                                    </div>
                                </div>

                                <!-- Shared Notes -->
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('ملاحظات مشتركة') }}</label>
                                    <textarea name="notes" rows="2" class="w-full border-gray-300 rounded-xl focus:ring-teal-500 focus:border-teal-500 sm:text-sm" x-text="surgery.notes"></textarea>
                                </div>

                                <!-- Doctor Private Notes -->
                                <div class="mt-4 p-4 bg-teal-50/50 rounded-xl border border-teal-100">
                                    <label class="block text-sm font-bold text-teal-800 mb-1 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        {{ __('ملاحظات الطبيب الخاصة') }} ({{ __('مخفية عن السكرتارية') }})
                                    </label>
                                    <textarea name="doctor_notes" rows="3" class="w-full border-teal-200 bg-white rounded-xl focus:ring-teal-500 focus:border-teal-500 sm:text-sm" placeholder="{{ __('أدخل أي ملاحظات خاصة بك هنا') }}..." x-text="surgery.doctor_notes"></textarea>
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-slate-800 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 focus:bg-slate-700 active:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('حفظ التعديلات') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredSurgeries.length === 0" x-cloak class="bg-white rounded-3xl p-12 border border-gray-100 shadow-sm flex flex-col items-center justify-center text-center">
                <div class="w-24 h-24 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-700 mb-2">{{ __('لا توجد عمليات') }}</h3>
                <p class="text-gray-500 max-w-sm">{{ __('لم يتم العثور على أي عمليات مطابقة لبحثك') }}.</p>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('doctorSurgeriesGrid', () => ({
                searchQuery: '',
                surgeries: @json($surgeries),

                get filteredSurgeries() {
                    if (this.searchQuery === '') {
                        return this.surgeries;
                    }
                    const q = this.searchQuery.toLowerCase();
                    return this.surgeries.filter(s =>
                        (s.patient && s.patient.name.toLowerCase().includes(q))
                    );
                },

                formatDate(dateString) {
                    if (!dateString) return '';
                    const d = new Date(dateString);
                    const year = d.getFullYear();
                    const month = String(d.getMonth() + 1).padStart(2, '0');
                    const day = String(d.getDate()).padStart(2, '0');
                    return `{{ __('موعد العملية') }} : ${year}/${month}/${day}`;
                }
            }));
        });
    </script>
    @endpush
</x-doctor-layout>