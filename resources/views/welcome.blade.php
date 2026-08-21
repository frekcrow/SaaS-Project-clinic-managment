<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Atlas Clinic') }} - Welcome</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
        .glass {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        .glass-dark {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="antialiased text-gray-900 selection:bg-blue-500 selection:text-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 top-0 transition-all duration-300 glass border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/">
                        <img src="{{ asset('images/logo-text.png') }}" alt="Atlas Logo" class="h-10 w-auto">
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#features" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">Features</a>
                    <a href="#showcase" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">Showcase</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full font-medium transition-all shadow-lg shadow-blue-500/30">Get Started</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://encrypted-tbn1.gstatic.com/licensed-image?q=tbn:ANd9GcTMHz2wRSDh48kYnOlQXVw1mNAUSsxcFtwrQrCTjdIupXkMcnsNKe8YOForQkgzi_12rwHmxfu3Ka11wio" alt="Clinic Interior" class="w-full h-full object-cover object-center" />
            <!-- Overlay to make text readable and add aesthetic -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/40 to-gray-900/60 mix-blend-multiply"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center flex flex-col items-center">
            <div class="glass rounded-3xl p-8 md:p-14 w-full max-w-3xl transform transition-all hover:scale-[1.01] duration-500">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-100/80 text-blue-800 text-sm font-semibold tracking-wider mb-6 backdrop-blur-sm border border-blue-200/50">WELCOME TO ATLAS</span>
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-gray-900 mb-6 leading-tight">
                    Atlas Medical System: <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">The Future of Clinic Management</span>
                </h1>
                <p class="mt-4 text-xl text-gray-600 mb-10 max-w-2xl mx-auto font-medium">
                    Experience seamless patient care, intelligent scheduling, and automated workflows designed specifically for modern medical practices.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="/register" class="bg-gray-900 hover:bg-black text-white px-8 py-4 rounded-full font-semibold text-lg transition-all shadow-xl shadow-gray-900/20 flex items-center justify-center group">
                        Get Started
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="#features" class="glass hover:bg-white/80 text-gray-900 px-8 py-4 rounded-full font-semibold text-lg transition-all flex items-center justify-center">
                        Explore Features
                    </a>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-gray-50 relative overflow-hidden">
        <!-- Decorative blobs -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900 tracking-tight mb-4">Reimagining Clinic Software</h2>
                <p class="text-xl text-gray-600">Everything you need to run your practice efficiently, neatly packed into an elegant, easy-to-use platform.</p>
            </div>

            <!-- CSS Grid for Features -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass rounded-3xl p-8 hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-6 shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Smart Patient Records</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Access comprehensive patient histories instantly. Our intuitive interface organizes medical data, making it easy to review past treatments, allergies, and notes in one glance.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="glass rounded-3xl p-8 hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center mb-6 shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Automated Appointments</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Say goodbye to double bookings and missed appointments. Our smart scheduling system handles reminders and calendar synchronization effortlessly.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="glass rounded-3xl p-8 hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mb-6 shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Telegram Bot Integration</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Connect with patients where they are. Our omnichannel approach integrates smoothly with Telegram for immediate notifications, reminders, and patient queries.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Showcase Section -->
    <section id="showcase" class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <!-- Text Content -->
                <div class="lg:w-1/2">
                    <h2 class="text-3xl md:text-5xl font-bold text-gray-900 tracking-tight mb-6">Designed for Modern Doctors</h2>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Whether you are at your desk or doing rounds with a tablet, Atlas provides a fluid, responsive experience. Spend less time on administrative tasks and more time focusing on what truly matters: your patients.
                    </p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-gray-700">
                            <svg class="h-6 w-6 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Optimized for all devices
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="h-6 w-6 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Real-time data synchronization
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="h-6 w-6 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Secure and compliant
                        </li>
                    </ul>
                    <a href="/register" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors">
                        Start your free trial today
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <!-- Image Showcase with Floating Card -->
                <div class="lg:w-1/2 relative w-full aspect-square md:aspect-[4/3] lg:aspect-auto lg:h-[600px] rounded-3xl overflow-hidden shadow-2xl">
                    <img src="https://encrypted-tbn0.gstatic.com/licensed-image?q=tbn:ANd9GcTsjipy1Swzv-mNCDcgc_hqD-8bbvAubIrvXQ_Or8axJLCJ_0Amcsb11OVrhzirCuP9jdKXxFOGRwJ5UTg" alt="Doctor using software on tablet" class="w-full h-full object-cover" />

                    <!-- Floating Glass Card Overlapping -->
                    <div class="absolute bottom-8 left-8 right-8 md:left-auto md:right-8 md:w-80 glass-dark p-4 rounded-2xl flex items-center shadow-2xl transform hover:-translate-y-1 transition-transform border border-white/20">
                        <div class="w-12 h-12 rounded-full bg-green-500/20 flex items-center justify-center mr-4 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">Success</p>
                            <p class="text-gray-300 text-xs mt-0.5">Patient Successfully Transferred</p>
                            <div class="mt-2 text-[10px] text-gray-400">Just now • Room 302</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center mb-4 md:mb-0">
                <img src="{{ asset('images/logo-text.png') }}" alt="Atlas Logo" class="h-8 w-auto opacity-70 grayscale">
            </div>
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} Atlas Clinic. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- Simple animations -->
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>
</html>
