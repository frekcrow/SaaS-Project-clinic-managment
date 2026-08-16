<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Atlas Clinic') }} - إعداد النظام</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-900 bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-8 bg-white rounded-3xl shadow-lg border border-slate-100">
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-200">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-center text-slate-800 mb-2">إعداد قاعدة البيانات</h2>
        <p class="text-center text-slate-500 mb-8 text-sm">مرحباً بك في النظام. لحماية بياناتك، يرجى اختيار مسار آمن على جهازك لحفظ قاعدة البيانات المحلية.</p>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm" role="alert">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('setup.store') }}" class="space-y-6">
            @csrf
            <div>
                <label for="database_path" class="block text-sm font-medium text-slate-700 mb-2">مسار المجلد (مثال: D:\AtlasClinicData)</label>
                <input type="text" id="database_path" name="database_path" value="{{ old('database_path') }}" required dir="ltr" class="w-full rounded-2xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-left">
            </div>

            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-2xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                حفظ وإنهاء الإعداد
            </button>
        </form>
    </div>
</body>
</html>
