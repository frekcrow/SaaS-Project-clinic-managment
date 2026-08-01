<x-doctor-layout>
    <x-slot name="header">
        الأدوية
    </x-slot>

    <div x-data="medicationsData()">
        <!-- Top Actions -->
        <div class="mb-6 flex justify-between items-center bg-white p-4 rounded-3xl shadow-sm border border-slate-100">
            <h2 class="text-lg font-bold text-slate-800">قائمة الأدوية</h2>
            <button @click="openModal()" class="flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-2xl transition-colors font-medium text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                إضافة دواء
            </button>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-teal-50 text-teal-800 border border-teal-200 px-4 py-3 rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Medications Grid -->
        @if($medications->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($medications as $medication)
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow relative group">
                        <!-- Actions -->
                        <div class="absolute top-4 left-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="editModal({{ $medication->toJson() }})" class="p-2 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-xl transition-colors" title="تعديل">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <form action="{{ route('doctor.medications.destroy', $medication) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الدواء؟');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors" title="حذف">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>

                        <!-- Info -->
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0 pr-2">
                                <h3 class="font-bold text-slate-800 text-lg truncate">{{ $medication->name }}</h3>
                                @if($medication->indications)
                                    <p class="text-sm text-slate-500 mt-1 line-clamp-2" title="{{ $medication->indications }}">{{ $medication->indications }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Details (Dosages & Times) -->
                        <div class="space-y-3 mt-4 border-t border-slate-50 pt-4">
                            @if(is_array($medication->dosages) && count($medication->dosages) > 0)
                                <div>
                                    <span class="text-xs font-semibold text-slate-500 block mb-2">الجرعات:</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($medication->dosages as $dosage)
                                            <span class="inline-flex px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-medium">{{ $dosage }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if(is_array($medication->usage_times) && count($medication->usage_times) > 0)
                                <div>
                                    <span class="text-xs font-semibold text-slate-500 block mb-2">أوقات الاستخدام:</span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($medication->usage_times as $time)
                                            <span class="inline-flex px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-medium">{{ $time }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-sm flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">لا توجد أدوية</h3>
                <p class="text-slate-500 mb-6 text-sm">لم تقم بإضافة أي أدوية بعد. ابدأ بإضافة الدواء الأول.</p>
                <button @click="openModal()" class="bg-teal-50 text-teal-700 hover:bg-teal-100 px-6 py-2 rounded-2xl transition-colors font-medium text-sm">
                    إضافة دواء جديد
                </button>
            </div>
        @endif

        <!-- Modal -->
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="showModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showModal" x-transition.scale.origin.bottom class="inline-block align-bottom bg-white rounded-3xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full">
                    <form :action="formAction" method="POST">
                        @csrf
                        <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">

                        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h3 class="text-lg leading-6 font-bold text-slate-800" id="modal-title" x-text="isEdit ? 'تعديل الدواء' : 'إضافة دواء جديد'"></h3>
                            <button type="button" @click="showModal = false" class="text-slate-400 hover:text-slate-500 hover:bg-slate-100 p-1.5 rounded-full transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="px-6 py-6 space-y-5">

                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">اسم الدواء <span class="text-red-500">*</span></label>
                                <input type="text" name="name" x-model="form.name" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 transition-all text-sm" placeholder="مثال: Paracetamol 500mg">
                            </div>

                            <!-- Indications -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">دواعي الاستعمال (اختياري)</label>
                                <textarea name="indications" x-model="form.indications" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 transition-all text-sm" placeholder="مثال: مسكن للآلام، خافض للحرارة"></textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <!-- Dosages Dynamic List -->
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <label class="block text-sm font-semibold text-slate-700">الجرعات</label>
                                        <button type="button" @click="addDosage()" class="text-xs text-teal-600 hover:text-teal-700 font-medium flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            إضافة
                                        </button>
                                    </div>
                                    <div class="space-y-2 max-h-48 overflow-y-auto pr-1 custom-scrollbar">
                                        <template x-for="(dosage, index) in form.dosages" :key="index">
                                            <div class="flex gap-2 relative">
                                                <input type="text" :name="'dosages['+index+']'" x-model="form.dosages[index]" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 transition-all" placeholder="مثال: 500mg">
                                                <button type="button" @click="removeDosage(index)" class="text-slate-400 hover:text-red-500 p-2 shrink-0">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                                </button>
                                            </div>
                                        </template>
                                        <template x-if="form.dosages.length === 0">
                                            <p class="text-xs text-slate-400">لم يتم إضافة جرعات</p>
                                        </template>
                                    </div>
                                </div>

                                <!-- Usage Times Dynamic List -->
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <label class="block text-sm font-semibold text-slate-700">أوقات الاستخدام</label>
                                        <button type="button" @click="addUsageTime()" class="text-xs text-indigo-600 hover:text-indigo-700 font-medium flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            إضافة
                                        </button>
                                    </div>
                                    <div class="space-y-2 max-h-48 overflow-y-auto pr-1 custom-scrollbar">
                                        <template x-for="(time, index) in form.usage_times" :key="index">
                                            <div class="flex gap-2 relative">
                                                <input type="text" :name="'usage_times['+index+']'" x-model="form.usage_times[index]" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all" placeholder="مثال: مرتين يومياً">
                                                <button type="button" @click="removeUsageTime(index)" class="text-slate-400 hover:text-red-500 p-2 shrink-0">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                                </button>
                                            </div>
                                        </template>
                                        <template x-if="form.usage_times.length === 0">
                                            <p class="text-xs text-slate-400">لم يتم إضافة أوقات</p>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3 rounded-b-3xl">
                            <button type="button" @click="showModal = false" class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 transition-colors">
                                إلغاء
                            </button>
                            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-teal-600 rounded-2xl hover:bg-teal-700 transition-colors">
                                حفظ الدواء
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('medicationsData', () => ({
                showModal: false,
                isEdit: false,
                formAction: '{{ route('doctor.medications.store') }}',
                form: {
                    id: null,
                    name: '',
                    indications: '',
                    dosages: [''],
                    usage_times: ['']
                },

                openModal() {
                    this.isEdit = false;
                    this.formAction = '{{ route('doctor.medications.store') }}';
                    this.form = {
                        id: null,
                        name: '',
                        indications: '',
                        dosages: [''],
                        usage_times: ['']
                    };
                    this.showModal = true;
                },

                editModal(medication) {
                    this.isEdit = true;
                    this.formAction = `/doctor/medications/${medication.id}`;
                    this.form = {
                        id: medication.id,
                        name: medication.name || '',
                        indications: medication.indications || '',
                        dosages: Array.isArray(medication.dosages) && medication.dosages.length > 0 ? [...medication.dosages] : [''],
                        usage_times: Array.isArray(medication.usage_times) && medication.usage_times.length > 0 ? [...medication.usage_times] : ['']
                    };
                    this.showModal = true;
                },

                addDosage() {
                    this.form.dosages.push('');
                },

                removeDosage(index) {
                    this.form.dosages.splice(index, 1);
                },

                addUsageTime() {
                    this.form.usage_times.push('');
                },

                removeUsageTime(index) {
                    this.form.usage_times.splice(index, 1);
                }
            }));
        });
    </script>
    @endpush
</x-doctor-layout>
