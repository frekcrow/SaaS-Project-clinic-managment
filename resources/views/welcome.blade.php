<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>نظام أطلس - السجلات الطبية الإلكترونية المتطورة</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback for local dev if needed -->
    @endif

    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }

        .glassmorphism {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .dark .glassmorphism {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }
        .floating-delay-1 {
            animation-delay: 1.5s;
        }
        .floating-delay-2 {
            animation-delay: 3s;
        }

        .gradient-text {
            background: linear-gradient(135deg, #10b981, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-neutral-950 text-neutral-900 dark:text-neutral-100 overflow-x-hidden selection:bg-blue-500 selection:text-white transition-colors duration-300">

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 glassmorphism border-b border-gray-200 dark:border-neutral-800 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-emerald-400 flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-blue-500/30">
                        A
                    </div>
                    <span class="font-black text-2xl tracking-tight">أطلس</span>
                </div>

                <div class="hidden md:flex space-x-8 rtl:space-x-reverse">
                    <a href="#features" class="text-neutral-600 dark:text-neutral-300 hover:text-black dark:hover:text-white font-medium transition-colors">المميزات</a>
                    <a href="#security" class="text-neutral-600 dark:text-neutral-300 hover:text-black dark:hover:text-white font-medium transition-colors">الأمان</a>
                    <a href="#pricing" class="text-neutral-600 dark:text-neutral-300 hover:text-black dark:hover:text-white font-medium transition-colors">الخطط</a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 px-6 py-2.5 rounded-full font-bold hover:scale-105 transition-transform shadow-lg shadow-black/10 dark:shadow-white/10">لوحة التحكم</a>
                    @else
                        <a href="{{ route('login') }}" class="text-neutral-700 dark:text-neutral-200 font-bold hover:text-black dark:hover:text-white transition-colors">تسجيل الدخول</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-l from-blue-600 to-blue-500 text-white px-6 py-2.5 rounded-full font-bold hover:scale-105 hover:shadow-xl hover:shadow-blue-500/20 transition-all">ابدأ الآن</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- 1. Hero Section -->
    <section class="relative pt-40 pb-20 lg:pt-52 lg:pb-32 overflow-hidden min-h-[90vh] flex items-center justify-center">
        <!-- Abstract Background Orbs -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-400/20 dark:bg-blue-600/20 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-emerald-400/20 dark:bg-emerald-600/20 rounded-full blur-3xl -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center" x-data="{ words: ['السرعة', 'الأمان', 'الذكاء', 'التطور'], index: 0 }" x-init="setInterval(() => index = (index + 1) % words.length, 2500)">

            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black mb-6 leading-tight tracking-tight">
                نظام أطلس يمنح عيادتك
                <br />
                <span class="inline-block min-w-[200px] text-transparent bg-clip-text bg-gradient-to-l from-blue-600 to-emerald-400 transition-all duration-500 ease-in-out" x-text="words[index]"></span>
            </h1>

            <p class="text-xl md:text-2xl text-neutral-600 dark:text-neutral-400 max-w-3xl mx-auto mb-12 font-medium leading-relaxed">
                بنية تحتية سحابية متطورة لإدارة السجلات الطبية الإلكترونية، مصممة خصيصاً للارتقاء بمستوى الرعاية الصحية في عيادتك بمعايير عالمية.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="#pricing" class="bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 px-8 py-4 rounded-full font-bold text-lg hover:scale-105 transition-transform shadow-2xl shadow-neutral-900/20 dark:shadow-white/20 w-full sm:w-auto text-center">ابدأ الآن</a>
                <a href="#features" class="glassmorphism text-neutral-900 dark:text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white/60 dark:hover:bg-white/10 hover:scale-105 transition-all w-full sm:w-auto text-center">اكتشف النظام</a>
            </div>

            <!-- Floating Medical Icons -->
            <div class="absolute top-10 left-10 md:left-32 floating text-blue-500 opacity-80">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>

            <div class="absolute bottom-20 right-10 md:right-20 floating floating-delay-1 text-emerald-500 opacity-80">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>

            <div class="absolute top-32 right-10 md:right-40 floating floating-delay-2 text-indigo-500 opacity-80">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
        </div>
    </section>

    <!-- 2. Academic System Explanation & HIPAA -->
    <section id="features" class="py-24 bg-white dark:bg-neutral-900 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-3xl md:text-5xl font-black mb-4">نظام متكامل، بنية تحتية سحابية متطورة</h2>
                <p class="text-lg text-neutral-500 dark:text-neutral-400 max-w-2xl mx-auto">إدارة السجلات الطبية الإلكترونية لم تكن بهذه السهولة والأمان من قبل.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Bento Box 1 -->
                <div class="md:col-span-2 bg-gray-50 dark:bg-neutral-800 p-10 rounded-3xl overflow-hidden relative group hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-neutral-700">
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white dark:bg-neutral-700 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-3">إدارة شاملة للعيادة</h3>
                        <p class="text-neutral-600 dark:text-neutral-400 text-lg leading-relaxed max-w-lg">
                            نظام متكامل يغطي كافة جوانب العيادة بدءاً من حجز المواعيد، مروراً بالسجل الطبي الإلكتروني، وصولاً إلى الفوترة وإدارة الحسابات بكفاءة عالية.
                        </p>
                    </div>
                    <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-blue-100 dark:bg-blue-900/30 rounded-full blur-3xl group-hover:bg-blue-200 dark:group-hover:bg-blue-800/40 transition-colors"></div>
                </div>

                <!-- Bento Box 2: HIPAA Compliance -->
                <div id="security" class="bg-gradient-to-br from-neutral-900 to-black dark:from-neutral-800 dark:to-neutral-900 p-10 rounded-3xl text-white relative overflow-hidden group border border-neutral-800 dark:border-neutral-700">
                    <div class="absolute top-0 right-0 p-6 opacity-20 group-hover:opacity-100 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div>
                            <div class="inline-block px-4 py-1.5 rounded-full bg-emerald-500/20 text-emerald-400 font-bold text-sm mb-6 border border-emerald-500/30 backdrop-blur-sm">
                                HIPAA Compliant
                            </div>
                            <h3 class="text-2xl font-bold mb-3">أقصى درجات الأمان</h3>
                            <p class="text-neutral-400 text-base leading-relaxed">
                                يلتزم النظام بشكل صارم بمعايير الخصوصية والتشفير لحماية بيانات المرضى والسجلات الطبية ضد أي اختراقات.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bento Box 3 -->
                <div class="bg-gray-50 dark:bg-neutral-800 p-10 rounded-3xl border border-gray-100 dark:border-neutral-700 hover:shadow-xl transition-all">
                    <div class="w-14 h-14 bg-white dark:bg-neutral-700 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">سرعة فائقة</h3>
                    <p class="text-neutral-600 dark:text-neutral-400">واجهة مستخدم تفاعلية لحظية تضمن سرعة إدخال واسترجاع البيانات بضغطة زر.</p>
                </div>

                <!-- Bento Box 4 -->
                <div class="md:col-span-2 bg-gray-50 dark:bg-neutral-800 p-10 rounded-3xl border border-gray-100 dark:border-neutral-700 hover:shadow-xl transition-all flex items-center">
                    <div class="w-full">
                        <div class="w-14 h-14 bg-white dark:bg-neutral-700 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-3">إدارة تعدد المستخدمين بصلاحيات دقيقة</h3>
                        <p class="text-neutral-600 dark:text-neutral-400 max-w-2xl">
                            نظام متطور يعتمد على Role-Based Access Control يتيح للأطباء إدارة الصلاحيات للمساعدين والسكرتارية بسهولة من خلال أكواد العيادات (Clinic Codes) مع عزل تام لبيانات كل عيادة.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Interactive Charts & Features -->
    <section class="py-24 bg-neutral-50 dark:bg-neutral-950 relative overflow-hidden"
             x-data="{ showChart: false }"
             x-intersect.threshold.50="showChart = true">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2">
                    <h2 class="text-3xl md:text-5xl font-black mb-6">لماذا أطلس؟ <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-emerald-400">نمو كفاءة العيادة</span></h2>
                    <p class="text-lg text-neutral-600 dark:text-neutral-400 mb-8 leading-relaxed">
                        أثبتت الإحصائيات أن انتقال العيادات للأنظمة السحابية المتطورة يزيد من كفاءة العمل وتقليل وقت الانتظار بنسبة تفوق 40%، مما ينعكس إيجاباً على رضا المرضى وزيادة الإيرادات.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="font-bold text-lg">تقليل الأعمال الورقية بنسبة 90%</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="font-bold text-lg">الوصول للسجلات في ثوانٍ معدودة</span>
                        </li>
                    </ul>
                </div>

                <div class="lg:w-1/2 w-full">
                    <!-- Interactive Chart UI -->
                    <div class="glassmorphism rounded-3xl p-8 shadow-2xl border border-gray-200 dark:border-neutral-800">
                        <div class="flex items-end justify-between h-64 gap-4 px-2">
                            <!-- Bar 1 -->
                            <div class="w-1/4 flex flex-col items-center justify-end h-full">
                                <div class="w-full bg-gray-200 dark:bg-neutral-800 rounded-t-xl transition-all duration-1000 ease-out"
                                     :style="showChart ? 'height: 30%' : 'height: 0%'"></div>
                                <span class="text-sm font-bold mt-4 text-neutral-500">الشهر 1</span>
                            </div>
                            <!-- Bar 2 -->
                            <div class="w-1/4 flex flex-col items-center justify-end h-full">
                                <div class="w-full bg-blue-300 dark:bg-blue-900/50 rounded-t-xl transition-all duration-1000 ease-out delay-150"
                                     :style="showChart ? 'height: 50%' : 'height: 0%'"></div>
                                <span class="text-sm font-bold mt-4 text-neutral-500">الشهر 2</span>
                            </div>
                            <!-- Bar 3 -->
                            <div class="w-1/4 flex flex-col items-center justify-end h-full">
                                <div class="w-full bg-blue-500 dark:bg-blue-700 rounded-t-xl transition-all duration-1000 ease-out delay-300"
                                     :style="showChart ? 'height: 75%' : 'height: 0%'"></div>
                                <span class="text-sm font-bold mt-4 text-neutral-500">الشهر 3</span>
                            </div>
                            <!-- Bar 4 -->
                            <div class="w-1/4 flex flex-col items-center justify-end h-full relative group">
                                <div class="absolute -top-12 opacity-0 group-hover:opacity-100 transition-opacity bg-black text-white text-xs font-bold px-3 py-1.5 rounded-lg whitespace-nowrap">
                                    نمو +85%
                                </div>
                                <div class="w-full bg-gradient-to-t from-emerald-400 to-blue-500 rounded-t-xl shadow-lg shadow-blue-500/20 transition-all duration-1000 ease-out delay-500 cursor-pointer"
                                     :style="showChart ? 'height: 95%' : 'height: 0%'"></div>
                                <span class="text-sm font-bold mt-4 text-neutral-900 dark:text-white">أطلس</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Customer Testimonials -->
    <section class="py-24 bg-white dark:bg-neutral-900 border-t border-gray-100 dark:border-neutral-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-black mb-4">آراء الأطباء</h2>
                <p class="text-lg text-neutral-500 dark:text-neutral-400">نفتخر بثقة نخبة من الأطباء في نظام أطلس.</p>
            </div>

            <!-- Auto-fading Carousel -->
            <div class="relative max-w-4xl mx-auto" x-data="{ activeSlide: 0, slides: 3 }" x-init="setInterval(() => activeSlide = (activeSlide + 1) % slides, 4000)">

                <!-- Slide 1 -->
                <div x-show="activeSlide === 0" x-transition.opacity.duration.500ms class="absolute inset-0">
                    <div class="glassmorphism p-10 rounded-3xl text-center border border-gray-100 dark:border-neutral-700 shadow-xl">
                        <div class="w-16 h-16 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-2xl font-bold mx-auto mb-6">أ</div>
                        <p class="text-2xl font-medium leading-relaxed mb-8 dark:text-neutral-200">
                            "استخدام أطلس غير شكل العمل في العيادة تماماً. واجهة المستخدم بديهية جداً، والسرعة في استرجاع ملفات المرضى وفرت علينا الكثير من الوقت."
                        </p>
                        <div>
                            <h4 class="font-bold text-lg">د. أحمد</h4>
                            <p class="text-neutral-500">استشاري أمراض القلب</p>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div x-show="activeSlide === 1" x-transition.opacity.duration.500ms class="absolute inset-0" style="display: none;">
                    <div class="glassmorphism p-10 rounded-3xl text-center border border-gray-100 dark:border-neutral-700 shadow-xl">
                        <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl font-bold mx-auto mb-6">س</div>
                        <p class="text-2xl font-medium leading-relaxed mb-8 dark:text-neutral-200">
                            "ما يميز أطلس هو مستوى الأمان العالي. كون النظام متوافق مع معايير HIPAA يعطيني الثقة الكاملة في حفظ بيانات مرضاي."
                        </p>
                        <div>
                            <h4 class="font-bold text-lg">د. سارة</h4>
                            <p class="text-neutral-500">طبيبة أسنان</p>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div x-show="activeSlide === 2" x-transition.opacity.duration.500ms class="absolute inset-0" style="display: none;">
                    <div class="glassmorphism p-10 rounded-3xl text-center border border-gray-100 dark:border-neutral-700 shadow-xl">
                        <div class="w-16 h-16 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-2xl font-bold mx-auto mb-6">ع</div>
                        <p class="text-2xl font-medium leading-relaxed mb-8 dark:text-neutral-200">
                            "إدارة المواعيد أصبحت منظمة جداً، ودعم تعدد السكرتارية في نفس العيادة ميزة ممتازة وتعمل بشكل سلس وفعال."
                        </p>
                        <div>
                            <h4 class="font-bold text-lg">د. عمر</h4>
                            <p class="text-neutral-500">أخصائي باطنية</p>
                        </div>
                    </div>
                </div>

                <!-- Spacer to preserve height since slides are absolute -->
                <div class="pb-[400px] sm:pb-[350px] md:pb-[300px]"></div>

                <!-- Indicators -->
                <div class="flex justify-center gap-2 mt-8">
                    <button @click="activeSlide = 0" :class="{'bg-blue-600 w-8': activeSlide === 0, 'bg-gray-300 dark:bg-neutral-700 w-3': activeSlide !== 0}" class="h-3 rounded-full transition-all duration-300"></button>
                    <button @click="activeSlide = 1" :class="{'bg-blue-600 w-8': activeSlide === 1, 'bg-gray-300 dark:bg-neutral-700 w-3': activeSlide !== 1}" class="h-3 rounded-full transition-all duration-300"></button>
                    <button @click="activeSlide = 2" :class="{'bg-blue-600 w-8': activeSlide === 2, 'bg-gray-300 dark:bg-neutral-700 w-3': activeSlide !== 2}" class="h-3 rounded-full transition-all duration-300"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Pricing Plans -->
    <section id="pricing" class="py-24 bg-gray-50 dark:bg-neutral-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-3xl md:text-5xl font-black mb-4">خطط الشراء</h2>
                <p class="text-lg text-neutral-500 dark:text-neutral-400">اختر الخطة التي تناسب حجم عيادتك وطموحاتك.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto items-center">

                <!-- Basic Tier -->
                <div class="bg-white dark:bg-neutral-900 rounded-3xl p-8 border border-gray-100 dark:border-neutral-800 shadow-sm hover:shadow-xl transition-all">
                    <h3 class="text-xl font-bold mb-2">الأساسية</h3>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm mb-6">للعيادات الصغيرة والناشئة</p>
                    <div class="text-4xl font-black mb-6">مجاناً</div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-neutral-600 dark:text-neutral-300"><svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 50 مريض شهرياً</li>
                        <li class="flex items-center gap-3 text-neutral-600 dark:text-neutral-300"><svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> إدارة المواعيد</li>
                        <li class="flex items-center gap-3 text-neutral-600 dark:text-neutral-300"><svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> سكرتير واحد</li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-3 px-4 bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 text-center font-bold rounded-xl transition-colors">ابدأ الآن</a>
                </div>

                <!-- Pro Tier (Emphasized) -->
                <div class="bg-gradient-to-b from-neutral-900 to-black dark:from-neutral-800 dark:to-neutral-900 text-white rounded-3xl p-10 border border-blue-500/50 shadow-2xl shadow-blue-500/20 transform md:-translate-y-4 relative">
                    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-blue-500 to-emerald-400 rounded-t-3xl"></div>
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-blue-500 to-emerald-400 text-white px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                        الأكثر شيوعاً
                    </div>

                    <h3 class="text-xl font-bold mb-2">المتقدمة</h3>
                    <p class="text-neutral-400 text-sm mb-6">للعيادات المتنامية</p>
                    <div class="text-4xl font-black mb-6">49$ <span class="text-lg font-medium text-neutral-400">/شهر</span></div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3"><svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> عدد غير محدود من المرضى</li>
                        <li class="flex items-center gap-3"><svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> السجل الطبي الإلكتروني الكامل</li>
                        <li class="flex items-center gap-3"><svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> إدارة الحسابات والفوترة</li>
                        <li class="flex items-center gap-3"><svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> حتى 3 سكرتارية</li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-4 px-4 bg-white text-black hover:bg-gray-100 text-center font-bold rounded-xl transition-colors shadow-lg">اشترك الآن</a>
                </div>

                <!-- Enterprise Tier -->
                <div class="bg-white dark:bg-neutral-900 rounded-3xl p-8 border border-gray-100 dark:border-neutral-800 shadow-sm hover:shadow-xl transition-all">
                    <h3 class="text-xl font-bold mb-2">الاحترافية</h3>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm mb-6">للمجمعات الطبية</p>
                    <div class="text-4xl font-black mb-6">99$ <span class="text-lg font-medium text-neutral-400">/شهر</span></div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-neutral-600 dark:text-neutral-300"><svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> كل مميزات الباقة المتقدمة</li>
                        <li class="flex items-center gap-3 text-neutral-600 dark:text-neutral-300"><svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> أطباء متعددين</li>
                        <li class="flex items-center gap-3 text-neutral-600 dark:text-neutral-300"><svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> تقارير وإحصائيات متقدمة</li>
                    </ul>
                    <a href="#" class="block w-full py-3 px-4 bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 text-center font-bold rounded-xl transition-colors">تواصل معنا</a>
                </div>

            </div>
        </div>
    </section>

    <!-- 6. The Footer -->
    <footer class="bg-white dark:bg-neutral-900 border-t border-gray-200 dark:border-neutral-800 pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 md:gap-8 mb-16">

                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-blue-600 to-emerald-400 flex items-center justify-center text-white font-bold text-xl">
                            A
                        </div>
                        <span class="font-black text-2xl tracking-tight">أطلس</span>
                    </div>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm leading-relaxed">
                        نظام الإدارة الشامل للعيادات الطبية الحديثة. مبني بأحدث التقنيات لضمان السرعة والأمان.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-lg mb-6">النظام</h4>
                    <ul class="space-y-4">
                        <li><a href="#features" class="text-neutral-500 dark:text-neutral-400 hover:text-black dark:hover:text-white transition-colors">المميزات</a></li>
                        <li><a href="#security" class="text-neutral-500 dark:text-neutral-400 hover:text-black dark:hover:text-white transition-colors">الأمان والخصوصية</a></li>
                        <li><a href="#pricing" class="text-neutral-500 dark:text-neutral-400 hover:text-black dark:hover:text-white transition-colors">الأسعار</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-lg mb-6">الدعم الفني</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-neutral-500 dark:text-neutral-400 hover:text-black dark:hover:text-white transition-colors">مركز المساعدة</a></li>
                        <li><a href="#" class="text-neutral-500 dark:text-neutral-400 hover:text-black dark:hover:text-white transition-colors">تواصل معنا</a></li>
                        <li><a href="#" class="text-neutral-500 dark:text-neutral-400 hover:text-black dark:hover:text-white transition-colors">تحديثات النظام</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-lg mb-6">سياسة الخصوصية</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-neutral-500 dark:text-neutral-400 hover:text-black dark:hover:text-white transition-colors">شروط الاستخدام</a></li>
                        <li><a href="#" class="text-neutral-500 dark:text-neutral-400 hover:text-black dark:hover:text-white transition-colors">حماية البيانات</a></li>
                        <li><a href="#" class="text-neutral-500 dark:text-neutral-400 hover:text-black dark:hover:text-white transition-colors">الامتثال (HIPAA)</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-neutral-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-neutral-500 dark:text-neutral-400 text-sm">
                    &copy; {{ date('Y') }} نظام أطلس. جميع الحقوق محفوظة.
                </p>
                <div class="flex items-center gap-4">
                    <!-- Social Media Links -->
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-neutral-800 flex items-center justify-center text-neutral-600 dark:text-neutral-400 hover:bg-blue-100 hover:text-blue-600 hover:scale-110 transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-neutral-800 flex items-center justify-center text-neutral-600 dark:text-neutral-400 hover:bg-blue-100 hover:text-blue-900 hover:scale-110 transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>