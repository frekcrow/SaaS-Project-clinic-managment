<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('الملف الطبي للمريض: ') }} {{ $patient->name }}
            </h2>
            <a href="{{ route('medical_records.create', $patient) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                إنشاء ملف تشخيصي جديد
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($records->isEmpty())
                        <p class="text-gray-500">لا توجد زيارات سابقة.</p>
                    @else
                        <div class="space-y-6">
                            @foreach($records as $record)
                                <div class="border border-gray-200 rounded-lg p-4 shadow-sm">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-bold text-gray-800">
                                            تاريخ الزيارة: {{ $record->created_at->format('Y-m-d H:i') }}
                                        </h3>
                                        <a href="{{ route('medical_records.show', $record) }}" class="text-blue-600 hover:text-blue-900 underline">
                                            عرض التفاصيل
                                        </a>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2"><strong>التشخيص:</strong> {{ Str::limit($record->diagnosis, 100) }}</p>
                                    <p class="text-sm text-gray-600"><strong>الطبيب المعالج:</strong> {{ $record->doctor->name }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
