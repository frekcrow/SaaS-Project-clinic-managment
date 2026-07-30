<x-doctor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $greeting ?? __('Doctor Dashboard Workspace') }} - هل أنت مستعد ليومك؟
        </h2>
    </x-slot>

    <div class="py-12 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-800">{{ $greeting ?? __('مرحباً د. :name', ['name' => auth()->user()->name]) }}</h1>
                <p class="text-slate-500 mt-1">هنا ملخص لجدولك اليوم، نتمنى لك يوماً سعيداً وناجحاً.</p>
            </div>

            @php
                $pendingAppt = $todaysAppointments->where('status', 'pending')->first();
                $pendingCount = $todaysAppointments->where('status', 'pending')->count();
            @endphp

            <!-- 1. The Live Patient Queue Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative">
                <!-- Top accent line -->
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-teal-400 to-blue-500"></div>

                <div class="p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 rounded-full bg-teal-50 border-4 border-white shadow-sm flex items-center justify-center flex-shrink-0 relative">
                            <svg class="w-10 h-10 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            @if($pendingAppt)
                                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-black text-white rounded-full flex items-center justify-center font-bold text-sm shadow-sm border-2 border-white">
                                    #{{ $pendingAppt->queue_number }}
                                </div>
                            @endif
                        </div>

                        <div>
                            <div class="text-sm font-bold tracking-wide text-teal-600 mb-1 uppercase flex items-center gap-2">
                                <span class="relative flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-teal-500"></span>
                                </span>
                                المراجع القادم (الانتظار)
                            </div>
                            <h2 class="text-3xl font-black text-slate-800 mb-2">
                                {{ $pendingAppt ? ($pendingAppt->patient_name ?? ($pendingAppt->patient ? $pendingAppt->patient->name : '-')) : 'لا يوجد مراجعين في الانتظار' }}
                            </h2>
                            @if($pendingAppt && $pendingAppt->patient)
                                <a href="{{ route('patients.show', $pendingAppt->patient->id) }}" class="inline-flex items-center text-sm text-slate-500 hover:text-teal-600 transition-colors gap-1 group">
                                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    عرض الملف الطبي الكامل
                                </a>
                            @endif
                        </div>
                    </div>

                    @if($pendingAppt)
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <form method="POST" action="{{ route('appointments.update_status', $pendingAppt) }}" class="w-full md:w-auto">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="in_progress">
                                <button type="submit" class="w-full md:w-auto px-8 py-3 bg-black text-white rounded-xl font-bold shadow-sm hover:bg-neutral-800 hover:shadow-md transition-all flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    بدء الجلسة (قبول)
                                </button>
                            </form>

                            <form method="POST" action="{{ route('appointments.update_status', $pendingAppt) }}" class="w-full md:w-auto">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="w-full md:w-auto px-6 py-3 bg-white text-red-600 border border-slate-200 rounded-xl font-bold shadow-sm hover:bg-red-50 hover:border-red-100 transition-all">
                                    تخطي (رفض)
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Active Sessions Display (If any are in_progress) -->
                @php
                    $inProgressAppt = $todaysAppointments->where('status', 'in_progress')->first();
                @endphp

                @if($inProgressAppt)
                    <div class="border-t border-slate-100 bg-slate-50/50 p-6 flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-blue-600 mb-1">جلسة نشطة حالياً</div>
                                <div class="font-semibold text-slate-800">{{ $inProgressAppt->patient_name ?? ($inProgressAppt->patient ? $inProgressAppt->patient->name : '-') }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div x-data="liveTimer('{{ $inProgressAppt->session_started_at ? $inProgressAppt->session_started_at->toIso8601String() : now()->toIso8601String() }}')" class="text-blue-600 font-mono font-bold text-xl flex items-center gap-2 bg-white px-4 py-2 rounded-xl border border-blue-100 shadow-sm" dir="ltr">
                                <span x-text="timeString"></span>
                                <svg class="w-5 h-5 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>

                            <form method="POST" action="{{ route('appointments.update_status', $inProgressAppt) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold shadow-sm hover:bg-blue-700 transition-colors">
                                    إنهاء الجلسة
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <!-- 2. Quick Stats Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                <!-- Card 1 (Today's Surgeries) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center justify-between group hover:shadow-md transition-shadow relative overflow-hidden">
                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10m-5-4v4m0-4V7a2 2 0 00-2-2H8a2 2 0 00-2 2v10h8V7m-4-2V3a1 1 0 00-1-1H9a1 1 0 00-1 1v2"></path></svg>
                            </div>
                            <h3 class="text-slate-500 font-medium mb-1">عمليات اليوم</h3>
                            <div class="text-4xl font-black text-slate-800">{{ $pendingSurgeries ?? 0 }}</div>
                        </div>

                        <div class="mt-6" x-data="{ showAddModal: false }">
                            <button @click="showAddModal = true" class="text-sm font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                إضافة عملية
                            </button>

                            <!-- Add Surgery Modal -->
                            <div x-show="showAddModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div x-show="showAddModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                    <div x-show="showAddModal" x-transition class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                                        <form method="POST" action="{{ route('surgeries.store') }}">
                                            @csrf
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-right w-full">
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                            {{ __('إضافة عملية جديدة') }}
                                                        </h3>
                                                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-right">
                                                            <!-- Patient -->
                                                            <div>
                                                                <x-input-label for="patient_id" :value="__('اسم المريض')" />
                                                                <select id="patient_id" name="patient_id" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full" required>
                                                                    <option value="" disabled selected>{{ __('اختر المريض') }}</option>
                                                                    @foreach($patients ?? [] as $patient)
                                                                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <!-- Surgery Type -->
                                                            <div>
                                                                <x-input-label for="surgery_type_id" :value="__('نوع العملية')" />
                                                                <select id="surgery_type_id" name="surgery_type_id" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full" required>
                                                                    <option value="" disabled selected>{{ __('اختر نوع العملية') }}</option>
                                                                    @foreach($surgeryTypes ?? [] as $type)
                                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <!-- Surgery Date -->
                                                            <div>
                                                                <x-input-label for="surgery_date" :value="__('تاريخ العملية')" />
                                                                <input type="text" id="surgery_date" name="surgery_date" x-init="flatpickr($el, {allowInput: true, disableMobile: true, dateFormat: 'Y-m-d', defaultDate: 'today'})" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full text-left" dir="ltr" required>
                                                            </div>

                                                            <!-- Hospital Name -->
                                                            <div>
                                                                <x-input-label for="hospital_name" :value="__('اسم المستشفى')" />
                                                                <x-text-input id="hospital_name" name="hospital_name" type="text" class="mt-1 block w-full" required />
                                                            </div>

                                                            <!-- Surgeon Name -->
                                                            <div>
                                                                <x-input-label for="surgeon_name" :value="__('اسم الجراح')" />
                                                                <x-text-input id="surgeon_name" name="surgeon_name" type="text" class="mt-1 block w-full" required value="{{ auth()->user()->name }}" />
                                                            </div>

                                                            <!-- Disease Name -->
                                                            <div>
                                                                <x-input-label for="disease_name" :value="__('اسم المرض / التشخيص')" />
                                                                <x-text-input id="disease_name" name="disease_name" type="text" class="mt-1 block w-full" required />
                                                            </div>

                                                            <!-- Assistant Name -->
                                                            <div>
                                                                <x-input-label for="assistant_name" :value="__('اسم المساعد')" />
                                                                <x-text-input id="assistant_name" name="assistant_name" type="text" class="mt-1 block w-full" />
                                                            </div>

                                                            <!-- Anesthesiologist Name -->
                                                            <div>
                                                                <x-input-label for="anesthesiologist_name" :value="__('اسم طبيب التخدير')" />
                                                                <x-text-input id="anesthesiologist_name" name="anesthesiologist_name" type="text" class="mt-1 block w-full" />
                                                            </div>

                                                            <!-- Anesthesia Type -->
                                                            <div>
                                                                <x-input-label for="anesthesia_type" :value="__('نوع التخدير')" />
                                                                <select id="anesthesia_type" name="anesthesia_type" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full" required>
                                                                    <option value="" disabled selected>{{ __('اختر نوع التخدير') }}</option>
                                                                    <option value="تخدير عام">{{ __('تخدير عام') }}</option>
                                                                    <option value="تخدير موضعي">{{ __('تخدير موضعي') }}</option>
                                                                    <option value="تخدير قطني">{{ __('تخدير قطني') }}</option>
                                                                    <option value="أخرى">{{ __('أخرى') }}</option>
                                                                </select>
                                                            </div>

                                                            <!-- Cost -->
                                                            <div>
                                                                <x-input-label for="cost" :value="__('التكلفة')" />
                                                                <div class="relative mt-1">
                                                                    <x-text-input id="cost" name="cost" type="number" step="0.01" min="0" class="block w-full pl-10" required />
                                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                        <span class="text-gray-500 sm:text-sm">د.ع</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="md:col-span-2">
                                                                <x-input-label for="notes" :value="__('ملاحظات')" />
                                                                <textarea id="notes" name="notes" rows="3" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 block mt-1 w-full"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200">
                                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                    {{ __('إضافة العملية') }}
                                                </button>
                                                <button type="button" @click="showAddModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                    {{ __('إلغاء') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -left-6 -bottom-6 w-32 h-32 bg-indigo-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                </div>

                <!-- Card 2 (Pending Appointments) -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center justify-between group hover:shadow-md transition-shadow relative overflow-hidden">
                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-slate-500 font-medium mb-1">المراجعين في الانتظار</h3>
                            <div class="text-4xl font-black text-slate-800">{{ $pendingCount }}</div>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('appointments.index') }}" class="text-sm font-bold text-orange-600 bg-orange-50 hover:bg-orange-100 px-4 py-2 rounded-lg transition-colors inline-flex items-center gap-2">
                                عرض القائمة كاملة
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </a>
                        </div>
                    </div>
                    <div class="absolute -left-6 -bottom-6 w-32 h-32 bg-orange-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                </div>

            </div>

        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            if(!Alpine.data('liveTimer')) {
                Alpine.data('liveTimer', (startedAtIso) => ({
                    startedAt: new Date(startedAtIso),
                    now: new Date(),
                    timeString: '00:00',
                    interval: null,
                    init() {
                        this.updateTimer();
                        this.interval = setInterval(() => {
                            this.now = new Date();
                            this.updateTimer();
                        }, 1000);
                    },
                    updateTimer() {
                        const diffMs = this.now - this.startedAt;
                        if (diffMs < 0) {
                            this.timeString = '00:00';
                            return;
                        }
                        const totalSeconds = Math.floor(diffMs / 1000);
                        const minutes = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
                        const seconds = (totalSeconds % 60).toString().padStart(2, '0');
                        this.timeString = `${minutes}:${seconds}`;
                    },
                    destroy() {
                        if (this.interval) clearInterval(this.interval);
                    }
                }));
            }
        });
    </script>
</x-doctor-layout>