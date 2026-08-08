                <div class="h-20 flex items-center px-4 border-b border-slate-800" :class="isCollapsed ? 'justify-center' : 'justify-between'">
                    <!-- Logo Area -->
                    <div x-show="!isCollapsed" x-transition.opacity.duration.300ms class="flex items-center gap-2 me-4">
                        <img src="{{ asset('images/logo-icon.png') }}" class="h-6 w-auto filter brightness-0 invert" alt="Logo Icon">
                        <img src="{{ asset('images/logo-text.png') }}" class="h-6 w-auto filter brightness-0 invert" alt="Logo Text">
                    </div>
                    <!-- Toggle Button -->
                    <button @click="isCollapsed = !isCollapsed" class="text-slate-400 hover:text-white transition-colors z-50 flex items-center justify-center p-1 rounded-lg hover:bg-slate-800 flex-shrink-0">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto overflow-x-hidden custom-scrollbar">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-slate-300 hover:bg-slate-800 hover:text-white rounded-2xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-slate-800 text-teal-400' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap truncate">{{ __('لوحة التحكم') }}</span>
                    </a>

                    <a href="{{ route('doctor.patients.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-300 hover:bg-slate-800 hover:text-white rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.patients.*') ? 'bg-slate-800 text-teal-400' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap truncate">{{ __('ملفات المرضى') }}</span>
                    </a>

                    <a href="{{ route('doctor.surgeries.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-300 hover:bg-slate-800 hover:text-white rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.surgeries.*') ? 'bg-slate-800 text-teal-400' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10m-5-4v4m0-4V7a2 2 0 00-2-2H8a2 2 0 00-2 2v10h8V7m-4-2V3a1 1 0 00-1-1H9a1 1 0 00-1 1v2"></path></svg>
                        <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap truncate">{{ __('العمليات') }}</span>
                    </a>

                    <a href="{{ route('doctor.billing.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-300 hover:bg-slate-800 hover:text-white rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.billing.*') ? 'bg-slate-800 text-teal-400' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap truncate">{{ __('الحسابات والفوترة') }}</span>
                    </a>

                    <a href="{{ route('doctor.appointments.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-300 hover:bg-slate-800 hover:text-white rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.appointments.*') ? 'bg-slate-800 text-teal-400' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap truncate">{{ __('تقويم المواعيد') }}</span>
                    </a>

                    <a href="{{ route('doctor.prescriptions.index') }}" class="flex items-center gap-3 px-3 py-2 {{ request()->routeIs('doctor.prescriptions.*') ? 'bg-teal-500/10 text-teal-400' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} rounded-2xl transition-all duration-200 group">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap truncate">{{ __('تهيئة الوصفات') }}</span>
                    </a>

                    <a href="{{ route('doctor.medications.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-300 hover:bg-slate-800 hover:text-white rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.medications.*') ? 'bg-slate-800 text-teal-400' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap truncate">{{ __('الأدوية') }}</span>
                    </a>

                    <a href="{{ route('doctor.settings.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-300 hover:bg-slate-800 hover:text-white rounded-2xl transition-all duration-200 group {{ request()->routeIs('doctor.settings.*') ? 'bg-slate-800 text-teal-400' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap truncate">{{ __('الإعدادات') }}</span>
                    </a>
                </nav>
