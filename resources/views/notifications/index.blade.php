<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إشعارات النظام') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">{{ __('الإشعارات') }}</h3>
                    <div class="space-y-4">
                        <!-- Mock Notification 1 -->
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 flex gap-4 items-start">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-slate-800">{{ __('تحديث النظام الجديد') }}</h4>
                                <p class="text-sm text-slate-600 mt-1">{{ __('لقد قمنا بإضافة ميزات جديدة لتحسين تجربتك.') }}</p>
                                <span class="text-xs text-slate-400 mt-2 block">{{ __('قبل ساعتين') }}</span>
                            </div>
                        </div>

                        <!-- Mock Notification 2 -->
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 flex gap-4 items-start">
                            <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-slate-800">{{ __('نجاح عملية الدفع') }}</h4>
                                <p class="text-sm text-slate-600 mt-1">{{ __('تم تأكيد اشتراكك في الباقة السنوية.') }}</p>
                                <span class="text-xs text-slate-400 mt-2 block">{{ __('قبل يومين') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
