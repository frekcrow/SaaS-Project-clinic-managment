                <div class="h-20 flex items-center px-4" :class="isCollapsed ? 'justify-center' : 'justify-between'">
                    <!-- Logo Area -->
                    <div x-show="!isCollapsed" x-transition.opacity.duration.300ms class="flex items-center gap-2 me-4">
                        <img src="{{ asset('images/logo-icon.png') }}" class="h-8 w-auto" alt="Logo Icon">
                        <img src="{{ asset('images/logo-text.png') }}" class="h-6 w-auto" alt="Logo Text">
                    </div>
                    <!-- Toggle Button -->
                    <button @click="isCollapsed = !isCollapsed" class="text-slate-400 hover:text-slate-600 transition-colors z-50 flex items-center justify-center p-1 rounded-lg hover:bg-slate-100 flex-shrink-0">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto overflow-x-hidden">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('الرئيسية') }}</span>
                    </a>

                    <a href="{{ route('surgeries.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('surgeries.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <!-- Scalpel/Bed SVG placeholder for surgeries -->
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10m-5-4v4m0-4V7a2 2 0 00-2-2H8a2 2 0 00-2 2v10h8V7m-4-2V3a1 1 0 00-1-1H9a1 1 0 00-1 1v2"></path>
                        </svg>
                        <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('العمليات') }}</span>
                    </a>

                    <a href="{{ route('patients.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('patients.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('سجل المرضى') }}</span>
                    </a>

                    <a href="{{ route('appointments.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('appointments.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('جدول المواعيد') }}</span>
                    </a>

                    @if(auth()->user()->role === 'doctor')
                    <a href="{{ route('billing.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('billing.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                       <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('الحسابات') }}</span>
                    </a>
                    @endif

                    <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group {{ request()->routeIs('settings.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('الإعدادات') }}</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('الدعم الفني') }}</span>
                    </a>

                    <a href="#" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100/50 hover:text-indigo-600 rounded-2xl transition-all duration-200 group">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span x-show="!isCollapsed" x-transition.opacity.duration.300ms class="text-sm font-medium whitespace-nowrap">{{ __('إشعارات النظام') }}</span>
                    </a>

                    <!-- Promotional Card Block -->
                    <div x-show="!isCollapsed" class="mt-4 pt-4 border-t border-gray-200">
                        <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100 flex flex-col gap-3">
                            <div class="h-24 w-full bg-slate-200 rounded-xl overflow-hidden relative flex items-center justify-center">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="text-center">
                                <h4 class="text-sm font-bold text-slate-800">{{ __('ترقية النظام') }}</h4>
                                <p class="text-xs text-slate-500 mt-1">{{ __('احصل على الميزات الجديدة الآن') }}</p>
                            </div>
                        </div>
                    </div>
                </nav>
