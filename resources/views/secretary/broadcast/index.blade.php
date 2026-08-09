<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight flex items-center gap-2">
                <a href="{{ route('settings.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                {{ __('بث الرسائل للمراجعين') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-2xl relative shadow-sm" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl relative shadow-sm" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Messaging API Configuration Card -->
            <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-slate-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">{{ __('إعدادات منصات المراسلة') }}</h3>
                </div>

                <form method="POST" action="{{ route('secretary.broadcast.update') }}" class="space-y-6">
                    @csrf

                    <h4 class="font-bold text-slate-700 mt-6 mb-2">{{ __('WhatsApp API') }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="whatsapp_access_token" class="block text-sm font-medium text-slate-700 mb-1">{{ __('رمز الوصول (Access Token)') }}</label>
                            <input type="text" id="whatsapp_access_token" name="whatsapp_access_token" value="{{ old('whatsapp_access_token', $messagingSettings->whatsapp_access_token ?? '') }}" class="w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="whatsapp_phone_number_id" class="block text-sm font-medium text-slate-700 mb-1">{{ __('معرف رقم الهاتف (Phone Number ID)') }}</label>
                            <input type="text" id="whatsapp_phone_number_id" name="whatsapp_phone_number_id" value="{{ old('whatsapp_phone_number_id', $messagingSettings->whatsapp_phone_number_id ?? '') }}" class="w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="whatsapp_business_account_id" class="block text-sm font-medium text-slate-700 mb-1">{{ __('معرف حساب الأعمال (Business Account ID)') }}</label>
                            <input type="text" id="whatsapp_business_account_id" name="whatsapp_business_account_id" value="{{ old('whatsapp_business_account_id', $messagingSettings->whatsapp_business_account_id ?? '') }}" class="w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <h4 class="font-bold text-slate-700 mt-6 mb-2">{{ __('Telegram API') }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="telegram_bot_username" class="block text-sm font-medium text-slate-700 mb-1">{{ __('اسم المستخدم للبوت (Bot Username)') }}</label>
                            <input type="text" id="telegram_bot_username" name="telegram_bot_username" value="{{ old('telegram_bot_username', $messagingSettings->telegram_bot_username ?? '') }}" class="w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="telegram_bot_token" class="block text-sm font-medium text-slate-700 mb-1">{{ __('رمز البوت (Bot Token)') }}</label>
                            <input type="text" id="telegram_bot_token" name="telegram_bot_token" value="{{ old('telegram_bot_token', $messagingSettings->telegram_bot_token ?? '') }}" class="w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button type="submit" class="px-6 py-2 bg-black text-white rounded-2xl font-bold shadow-sm hover:bg-neutral-800 transition-colors">
                            {{ __('حفظ الإعدادات') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Send Broadcast Message Card -->
            <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-slate-100">
                <h3 class="text-xl font-bold text-slate-800 mb-6">{{ __('إرسال رسالة جديدة') }}</h3>

                <form method="POST" action="{{ route('secretary.broadcast.send') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="message" class="block text-sm font-medium text-slate-700 mb-1">{{ __('نص الرسالة') }}</label>
                        <textarea id="message" name="message" rows="5" class="w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 resize-none" placeholder="{{ __('اكتب رسالتك هنا للمراجعين...') }}" required>{{ old('message') }}</textarea>
                        <p class="mt-2 text-sm text-slate-500">{{ __('سيتم إرسال هذه الرسالة إلى جميع المراجعين المسجلين في النظام.') }}</p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-2xl font-bold shadow-sm hover:opacity-90 transition-opacity flex items-center gap-2" onclick="return confirm('{{ __('هل أنت متأكد من إرسال هذه الرسالة لجميع المراجعين؟') }}')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            {{ __('إرسال البث') }}
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
