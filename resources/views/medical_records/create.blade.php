<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إنشاء ملف تشخيصي جديد للمريض: ') }} {{ $patient->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('medical_records.store', $patient) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">
                            <!-- Diagnosis -->
                            <div>
                                <label for="diagnosis" class="block font-medium text-sm text-gray-700">التشخيص</label>
                                <textarea id="diagnosis" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" name="diagnosis" required autofocus rows="4"></textarea>
                            </div>

                            <!-- Prescription -->
                            <div>
                                <label for="prescription" class="block font-medium text-sm text-gray-700">الوصفة الطبية (الروشتة)</label>
                                <textarea id="prescription" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" name="prescription" rows="4"></textarea>
                            </div>

                            <!-- Lab Tests Required -->
                            <div>
                                <label for="lab_tests_required" class="block font-medium text-sm text-gray-700">التحاليل المطلوبة</label>
                                <textarea id="lab_tests_required" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" name="lab_tests_required" rows="3"></textarea>
                            </div>

                            <!-- Attachments -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="lab_results" class="block font-medium text-sm text-gray-700">نتائج التحاليل (مرفق)</label>
                                    <input id="lab_results" type="file" class="block mt-1 w-full" name="lab_results" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                                <div>
                                    <label for="xrays" class="block font-medium text-sm text-gray-700">الأشعة (مرفق)</label>
                                    <input id="xrays" type="file" class="block mt-1 w-full" name="xrays" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                                <div>
                                    <label for="diagnostic_images" class="block font-medium text-sm text-gray-700">صور تشخيصية أخرى (مرفق)</label>
                                    <input id="diagnostic_images" type="file" class="block mt-1 w-full" name="diagnostic_images" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                حفظ الملف التشخيصي
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
