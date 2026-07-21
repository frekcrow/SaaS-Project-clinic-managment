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
                    <form method="POST" action="{{ route('patients.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">الاسم الكامل</label>
                                <input id="name" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="name" required autofocus />
                            </div>

                            <!-- DOB -->
                            <div>
                                <label for="dob" class="block font-medium text-sm text-gray-700">تاريخ الميلاد</label>
                                <input id="dob" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="date" name="dob" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block font-medium text-sm text-gray-700">رقم الهاتف</label>
                                <input id="phone" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="phone" />
                            </div>

                            <!-- Doctor Name -->
                            <div>
                                <label for="doctor_id" class="block font-medium text-sm text-gray-700">الطبيب المعالج</label>
                                <select id="doctor_id" name="doctor_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">اختر طبيباً</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Allergies -->
                            <div>
                                <label for="allergies" class="block font-medium text-sm text-gray-700">الحساسية</label>
                                <textarea id="allergies" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" name="allergies"></textarea>
                            </div>

                            <!-- Chronic Diseases -->
                            <div>
                                <label for="chronic_diseases" class="block font-medium text-sm text-gray-700">الأمراض المزمنة</label>
                                <textarea id="chronic_diseases" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" name="chronic_diseases"></textarea>
                            </div>

                            <!-- Regular Medications -->
                            <div>
                                <label for="regular_medications" class="block font-medium text-sm text-gray-700">الأدوية المنتظمة</label>
                                <textarea id="regular_medications" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" name="regular_medications"></textarea>
                            </div>

                            <!-- Reason for Visit -->
                            <div>
                                <label for="reason_for_visit" class="block font-medium text-sm text-gray-700">سبب الزيارة</label>
                                <textarea id="reason_for_visit" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" name="reason_for_visit"></textarea>
                            </div>

                            <!-- Onset of Symptoms -->
                            <div>
                                <label for="onset_of_symptoms" class="block font-medium text-sm text-gray-700">بداية الأعراض</label>
                                <textarea id="onset_of_symptoms" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" name="onset_of_symptoms"></textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                حفظ البيانات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
