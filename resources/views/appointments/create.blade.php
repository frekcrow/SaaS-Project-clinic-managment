<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('إضافة موعد جديد') }}
        </h2>
    </x-slot>

    <div class="py-12" >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm dark:shadow-none sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('appointments.store') }}">
                        @csrf

                        <div x-data="patientAutocomplete()" class="space-y-4">
                            <!-- Patient Name Search and ID -->
                            <div class="mt-4 relative">
                                <x-input-label for="patient_name" :value="__('اسم المريض')" />
                                <x-text-input
                                    id="patient_name"
                                    name="patient_name"
                                    class="block mt-1 w-full"
                                    type="text"
                                    x-model="patient_name"
                                    @input="clearPatientId"
                                    @input.debounce.300ms="searchPatients"
                                    @click.away="showDropdown = false"
                                    @focus="if(patient_name.length > 0) showDropdown = true"
                                    required
                                    autofocus
                                    autocomplete="off"
                                />
                                <input type="hidden" name="patient_id" x-model="patient_id">
                                <x-input-error :messages="$errors->get('patient_id')" class="mt-2" />
                                <x-input-error :messages="$errors->get('patient_name')" class="mt-2" />

                                <div class="mt-4">
                                    <x-input-label for="phone" :value="__('رقم الهاتف')" />
                                    <x-text-input
                                        id="phone"
                                        name="phone"
                                        class="block mt-1 w-full"
                                        type="text"
                                        x-model="phone"
                                        @input="clearPatientId"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        required
                                        autocomplete="off"
                                    />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>

                                <!-- Dropdown -->
                                <div x-show="showDropdown && results.length > 0"
                                     class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg dark:shadow-none"
                                     style="display: none;">
                                    <ul class="max-h-60 overflow-auto">
                                        <template x-for="patient in results" :key="patient.id">
                                            <li @click="selectPatient(patient)"
                                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                                <span x-text="patient.name" class="block font-medium text-gray-900 dark:text-gray-100"></span>
                                                <span x-text="patient.phone" class="block text-sm text-gray-500"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Doctor -->
                        <div class="mt-4">
                            <x-input-label for="doctor_id" :value="__('الطبيب المعالج')" />
                            <select id="doctor_id" name="doctor_id" class="block mt-1 w-full border-gray-300 dark:border-gray-600 focus:border-indigo-500 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 rounded-md shadow-sm dark:shadow-none" required>
                                <option value="">{{ __('اختر الطبيب') }}</option>
                                @foreach($doctors as $doctor) <!-- Iterate over scoped doctors -->
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('doctor_id')" class="mt-2" />
                        </div>

                        <!-- Appointment Date and Time -->
                        <div class="mt-4 flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <x-input-label for="appointment_date" :value="__('تاريخ الموعد')" />
                                <x-text-input id="appointment_date" class="block mt-1 w-full text-left" dir="ltr" type="text" x-data="{}" x-init="flatpickr($el, {allowInput: true, disableMobile: true, dateFormat: 'Y-m-d'})" name="appointment_date" :value="old('appointment_date')" required />
                                <x-input-error :messages="$errors->get('appointment_date')" class="mt-2" />
                            </div>
                            <div class="flex-1">
                                <x-input-label for="appointment_time" :value="__('وقت الموعد')" />
                                <x-text-input id="appointment_time" class="block mt-1 w-full text-left" dir="ltr" type="time" name="appointment_time" :value="old('appointment_time')" required />
                                <x-input-error :messages="$errors->get('appointment_time')" class="mt-2" />
                            </div>
                        </div>

                        <div x-data="appointmentPricing({{ auth()->user()->default_consultation_price ?? 0 }}, {{ auth()->user()->default_session_price ?? 0 }})" class="mt-4 border-t pt-4 border-gray-100 dark:border-gray-700">
                                <div class="mb-4 space-y-2">
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('نوع الحجز') }}</span>
                                    <div class="flex flex-col gap-4">
                                        <div class="flex gap-6">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" x-model="isConsultation" @change="calculatePrice" class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm dark:shadow-none focus:ring-indigo-500 dark:bg-gray-900 dark:text-white">
                                                <span class="ml-2 mr-2 text-sm text-gray-600 dark:text-gray-400">{{ __('كشفية') }}</span>
                                            </label>
                                            @if(auth()->user()->has_sessions_system)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="is_session" value="1" x-model="isSession" @change="calculatePrice" class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm dark:shadow-none focus:ring-indigo-500 dark:bg-gray-900 dark:text-white">
                                                <span class="ml-2 mr-2 text-sm text-gray-600 dark:text-gray-400">{{ __('جلسة') }}</span>
                                            </label>
                                            @endif
                                        </div>

                                        @if(auth()->user()->has_sessions_system)
                                        <div x-show="isSession" class="mt-2" style="display: none;">
                                            <x-input-label for="session_type_id" :value="__('نوع الجلسة')" />
                                            <select id="session_type_id" name="session_type_id" class="block mt-1 w-full border-gray-300 dark:border-gray-600 focus:border-indigo-500 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 rounded-md shadow-sm dark:shadow-none">
                                                <option value="">{{ __('اختر نوع الجلسة') }}</option>
                                                @foreach($sessionTypes as $sessionType)
                                                    <option value="{{ $sessionType->id }}" {{ old('session_type_id') == $sessionType->id ? 'selected' : '' }}>
                                                        {{ $sessionType->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('session_type_id')" class="mt-2" />
                                        </div>
                                        @endif
                                    </div>
                                </div>

                            <!-- Price -->
                            <div class="mt-4">
                                <x-input-label for="price" :value="__('السعر / الرسوم')" />
                                <x-text-input id="price" class="block mt-1 w-full font-bold" type="number" step="0.01" name="price" x-model="price" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm dark:shadow-none hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('إلغاء') }}
                            </a>
                            <x-primary-button>
                                {{ __('حفظ') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('appointmentPricing', (defaultConsultation, defaultSession) => ({
                isConsultation: false,
                isSession: false,
                price: @json(old('price', '')),
                defaultConsultationPrice: defaultConsultation,
                defaultSessionPrice: defaultSession,

                calculatePrice() {
                    let total = 0;
                    let hasSelection = false;

                    if (this.isConsultation) {
                        total += Number(this.defaultConsultationPrice);
                        hasSelection = true;
                    }
                    if (this.isSession) {
                        total += Number(this.defaultSessionPrice);
                        hasSelection = true;
                    }

                    if (hasSelection) {
                         this.price = total;
                    } else {
                         this.price = '';
                    }
                }
            }));

            Alpine.data('patientAutocomplete', () => ({
                patient_name: @json(old('patient_name', '')),
                phone: @json(old('phone', '')),
                patient_id: @json(old('patient_id', '')),
                results: [],
                showDropdown: false,

                clearPatientId() {
                    this.patient_id = '';
                },

                async searchPatients() {
                    if (this.patient_name.length < 2) {
                        this.results = [];
                        this.showDropdown = false;
                        return;
                    }

                    try {
                        const response = await fetch(`/patients/search?q=${encodeURIComponent(this.patient_name)}`);
                        if (!response.ok) throw new Error('Network response was not ok');
                        this.results = await response.json();
                        this.showDropdown = this.results.length > 0;
                    } catch (error) {
                        console.error('Error fetching patients:', error);
                        this.results = [];
                        this.showDropdown = false;
                    }
                },

                selectPatient(patient) {
                    this.patient_name = patient.name;
                    this.phone = patient.phone || '';
                    this.patient_id = patient.id;
                    this.showDropdown = false;
                }
            }));
        });
    </script>
</x-app-layout>
