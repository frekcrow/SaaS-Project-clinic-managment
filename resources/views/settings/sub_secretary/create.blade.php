<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إضافة حساب سكرتير') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('settings.sub-secretary.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="sub_email" class="block text-sm font-medium text-slate-700 mb-1">{{ __('البريد الإلكتروني') }} (Email)</label>
                            <input type="email" id="sub_email" name="email" value="{{ old('email', $subSecretary->email ?? '') }}" class="w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sub_password" class="block text-sm font-medium text-slate-700 mb-1">{{ __('كلمة المرور') }} (Password)</label>
                            <input type="password" id="sub_password" name="password" class="w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ isset($subSecretary) ? '' : 'required' }}>
                            @if(isset($subSecretary))
                                <p class="mt-1 text-xs text-slate-500">{{ __('اتركه فارغاً إذا لم ترغب بتغيير كلمة المرور') }}.</p>
                            @endif
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-sm hover:bg-indigo-700 transition-colors">
                                {{ isset($subSecretary) ? __('تحديث الحساب') : __('إنشاء حساب جديد') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
