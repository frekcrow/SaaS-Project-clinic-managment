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

            <!-- WhatsApp Configuration Card -->
            <div class="p-6 sm:p-8 bg-white/70 backdrop-blur-md shadow-sm sm:rounded-3xl border border-slate-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">{{ __('إعدادات WhatsApp API') }}</h3>
                </div>

                <form method="POST" action="{{ route('secretary.broadcast.update') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="whatsapp_api_token" class="block text-sm font-medium text-slate-700 mb-1">{{ __('رمز الوصول (API Token)') }}</label>
                            <input type="text" id="whatsapp_api_token" name="whatsapp_api_token" value="{{ old('whatsapp_api_token', $clinicSettings->whatsapp_api_token ?? '') }}" class="w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="whatsapp_phone_number_id" class="block text-sm font-medium text-slate-700 mb-1">{{ __('معرف رقم الهاتف (Phone Number ID)') }}</label>
                            <input type="text" id="whatsapp_phone_number_id" name="whatsapp_phone_number_id" value="{{ old('whatsapp_phone_number_id', $clinicSettings->whatsapp_phone_number_id ?? '') }}" class="w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="whatsapp_business_account_id" class="block text-sm font-medium text-slate-700 mb-1">{{ __('معرف حساب الأعمال (Business Account ID)') }}</label>
                            <input type="text" id="whatsapp_business_account_id" name="whatsapp_business_account_id" value="{{ old('whatsapp_business_account_id', $clinicSettings->whatsapp_business_account_id ?? '') }}" class="w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="flex justify-end">
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