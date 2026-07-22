<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إضافة موعد جديد') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('appointments.store') }}">
                        @csrf

                        <div x-data="patientAutocomplete()" class="space-y-4">
                            <!-- Patient Name Search and ID -->
                            <div class="mt-4 relative">
                                <x-input-label for="patient_name" :value="__('اسم المريض')" />
                                <x-text-input
                                    id="patient_name"
                                    class="block mt-1 w-full"
                                    type="text"
                                    x-model="patientName"
                                    @input.debounce.300ms="searchPatients"
                                    @click.away="showDropdown = false"
                                    @focus="if(patientName.length > 0) showDropdown = true"
                                    required
                                    autofocus
                                    autocomplete="off"
                                />
                                <input type="hidden" name="patient_id" x-model="patient_id" required>
                                <x-input-error :messages="$errors->get('patient_id')" class="mt-2" />

                                <!-- Dropdown -->
                                <div x-show="showDropdown && results.length > 0"
                                     class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg"
                                     style="display: none;">
                                    <ul class="max-h-60 overflow-auto">
                                        <template x-for="patient in results" :key="patient.id">
                                            <li @click="selectPatient(patient)"
                                                class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                                <span x-text="patient.name" class="block font-medium text-gray-900"></span>
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
                            <select id="doctor_id" name="doctor_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
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
                        <div class="mt-4">
                            <x-input-label for="appointment_datetime" :value="__('تاريخ ووقت الموعد')" />
                            <x-text-input id="appointment_datetime" class="block mt-1 w-full" type="datetime-local" name="appointment_datetime" :value="old('appointment_datetime')" required />
                            <x-input-error :messages="$errors->get('appointment_datetime')" class="mt-2" />
                        </div>

                        <!-- Price -->
                        <div class="mt-4">
                            <x-input-label for="price" :value="__('السعر / الرسوم (اختياري)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price')" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
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
            Alpine.data('patientAutocomplete', () => ({
                patientName: '',
                patient_id: @json(old('patient_id', '')),
                results: [],
                showDropdown: false,

                async searchPatients() {
                    if (this.patientName.length < 2) {
                        this.results = [];
                        this.showDropdown = false;
                        return;
                    }

                    try {
                        const response = await fetch(`/patients/search?q=${encodeURIComponent(this.patientName)}`);
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
                    this.patientName = patient.name;
                    this.patient_id = patient.id;
                    this.showDropdown = false;
                }
            }));
        });
    </script>
</x-app-layout>
