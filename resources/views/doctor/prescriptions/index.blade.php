<x-doctor-layout>
    <x-slot name="header">
        {{ __('تهيئة الوصفات الطبية') }}
    </x-slot>

    <div x-data="prescriptionSetup()" class="max-w-7xl mx-auto pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Panel (Controls & Settings) -->
            <div class="lg:col-span-1 print:hidden space-y-6">
                <!-- Settings Form -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ __('إعدادات قالب الوصفة') }}
                    </h2>
                    <form action="{{ route('doctor.prescriptions.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('اسم العيادة') }}</label>
                            <input type="text" name="clinic_name" value="{{ old('clinic_name', $settings->clinic_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('اسم الطبيب') }}</label>
                            <input type="text" name="doctor_name" value="{{ old('doctor_name', $settings->doctor_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('الشعار الأول') }} ({{ __('اليمين') }})</label>
                            <input type="file" name="logo_1" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition-colors">
                            @if($settings->logo_1_path)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($settings->logo_1_path) }}" alt="Logo 1" class="h-12 object-contain rounded">
                                </div>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('الشعار الثاني') }} ({{ __('اليسار - اختياري') }})</label>
                            <input type="file" name="logo_2" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 transition-colors">
                            @if($settings->logo_2_path)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($settings->logo_2_path) }}" alt="Logo 2" class="h-12 object-contain rounded">
                                </div>
                            @endif
                        </div>
                        <button type="submit" class="w-full bg-slate-900 text-white rounded-xl px-4 py-2 text-sm font-medium hover:bg-slate-800 transition-colors">
                            {{ __('حفظ الإعدادات') }}
                        </button>
                    </form>
                </div>

                <!-- Prescription Data Entry -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        {{ __('بيانات الوصفة') }}
                    </h2>
                    <div class="space-y-4">
                        <!-- Patient Selection -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('المريض') }} ({{ __('مواعيد اليوم') }})</label>
                            <select x-model="selectedAppointmentId" @change="updatePatientData" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                <option value="">-- {{ __('اختر مريض') }} --</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" data-patient="{{ $patient->name }}" data-date="{{ today()->format('Y/m/d') }}" data-booking="{{ $patient->id }}">
                                        {{ $patient->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Manual Override for Patient Details -->
                        <div x-show="selectedAppointmentId" x-collapse>
                            <div class="p-3 bg-slate-50 rounded-xl space-y-3 mt-2 border border-slate-100">
                                <div>
                                    <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('اسم المريض') }}</label>
                                    <input type="text" x-model="patientName" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('رقم الحجز') }}</label>
                                        <input type="text" x-model="bookingNumber" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('التاريخ') }}</label>
                                        <input type="text" x-model="bookingDate" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm" dir="ltr" class="text-left">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Medication Selection -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('إضافة دواء') }}</label>
                            <div class="flex gap-2">
                                <select x-model="selectedMedicationId" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                    <option value="">-- {{ __('اختر دواء') }} --</option>
                                    @foreach($medications as $med)
                                        <option value="{{ $med->id }}" data-name="{{ $med->name }}" data-generic="{{ $med->generic_name }}" data-type="{{ $med->medication_type }}">
                                            {{ $med->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button @click="addMedication()" type="button" class="bg-teal-600 text-white rounded-xl px-4 py-2 text-sm font-medium hover:bg-teal-700 transition-colors flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel (Digital A4 Paper) -->
            <div class="lg:col-span-2">
                <div class="sticky top-6">
                    <!-- Action Bar -->
                    <div class="flex justify-between items-center mb-4 print:hidden">
                        <h2 class="text-xl font-bold text-slate-800">{{ __('معاينة الوصفة') }}</h2>
                        <button onclick="window.print()" class="bg-indigo-600 text-white rounded-xl px-5 py-2.5 text-sm font-bold hover:bg-indigo-700 transition-colors flex items-center gap-2 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            {{ __('طباعة الوصفة') }}
                        </button>
                    </div>

                    <!-- The A4 Canvas -->
                    <!-- We use aspect-[1/1.414] for A4 proportions on screen, but remove bounds on print -->
                    <div class="bg-white rounded-lg shadow-xl print:shadow-none w-full max-w-[800px] mx-auto overflow-hidden flex flex-col relative aspect-[1/1.414] print:aspect-auto print:w-full print:h-full print:block">

                        <!-- Header -->
                        <div class="flex justify-between items-start p-8 border-b-2 border-slate-800 print:border-black">
                            <!-- Logo 1 (Right) -->
                            <div class="w-32 flex flex-col items-center">
                                @if($settings->logo_1_path)
                                    <img src="{{ Storage::url($settings->logo_1_path) }}" alt="Logo" class="h-24 object-contain">
                                @endif
                            </div>

                            <!-- Center Info -->
                            <div class="flex-1 flex flex-col items-center justify-center text-center px-4">
                                <h1 class="text-3xl font-extrabold text-slate-900 print:text-black tracking-tight" style="font-family: 'Tajawal', sans-serif;">{{ $settings->clinic_name }}</h1>
                                <h2 class="text-xl font-bold text-slate-700 print:text-black mt-2">{{ __('د') }}. {{ $settings->doctor_name }}</h2>
                            </div>

                            <!-- Logo 2 (Left) -->
                            <div class="w-32 flex flex-col items-center">
                                @if($settings->logo_2_path)
                                    <img src="{{ Storage::url($settings->logo_2_path) }}" alt="Logo" class="h-24 object-contain">
                                @endif
                            </div>
                        </div>

                        <!-- Patient Info Bar -->
                        <div class="bg-slate-50 print:bg-transparent border-b border-slate-200 print:border-black py-3 px-8 flex justify-between items-center text-sm font-semibold">
                            <div class="flex items-center gap-2 text-slate-800 print:text-black">
                                <span class="text-slate-500 print:text-gray-600">{{ __('المريض') }}:</span>
                                <span x-text="patientName || '...................................'"></span>
                            </div>
                            <div class="flex items-center gap-6">
                                <div class="flex items-center gap-2 text-slate-800 print:text-black">
                                    <span class="text-slate-500 print:text-gray-600">{{ __('رقم الحجز') }}:</span>
                                    <span x-text="bookingNumber || '.........'" dir="ltr"></span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-800 print:text-black">
                                    <span class="text-slate-500 print:text-gray-600">{{ __('التاريخ') }}:</span>
                                    <span x-text="bookingDate || '{{ today()->format('Y/m/d') }}'" dir="ltr"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Body (Medications) -->
                        <div class="flex-1 p-8">
                            <div class="mb-4">
                                <svg class="w-10 h-10 text-slate-800 print:text-black" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.5 4C15.567 4 14 5.567 14 7.5c0 1.706 1.218 3.125 2.839 3.447L14.975 14H19v2h-5c-1.103 0-2-.897-2-2v-1.171l2.459-3.935C13.064 8.647 12 7.189 12 5.5 12 2.467 14.467 0 17.5 0S23 2.467 23 5.5c0 2.223-1.326 4.14-3.238 5.048L21 13v3h-2v-1.78l-1.077-2.155C18.665 11.83 21 9.92 21 7.5 21 5.567 19.433 4 17.5 4zm-7 8.5C10.5 10.015 8.485 8 6 8S1.5 10.015 1.5 12.5 3.515 17 6 17s4.5-2.015 4.5-4.5zM6 10c1.378 0 2.5 1.122 2.5 2.5S7.378 15 6 15s-2.5-1.122-2.5-2.5S4.622 10 6 10zm0 1c-.827 0-1.5.673-1.5 1.5S5.173 14 6 14s1.5-.673 1.5-1.5S6.827 11 6 11z"/>
                                </svg>
                            </div>

                            <div class="space-y-6 min-h-[300px]">
                                <!-- Empty State -->
                                <div x-show="addedMedications.length === 0" class="text-center text-slate-400 print:hidden mt-20">
                                    {{ __('قم بإضافة أدوية من القائمة الجانبية') }}
                                </div>

                                <!-- Medication List -->
                                <template x-for="(med, index) in addedMedications" :key="index">
                                    <div class="relative group border-b border-slate-100 print:border-transparent pb-4 last:border-0 hover:bg-slate-50 print:hover:bg-transparent -mx-4 px-4 rounded-xl transition-colors">
                                        <!-- Delete Button (Hidden on Print) -->
                                        <button @click="removeMedication(index)" class="absolute left-2 top-2 text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity print:hidden">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>

                                        <div class="flex items-start gap-4">
                                            <div class="text-lg font-bold text-slate-800 print:text-black mt-1" x-text="(index + 1) + ' -'"></div>
                                            <div class="flex-1">
                                                <div class="text-xl font-bold text-slate-900 print:text-black flex items-center gap-2">
                                                    <span x-text="med.name"></span>
                                                    <span x-show="med.type" class="text-xs px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full print:border print:border-black print:bg-transparent" x-text="med.type"></span>
                                                </div>
                                                <div x-show="med.generic" class="text-sm text-slate-500 print:text-gray-700 mb-2 italic" x-text="med.generic"></div>

                                                <!-- Editable Dosage and Usage -->
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                                    <div>
                                                        <label class="block text-xs font-semibold text-slate-400 print:hidden mb-1">{{ __('الجرعة') }} (Dosage)</label>
                                                        <input type="text" x-model="med.dosage" placeholder="{{ __('مثال') }}: {{ __('حبة واحدة') }}" class="w-full bg-transparent border-b border-slate-200 print:border-transparent focus:border-teal-500 focus:outline-none focus:ring-0 text-slate-800 print:text-black text-sm px-0 py-1 transition-colors font-medium">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-semibold text-slate-400 print:hidden mb-1">{{ __('وقت الاستخدام') }} (Usage)</label>
                                                        <input type="text" x-model="med.usage" placeholder="{{ __('مثال') }}: {{ __('مرتين يومياً بعد الأكل') }}" class="w-full bg-transparent border-b border-slate-200 print:border-transparent focus:border-teal-500 focus:outline-none focus:ring-0 text-slate-800 print:text-black text-sm px-0 py-1 transition-colors font-medium">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Doctor's Notes -->
                            <div class="mt-8 border-t border-slate-200 print:border-black pt-4">
                                <label class="block text-sm font-bold text-slate-700 print:hidden mb-2">{{ __('ملاحظات الطبيب') }}:</label>
                                <textarea rows="4" class="w-full bg-slate-50 print:bg-transparent border border-slate-200 print:border-0 rounded-xl p-4 text-slate-800 print:text-black focus:ring-2 focus:ring-teal-500 focus:border-teal-500 resize-none font-medium text-sm leading-relaxed" placeholder="{{ __('اكتب ملاحظاتك هنا') }}..."></textarea>
                            </div>
                        </div>

                        <!-- Footer Branding -->
                        <div class="p-6 bg-slate-50 print:bg-transparent mt-auto text-center border-t border-slate-200 print:border-black">
                            <p class="text-xs font-bold text-slate-400 print:text-gray-500 tracking-wider">
                                Powered by <span class="text-teal-600 print:text-black">Atlas</span> EHR
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('prescriptionSetup', () => ({
                selectedAppointmentId: '',
                patientName: '',
                bookingNumber: '',
                bookingDate: '{{ today()->format('Y/m/d') }}',

                selectedMedicationId: '',
                addedMedications: [],

                updatePatientData() {
                    if (this.selectedAppointmentId) {
                        const select = document.querySelector('select[x-model="selectedAppointmentId"]');
                        const option = select.options[select.selectedIndex];
                        this.patientName = option.dataset.patient;
                        this.bookingNumber = option.dataset.booking;
                        this.bookingDate = option.dataset.date;
                    } else {
                        this.patientName = '';
                        this.bookingNumber = '';
                        this.bookingDate = '{{ today()->format('Y/m/d') }}';
                    }
                },

                addMedication() {
                    if (!this.selectedMedicationId) return;

                    const select = document.querySelector('select[x-model="selectedMedicationId"]');
                    const option = select.options[select.selectedIndex];

                    this.addedMedications.push({
                        id: this.selectedMedicationId,
                        name: option.dataset.name,
                        generic: option.dataset.generic,
                        type: option.dataset.type,
                        dosage: '',
                        usage: ''
                    });

                    // Reset selection
                    this.selectedMedicationId = '';
                },

                removeMedication(index) {
                    this.addedMedications.splice(index, 1);
                }
            }));
        });
    </script>
    @endpush
</x-doctor-layout>
