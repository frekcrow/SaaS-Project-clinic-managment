<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight text-start">
            {{ __('إشعارات النظام') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm dark:shadow-none sm:rounded-3xl border border-black/5 p-6">
                <h3 class="text-lg font-bold mb-6 text-start text-slate-800 dark:text-slate-200">{{ __('الإشعارات') }}</h3>
                <div class="space-y-6">
                    @forelse($notifications as $notification)
                        <div class="flex flex-col md:flex-row bg-slate-50 dark:bg-gray-900 border border-slate-100 dark:border-gray-700 rounded-2xl overflow-hidden hover:border-indigo-100 transition-colors shadow-sm dark:shadow-none">
                            @if($notification->image_url)
                                <div class="w-full md:w-48 h-48 md:h-auto shrink-0 bg-slate-200 dark:bg-gray-700">
                                    <img src="{{ $notification->image_url }}" alt="{{ $notification->title }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <div class="p-6 flex flex-col justify-center w-full">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-lg font-bold text-slate-800 dark:text-slate-200">{{ $notification->title ?? __('إشعار جديد') }}</h4>
                                    <span class="text-xs font-medium text-slate-500 bg-white dark:bg-gray-800 px-2 py-1 rounded-lg border border-slate-200 dark:border-gray-700">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-slate-600 dark:text-slate-400 text-sm whitespace-pre-line leading-relaxed">{{ $notification->message }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 bg-slate-50 dark:bg-gray-900 rounded-2xl border border-slate-100 dark:border-gray-700">
                            <svg class="mx-auto h-16 w-16 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <p class="mt-4 text-base font-medium text-slate-500">{{ __('لا توجد إشعارات جديدة') }}</p>
                            <p class="mt-1 text-sm text-slate-400">{{ __('عندما يكون هناك تحديثات في النظام، ستظهر هنا.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
