<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إضافة مريض جديد') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('patients.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <x-input-label for="name" :value="__('الاسم الكامل')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <x-input-label for="phone" :value="__('رقم الهاتف')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <!-- DOB -->
                            <div>
                                <x-input-label for="dob" :value="__('تاريخ الميلاد')" />
                                <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob')" />
                                <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                            </div>

                            <!-- Doctor Name -->
                            <div>
                                <x-input-label for="doctor_id" :value="__('الطبيب المعالج')" />
                                <select id="doctor_id" name="doctor_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">{{ __('اختر الطبيب') }}</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('doctor_id')" class="mt-2" />
                            </div>

                            <!-- Reason for Visit -->
                            <div class="md:col-span-2">
                                <x-input-label for="reason_for_visit" :value="__('سبب الزيارة')" />
                                <textarea id="reason_for_visit" name="reason_for_visit" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3">{{ old('reason_for_visit') }}</textarea>
                                <x-input-error :messages="$errors->get('reason_for_visit')" class="mt-2" />
                            </div>

                            <!-- Onset of Symptoms -->
                            <div class="md:col-span-2">
                                <x-input-label for="symptoms_onset" :value="__('بداية ظهور الأعراض')" />
                                <x-text-input id="symptoms_onset" class="block mt-1 w-full" type="text" name="symptoms_onset" :value="old('symptoms_onset')" />
                                <x-input-error :messages="$errors->get('symptoms_onset')" class="mt-2" />
                            </div>

                            <!-- Allergies -->
                            <div class="md:col-span-2">
                                <x-input-label for="allergies" :value="__('الحساسية (إن وجدت)')" />
                                <textarea id="allergies" name="allergies" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="2">{{ old('allergies') }}</textarea>
                                <x-input-error :messages="$errors->get('allergies')" class="mt-2" />
                            </div>

                            <!-- Chronic Diseases -->
                            <div class="md:col-span-2">
                                <x-input-label for="chronic_diseases" :value="__('الأمراض المزمنة (إن وجدت)')" />
                                <textarea id="chronic_diseases" name="chronic_diseases" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="2">{{ old('chronic_diseases') }}</textarea>
                                <x-input-error :messages="$errors->get('chronic_diseases')" class="mt-2" />
                            </div>

                            <!-- Regular Medications -->
                            <div class="md:col-span-2">
                                <x-input-label for="regular_medications" :value="__('الأدوية المنتظمة (إن وجدت)')" />
                                <textarea id="regular_medications" name="regular_medications" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="2">{{ old('regular_medications') }}</textarea>
                                <x-input-error :messages="$errors->get('regular_medications')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('patients.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mx-4">
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
</x-app-layout>
