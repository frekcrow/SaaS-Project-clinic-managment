<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('تفاصيل الملف التشخيصي للمريض: ') }} {{ $medical_record->patient->name }}
            </h2>
            <div class="space-x-2 space-x-reverse">
                <button onclick="window.print()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    طباعة الروشتة
                </button>
                <a href="{{ route('medical_records.exportPdf', $medical_record) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    تصدير كـ PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('medical_records.update', $medical_record) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="diagnosis" class="block text-lg font-bold text-gray-800 border-b pb-2 mb-2">التشخيص</label>
                            <textarea id="diagnosis" name="diagnosis" rows="4" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>{{ $medical_record->diagnosis }}</textarea>
                        </div>

                        <div>
                            <label for="prescription" class="block text-lg font-bold text-gray-800 border-b pb-2 mb-2">الوصفة الطبية</label>
                            <textarea id="prescription" name="prescription" rows="4" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ $medical_record->prescription }}</textarea>
                        </div>

                        <div>
                            <label for="lab_tests_required" class="block text-lg font-bold text-gray-800 border-b pb-2 mb-2">التحاليل المطلوبة</label>
                            <textarea id="lab_tests_required" name="lab_tests_required" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ $medical_record->lab_tests_required }}</textarea>
                        </div>

                        @if($medical_record->attachments)
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-2">المرفقات</h3>
                                <ul class="list-disc list-inside">
                                    @if(isset($medical_record->attachments['lab_results']))
                                        <li><a href="{{ asset('storage/' . $medical_record->attachments['lab_results']) }}" target="_blank" class="text-blue-600 hover:underline">نتائج التحاليل</a></li>
                                    @endif
                                    @if(isset($medical_record->attachments['xrays']))
                                        <li><a href="{{ asset('storage/' . $medical_record->attachments['xrays']) }}" target="_blank" class="text-blue-600 hover:underline">الأشعة</a></li>
                                    @endif
                                    @if(isset($medical_record->attachments['diagnostic_images']))
                                        <li><a href="{{ asset('storage/' . $medical_record->attachments['diagnostic_images']) }}" target="_blank" class="text-blue-600 hover:underline">صور تشخيصية</a></li>
                                    @endif
                                </ul>
                            </div>
                        @endif

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
