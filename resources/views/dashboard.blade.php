<x-app-layout>
    <x-slot name="header">
        {{ $greeting ?? __('لوحة التحكم') }} - {{ __('هل أنت مستعد ليومك؟') }}
    </x-slot>

    <!-- Main Dashboard Master Container -->
    <div class="bg-white rounded-3xl shadow-sm p-4 flex flex-col h-[calc(100vh-10rem)]">

    <!-- Main Quick Actions Container -->
    <div class="flex flex-col sm:flex-row items-center justify-between w-full mb-6 gap-4">

        <!-- Right Side (in RTL): Action Buttons -->
        <div class="flex items-center gap-3 justify-start w-full sm:w-auto">
            <a href="{{ route('patients.create') }}" class="w-full sm:w-auto px-6 bg-black text-white shadow-inner rounded-xl p-3 flex items-center justify-center space-x-2 rtl:space-x-reverse transition-colors hover:bg-gray-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v6m-3-3h6"></path>
                </svg>
                <span class="text-sm font-medium">{{ __('اضافة مريض') }}</span>
            </a>

            <a href="{{ route('appointments.index') }}" class="w-full sm:w-auto px-6 bg-black text-white shadow-inner rounded-xl p-3 flex items-center justify-center space-x-2 rtl:space-x-reverse transition-colors hover:bg-gray-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v6m-3-3h6"></path>
                </svg>
                <span class="text-sm font-medium">{{ __('حجز موعد') }}</span>
            </a>
        </div>

        <!-- Left Side (in RTL): Live Queue Capsule -->
        <div class="flex items-center justify-end w-full sm:w-auto">
            <!-- Queue Capsule -->
            <div x-data="queueCapsule"
                 x-init="initCapsule"
                 class="flex items-center justify-center relative overflow-hidden bg-white rounded-2xl p-4 shadow-sm border border-gray-100 w-full sm:w-56 h-16 min-w-max">

                <template x-for="(state, index) in states" :key="state.id">
                    <div x-show="currentIndex === index"
                         x-transition:enter="transition ease-out duration-500 transform"
                         x-transition:enter-start="translate-y-full opacity-0"
                         x-transition:enter-end="translate-y-0 opacity-100"
                         x-transition:leave="transition ease-in duration-500 transform absolute"
                         x-transition:leave-start="translate-y-0 opacity-100"
                         x-transition:leave-end="-translate-y-full opacity-0"
                         class="flex items-center gap-3 absolute w-full justify-center px-4">

                        <div x-show="state.status === 'active'" class="flex items-center justify-center gap-3 w-fit mx-auto">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(239,68,68,0.8)]"></div>
                                <span class="text-slate-800 font-bold text-sm tracking-wide truncate">{{ __('المراجع الحالي') }}</span>
                            </div>
                            <span class="text-red-600 bg-red-50 px-3 py-1 rounded-lg border border-red-100 font-bold" x-text="state.number"></span>
                        </div>

                        <div x-show="state.status === 'waiting'" class="flex items-center justify-center gap-3 w-fit mx-auto">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 bg-emerald-500 rounded-full shadow-[0_0_8px_rgba(16,185,129,0.8)]"></div>
                                <span class="text-slate-600 font-bold text-sm tracking-wide truncate">{{ __('المراجع التالي') }}</span>
                            </div>
                            <span class="text-emerald-600 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100 font-bold" x-text="state.number || '-'"></span>
                        </div>

                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Layout Groups Container (Side-by-Side) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-4">

        <!-- Grouping 1: Clinic Status & Visitors (40%) -->
        <div class="lg:col-span-5 border border-gray-900 rounded-2xl p-4 flex flex-col justify-center">
            <div class="grid grid-cols-2 gap-4 h-full">
                <!-- Live Consultation Status Card -->
                <div class="relative overflow-hidden w-full h-full flex flex-col justify-center border-l border-slate-100 pl-4"
                     x-data="{
                        timer: 0,
                        formattedTime() {
                            let m = Math.floor(this.timer / 60).toString().padStart(2, '0');
                            let s = (this.timer % 60).toString().padStart(2, '0');
                            return m + ':' + s;
                        }
                     }"
                     @if($activeConsultation) x-init="setInterval(() => timer++, 1000)" @endif>
                    <div class="flex flex-col relative z-10">
                        <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                            <div class="w-8 h-8 rounded-full aspect-square object-cover flex items-center justify-center {{ $activeConsultation ? 'bg-indigo-100 text-indigo-600 animate-pulse' : 'bg-slate-100 text-slate-400' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h2 class="text-sm font-bold text-slate-800">{{ __('حالة العيادة الآن') }}</h2>
                        </div>

                        <div>
                            @if($activeConsultation)
                                <p class="text-indigo-600 font-medium text-xs truncate">{{ __('المريض') }}: {{ $activeConsultation->patient_name ?? $activeConsultation->patient?->name }}</p>
                            @else
                                <p class="text-slate-500 font-medium text-xs">{{ __('لا يوجد مريض حالياً') }}</p>
                            @endif
                        </div>

                        @if($activeConsultation)
                        <div class="mt-2 flex items-center justify-between">
                            <span class="text-xs text-slate-500">{{ __('وقت الجلسة') }}</span>
                            <span class="text-lg font-mono font-bold text-indigo-600" x-text="formattedTime()">00:00</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Visitor Counter Card -->
                <div class="flex flex-col justify-between w-full h-full">
                    <div class="flex items-start justify-between w-full gap-2">
                        <div class="flex-1">
                            <h3 class="text-xs font-medium text-slate-500 flex items-center gap-1.5 mb-1">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                {{ __('عدد الزوار') }}
                            </h3>
                            <p class="text-2xl font-bold text-slate-800">{{ $visitorsCount }}</p>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('dashboard') }}" class="self-start mt-2 w-full">
                        <select name="filter" onchange="this.form.submit()" class="text-xs border-0 bg-slate-50 rounded-lg text-slate-600 focus:ring-0 cursor-pointer pl-6 pr-2 py-1 w-full text-right bg-[position:left_0.25rem_center]">
                            <option value="today" {{ $filter === 'today' ? 'selected' : '' }}>{{ __('اليوم') }}</option>
                            <option value="week" {{ $filter === 'week' ? 'selected' : '' }}>{{ __('الاسبوع') }}</option>
                            <option value="month" {{ $filter === 'month' ? 'selected' : '' }}>{{ __('الشهر') }}</option>
                            <option value="year" {{ $filter === 'year' ? 'selected' : '' }}>{{ __('السنة') }}</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Grouping 2: Today's Stats (60%) -->
        <div class="lg:col-span-7 border border-gray-900 rounded-2xl p-4 flex flex-col justify-center">
            <div class="grid grid-cols-3 gap-4 h-full">
                <!-- Card 1: Today's Appointments -->
                <div class="flex flex-col justify-between h-full border-l border-slate-100 pl-4">
                    <div class="flex items-start justify-between w-full mb-2">
                        <h3 class="text-xs font-medium text-slate-500 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('إجمالي المواعيد') }}
                        </h3>
                    </div>
                    <p class="text-2xl font-bold text-slate-800">{{ $todaysAppointments->count() }}</p>
                    <form method="GET" action="{{ route('dashboard') }}" class="mt-2 w-full">
                        <!-- Preserve other filters -->
                        @if(request('filter')) <input type="hidden" name="filter" value="{{ request('filter') }}"> @endif
                        @if(request('revenue_period')) <input type="hidden" name="revenue_period" value="{{ request('revenue_period') }}"> @endif
                        @if(request('revenue_date')) <input type="hidden" name="revenue_date" value="{{ request('revenue_date') }}"> @endif

                        <select name="appointment_status" onchange="this.form.submit()" class="text-xs border-0 bg-slate-50 rounded-lg text-slate-600 focus:ring-0 cursor-pointer pl-6 pr-2 py-1 w-full text-right bg-[position:left_0.25rem_center]">
                            <option value="all" {{ $appointmentStatus === 'all' ? 'selected' : '' }}>{{ __('الكل') }}</option>
                            <option value="completed" {{ $appointmentStatus === 'completed' ? 'selected' : '' }}>{{ __('مكتمل') }}</option>
                            <option value="pending" {{ $appointmentStatus === 'pending' ? 'selected' : '' }}>{{ __('قيد الانتظار') }}</option>
                            <option value="cancelled" {{ $appointmentStatus === 'cancelled' ? 'selected' : '' }}>{{ __('ملغي') }}</option>
                        </select>
                    </form>
                </div>

                <!-- Card 2: Patients Pending Surgery -->
                <div class="flex flex-col justify-between h-full border-l border-slate-100 pl-4">
                    <div class="flex items-start justify-between w-full mb-2">
                        <h3 class="text-xs font-medium text-slate-500 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            {{ __('انتظار عمليات') }}
                        </h3>
                    </div>
                    <p class="text-2xl font-bold text-slate-800">{{ $pendingSurgeries }}</p>
                    <span class="text-[10px] font-medium text-slate-400 mt-auto pt-2 block">{{ __('الآن') }}</span>
                </div>

                <!-- Card 3: Today's Sessions -->
                <div class="flex flex-col justify-between h-full">
                    <div class="flex items-start justify-between w-full mb-2">
                        <h3 class="text-xs font-medium text-slate-500 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            {{ __('جلسات اليوم') }}
                        </h3>
                    </div>
                    <p class="text-2xl font-bold text-slate-800">{{ $todaySessionsCount }}</p>
                    <span class="text-[10px] font-medium text-slate-400 mt-auto pt-2 block">{{ __('اليوم') }}</span>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role === 'doctor')
    <div class="mb-4">
        <!-- Card 4: Total Revenue (Moved down for doctors) -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-black/5 flex flex-col justify-between hover:shadow-md transition-shadow relative overflow-hidden z-20">
            <div class="flex items-center justify-between mb-2">
                <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <form method="GET" action="{{ route('dashboard') }}" class="self-start flex flex-col items-end gap-2" x-data="{
                    initDatepicker() {
                        window.flatpickr(this.$refs.dateInput, {
                            allowInput: true,
                            dateFormat: 'Y-m-d',
                            defaultDate: '{{ $revenueDate ?? '' }}',
                            onChange: (selectedDates, dateStr, instance) => {
                                this.$el.closest('form').submit();
                            }
                        });
                    }
                }">
                    <!-- Preserve other filters -->
                    @if(request('filter')) <input type="hidden" name="filter" value="{{ request('filter') }}"> @endif
                    @if(request('appointment_status')) <input type="hidden" name="appointment_status" value="{{ request('appointment_status') }}"> @endif

                    <div class="flex items-center gap-2">
                        <div class="relative" x-init="initDatepicker()">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <input type="text" name="revenue_date" x-ref="dateInput" dir="ltr" class="text-left text-xs border-0 bg-slate-50 rounded-lg text-slate-600 focus:ring-0 cursor-pointer pl-6 pr-2 py-1 w-24" placeholder="{{ __('تاريخ محدد') }}">
                        </div>
                        <select name="revenue_period" onchange="this.form.submit()" class="text-xs border-0 bg-slate-50 rounded-lg text-slate-600 focus:ring-0 cursor-pointer pl-6 pr-2 py-1 w-20 text-right bg-[position:left_0.25rem_center]">
                            <option value="all" {{ $revenuePeriod === 'all' ? 'selected' : '' }}>{{ __('الكل') }}</option>
                            <option value="today" {{ $revenuePeriod === 'today' ? 'selected' : '' }}>{{ __('اليوم') }}</option>
                            <option value="week" {{ $revenuePeriod === 'week' ? 'selected' : '' }}>{{ __('الاسبوع') }}</option>
                            <option value="month" {{ $revenuePeriod === 'month' ? 'selected' : '' }}>{{ __('الشهر') }}</option>
                            <option value="year" {{ $revenuePeriod === 'year' ? 'selected' : '' }}>{{ __('السنة') }}</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="relative z-10 mt-2">
                <h3 class="text-slate-500 text-sm font-medium mb-1">{{ __('إجمالي الإيرادات') }}</h3>
                <p class="text-3xl font-bold text-slate-800">{{ number_format($totalRevenue) }} <span class="text-lg text-slate-500 font-normal">{{ __('د.ع') }}</span></p>
            </div>

            <!-- Mini Insight Diagram (Background Sparkline) -->
            <div class="absolute bottom-0 left-0 right-0 h-16 opacity-30 text-emerald-500 pointer-events-none">
                <svg viewBox="0 0 100 40" preserveAspectRatio="none" class="w-full h-full stroke-current">
                    <path d="M0,40 C20,35 30,10 50,20 C70,30 80,5 100,10" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <!-- subtle gradient fill under the line -->
                    <path d="M0,40 C20,35 30,10 50,20 C70,30 80,5 100,10 L100,40 L0,40 Z" fill="currentColor" class="opacity-20" stroke="none" />
                </svg>
            </div>
        </div>
    </div>
    @endif

    <!-- Mini Appointments Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-black/5 flex-1 min-h-0 flex flex-col overflow-hidden">
        <div class="p-4 border-b border-black/5 flex items-center justify-between shrink-0">
            <h2 class="text-lg font-bold text-slate-800">{{ __('مواعيد اليوم') }}</h2>
            <a href="{{ route('appointments.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">{{ __('عرض الكل') }}</a>
        </div>

        <div class="overflow-y-auto flex-1 min-h-0">
            <table class="w-full text-right">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-sm">
                        <th class="py-3 px-6 font-medium">{{ __('اسم المريض') }}</th>
                        <th class="py-3 px-6 font-medium">{{ __('الوقت') }}</th>
                        <th class="py-3 px-6 font-medium">{{ __('الحالة') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentAppointments as $appointment)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="py-4 px-6 text-slate-800 font-medium group-hover:text-indigo-600 transition-colors">
                                {{ $appointment->patient_name ?? ($appointment->patient ? $appointment->patient->name : __('غير محدد')) }}
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $appointment->appointment_datetime ? $appointment->appointment_datetime->format('h:i A') : __('غير محدد') }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if($appointment->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        {{ __('مكتمل') }}
                                    </span>
                                @elseif($appointment->status === 'cancelled')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        {{ __('ملغي') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        {{ __('قادم') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-8 px-6 text-center text-slate-500">
                                {{ __('لا توجد مواعيد اليوم') }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <!-- Alpine JS Omnichannel component -->
    <div x-data="{
        activeConversationId: null,
        messages: [],
        loadMessages() {
            if(!this.activeConversationId) return;
            fetch('/api/chat/conversations/' + this.activeConversationId + '/messages')
            .then(res => res.json())
            .then(data => { this.messages = data; this.scrollToBottom(); });
        },
        init() {
            setInterval(() => { this.loadMessages(); }, 3000);
        },
        callsModal: false,
        messagesModal: false,
        currentView: 'list',
        activeChatName: '',
        activeChatPlatform: '',
        newMessage: '',
        isSending: false,

        openChat(id, name, platform) {
            this.activeConversationId = id;
            this.activeChatName = name;
            this.activeChatPlatform = platform;
            this.messages = [];
            this.currentView = 'chat';
            this.loadMessages();
        },
        closeChat() {
            this.currentView = 'list';
            this.activeConversationId = null;
        },
        scrollToBottom() {
            setTimeout(() => {
                const container = this.$refs.chatMessagesContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            }, 100);
        },
        async sendMessage() {
            if (!this.newMessage.trim() || !this.activeConversationId) return;

            this.isSending = true;
            const content = this.newMessage;

            this.newMessage = '';

            try {
                const response = await fetch('/chat/' + this.activeConversationId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ content: content })
                });

                if (response.ok) {
                    this.loadMessages();
                }
            } catch (error) {
                console.error('Error sending message:', error);
            } finally {
                this.isSending = false;
            }
        }
    }">
        <!-- Floating Omnichannel Bottom Bar -->
        <div class="fixed bottom-6 left-1/2 -translate-x-1/2 z-40 bg-white/70 backdrop-blur-xl border border-white/60 shadow-lg rounded-full px-6 py-3 flex items-center space-x-6 rtl:space-x-reverse transition-transform">

            <button @click="callsModal = true" class="text-slate-600 hover:text-indigo-600 transition-colors relative group">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                </span>
            </button>

            <div class="w-px h-6 bg-slate-200"></div>

            <button @click="messagesModal = true" class="text-slate-600 hover:text-indigo-600 transition-colors relative group">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
            </button>

            <div class="w-px h-6 bg-slate-200"></div>

            <a href="{{ route('settings.index') }}" class="text-slate-600 hover:text-indigo-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </a>
        </div>

        <!-- Calls Slide-over Modal -->
        <div x-show="callsModal"
             style="display: none;"
             class="fixed inset-0 z-50 overflow-hidden"
             aria-labelledby="slide-over-title"
             role="dialog"
             aria-modal="true">
            <div class="absolute inset-0 overflow-hidden">
                <div x-show="callsModal"
                     x-transition:enter="ease-in-out duration-500"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in-out duration-500"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"
                     @click="callsModal = false"></div>

                <div class="pointer-events-none fixed inset-y-0 left-0 flex max-w-full pr-10">
                    <div x-show="callsModal"
                         x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                         x-transition:enter-start="-translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="-translate-x-full"
                         class="pointer-events-auto w-screen max-w-md">
                        <div class="flex h-full flex-col overflow-y-scroll bg-white py-6 shadow-xl rounded-r-3xl border-r border-black/5">
                            <div class="px-4 sm:px-6 flex items-center justify-between">
                                <h2 class="text-lg font-bold text-slate-900" id="slide-over-title">{{ __('المكالمات الواردة') }}</h2>
                                <button type="button" @click="callsModal = false" class="rounded-md bg-white text-slate-400 hover:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <span class="sr-only">Close panel</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="relative mt-6 flex-1 px-4 sm:px-6">
                                <ul class="space-y-4">
                                    @forelse($recentCalls as $call)
                                        <li class="bg-slate-50 p-4 rounded-2xl border border-black/5">
                                            <!-- Example of real data rendering -->
                                            <div class="flex items-center justify-between">
                                                <p class="font-medium text-slate-800">{{ $call->caller_name }}</p>
                                                <span class="text-xs text-slate-500">{{ $call->created_at->diffForHumans() }}</span>
                                            </div>
                                        </li>
                                    @empty
                                        <div class="flex flex-col items-center justify-center h-full text-center space-y-4 text-slate-500">
                                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            <p class="text-lg font-medium">{{ __('لا توجد مكالمات واردة') }}</p>
                                        </div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Slide-over Modal -->
        <div x-show="messagesModal"
             style="display: none;"
             class="fixed inset-0 z-[100] overflow-hidden"
             aria-labelledby="slide-over-title"
             role="dialog"
             aria-modal="true">
            <div class="absolute inset-0 overflow-hidden">
                <div x-show="messagesModal"
                     x-transition:enter="ease-in-out duration-500"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in-out duration-500"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"
                     @click="messagesModal = false"></div>

                <div class="pointer-events-none fixed inset-y-0 start-0 flex max-w-full pe-10">
                    <div x-show="messagesModal"
                         x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                         x-transition:enter-start="ltr:-translate-x-full rtl:translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="ltr:-translate-x-full rtl:translate-x-full"
                         class="pointer-events-auto w-screen max-w-md">
                        <div class="flex h-full flex-col bg-white shadow-xl rounded-e-3xl border-e border-black/5 overflow-hidden">

                            <!-- View A: Conversation List -->
                            <div x-show="currentView === 'list'" class="flex-1 flex flex-col h-full overflow-hidden">
                                <div class="px-4 py-6 sm:px-6 flex items-center justify-between border-b border-slate-100">
                                    <h2 class="text-lg font-bold text-slate-900" id="slide-over-title">{{ __('الرسائل') }}</h2>
                                    <button type="button" @click="messagesModal = false" class="rounded-md bg-white text-slate-400 hover:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex-1 overflow-y-auto px-4 py-4 sm:px-6 custom-scrollbar">
                                    <ul class="space-y-4">
                                        @forelse($recentMessages as $conversation)
                                            <li class="bg-slate-50 p-4 rounded-2xl border border-black/5 hover:border-indigo-200 transition-colors cursor-pointer" @click="openChat({{ $conversation->id }}, {{ Js::from($conversation->patient ? $conversation->patient->name : ($conversation->contact_name ?: $conversation->provider_chat_id)) }}, {{ Js::from($conversation->platform) }})">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold flex-shrink-0">
                                                        @if($conversation->patient)
                                                            {{ mb_substr($conversation->patient->name, 0, 1) }}
                                                        @else
                                                            {{ mb_substr($conversation->contact_name ?? $conversation->provider_chat_id, 0, 1) }}
                                                        @endif
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex justify-between items-center mb-1">
                                                            <h3 class="font-bold text-slate-800 truncate">
                                                                @if($conversation->patient)
                                                                    {{ $conversation->patient->name }}
                                                                @else
                                                                    {{ $conversation->contact_name ?? $conversation->provider_chat_id }}
                                                                @endif
                                                            </h3>
                                                            @if($conversation->messages->count() > 0)
                                                                <span class="text-[10px] text-slate-400 whitespace-nowrap">{{ $conversation->messages->first()->created_at->format('H:i') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="text-sm text-slate-500 truncate flex-1">
                                                            @if($conversation->messages->count() > 0)
                                                                {{ $conversation->messages->first()->content }}
                                                            @else
                                                                {{ __('لا توجد رسائل') }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <div class="flex flex-col items-center justify-center h-full py-12 text-center space-y-4 text-slate-500">
                                                <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                                </svg>
                                                <p class="text-lg font-medium">{{ __('لا توجد رسائل جديدة') }}</p>
                                            </div>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>

                            <!-- View B: Active Chat -->
                            <div x-show="currentView === 'chat'" class="flex-1 flex flex-col h-full overflow-hidden bg-slate-50 relative" style="display: none;">
                                <!-- Chat Header -->
                                <div class="px-4 py-4 border-b border-slate-200 bg-white flex items-center gap-3 shadow-sm z-10">
                                    <button @click="closeChat()" class="text-slate-400 hover:text-slate-600 transition-colors p-2 -ms-2">
                                        <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    </button>
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold flex-shrink-0" x-text="activeChatName ? activeChatName.charAt(0) : '?'">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-slate-800 truncate" x-text="activeChatName"></h3>
                                        <div class="text-xs text-slate-500 flex items-center gap-1">
                                            <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                                            {{ __('متصل عبر') }} <span x-text="activeChatPlatform"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chat Messages Container -->
                                <div class="flex-1 p-4 overflow-y-auto custom-scrollbar flex flex-col gap-4 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-slate-50/50" id="chat-messages-container" x-ref="chatMessagesContainer">
                                    <template x-for="message in messages" :key="message.id">
                                        <div>
                                            <template x-if="message.sender_type === 'clinic'">
                                                <!-- Outgoing Message (Clinic) -->
                                                <div class="flex justify-start">
                                                    <div class="max-w-[85%] bg-indigo-600 text-white rounded-2xl rounded-tr-sm px-4 py-2 shadow-sm">
                                                        <div class="text-sm" x-text="message.content"></div>
                                                    </div>
                                                </div>
                                            </template>
                                            <template x-if="message.sender_type !== 'clinic'">
                                                <!-- Incoming Message (Patient) -->
                                                <div class="flex justify-end">
                                                    <div class="max-w-[85%] bg-white border border-slate-200 text-slate-800 rounded-2xl rounded-tl-sm px-4 py-2 shadow-sm">
                                                        <div class="text-sm" x-text="message.content"></div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>

                                <!-- Chat Input -->
                                <div class="p-4 bg-white border-t border-slate-200 z-10">
                                    <form @submit.prevent="sendMessage()" class="flex gap-2 items-end">
                                        <div class="flex-1 bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                                            <textarea
                                                x-model="newMessage"
                                                rows="1"
                                                class="w-full bg-transparent border-0 focus:ring-0 resize-none py-3 px-4 max-h-32 text-slate-800"
                                                placeholder="{{ __('اكتب رسالة...') }}"
                                                required
                                                @keydown.enter.prevent="sendMessage()"
                                            ></textarea>
                                        </div>
                                        <button type="submit" class="w-12 h-12 rounded-full bg-indigo-600 text-white flex items-center justify-center hover:bg-indigo-700 transition-colors shadow-sm flex-shrink-0" :disabled="isSending" :class="{'opacity-50 cursor-not-allowed': isSending}">
                                            <svg x-show="!isSending" class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                            <svg x-show="isSending" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('queueCapsule', () => ({
            states: [],
            currentIndex: 0,
            interval: null,
            initCapsule() {
                this.fetchData();
                this.interval = setInterval(() => {
                    this.fetchData();
                }, 5000);
            },
            async fetchData() {
                try {
                    const response = await fetch('/api/queue/current');
                    const data = await response.json();

                    const newStatus = data.status;
                    const newNumber = newStatus === 'active' ? data.active_number : data.next_number;
                    const newStateId = newStatus + '-' + newNumber;

                    const currentState = this.states[this.currentIndex];

                    if (!currentState || currentState.id !== newStateId) {
                        this.states.push({
                            id: newStateId,
                            status: newStatus,
                            number: newNumber
                        });
                        if (this.states.length > 1) {
                            setTimeout(() => {
                                this.currentIndex++;
                            }, 50); // slight delay to allow dom update
                        }
                    }
                } catch (error) {
                    console.error('Error fetching queue state:', error);
                }
            },
            destroy() {
                if(this.interval) clearInterval(this.interval);
            }
        }));
    });
</script>
</x-app-layout>