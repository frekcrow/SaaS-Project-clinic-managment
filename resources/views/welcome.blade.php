<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Atlas') }} - Absolute Clarity</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            /* Apple UI Core Colors */
            --bg-primary: #ffffff;
            --bg-secondary: #f5f5f7;
            --text-primary: #1d1d1f;
            --text-secondary: #86868b;
            --accent: #0071e3;

            /* Physical Press Curve */
            --ease-press: cubic-bezier(0.23, 1, 0.32, 1);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Inter', 'Segoe UI', sans-serif;
            color: var(--text-primary);
            background-color: var(--bg-primary);
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        /* Apple UI Components */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.04);
            transition: all 0.3s cubic-bezier(0.25, 0.1, 0.25, 1);
        }

        .btn-primary {
            background: var(--accent);
            color: white;
            padding: 12px 28px;
            border-radius: 98px;
            font-weight: 600;
            transition: all 0.2s var(--ease-press);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 14px rgba(0, 113, 227, 0.2);
        }

        .btn-primary:hover {
            filter: brightness(1.05);
        }

        .btn-secondary {
            background: rgba(0, 0, 0, 0.05);
            color: var(--text-primary);
            padding: 12px 28px;
            border-radius: 98px;
            font-weight: 600;
            transition: all 0.2s var(--ease-press);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-secondary:hover {
            background: rgba(0, 0, 0, 0.08);
        }

        /* Physical Press Animation */
        .pressable {
            transition: transform 0.15s var(--ease-press);
        }
        @media (hover: hover) and (pointer: fine) {
            .pressable:active {
                transform: scale(0.97);
            }
        }

        /* Staggered Fade Up Animations */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stagger-item {
            opacity: 0;
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        .stagger-5 { animation-delay: 0.5s; }
        .stagger-6 { animation-delay: 0.6s; }

        /* Typography optical adjustments */
        .tracking-ultra-tight {
            letter-spacing: -0.04em;
        }

        .tracking-tight-custom {
            letter-spacing: -0.02em;
        }

        /* Animated Blob Background for Depth */
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.4;
            animation: float 10s ease-in-out infinite;
        }

        .blob-1 {
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: rgba(0, 113, 227, 0.3);
            border-radius: 50%;
        }

        .blob-2 {
            bottom: -20%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: rgba(134, 134, 139, 0.2);
            border-radius: 50%;
            animation-delay: -5s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, -50px); }
        }

        /* Abstract Grid Pattern overlay */
        .bg-grid {
            background-size: 40px 40px;
            background-image:
                linear-gradient(to right, rgba(0, 0, 0, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0, 0, 0, 0.03) 1px, transparent 1px);
            mask-image: linear-gradient(to bottom, black 40%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, black 40%, transparent 100%);
            position: absolute;
            inset: 0;
            z-index: -1;
        }
    </style>
</head>
<body class="min-h-screen relative overflow-x-hidden selection:bg-blue-500 selection:text-white">

    <!-- Background Elements -->
    <div class="fixed inset-0 z-[-2] bg-[#fbfbfd]"></div>
    <div class="fixed inset-0 z-[-1] bg-grid pointer-events-none"></div>
    <div class="fixed blob blob-1 pointer-events-none"></div>
    <div class="fixed blob blob-2 pointer-events-none"></div>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 px-6 py-4 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto flex items-center justify-between glass-card px-6 py-3 rounded-full">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-black text-white flex items-center justify-center font-bold text-lg rounded-full tracking-tighter">
                    A
                </div>
                <span class="font-bold text-xl tracking-tight-custom text-black">Atlas</span>
            </div>

            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-500">
                <a href="#" class="hover:text-black transition-colors pressable">Platform</a>
                <a href="#" class="hover:text-black transition-colors pressable">Solutions</a>
                <a href="#" class="hover:text-black transition-colors pressable">Enterprise</a>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold hover:text-black transition-colors pressable">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold hover:text-black transition-colors pressable px-4 py-2">Sign in</a>
                    <a href="{{ route('register') }}" class="bg-black text-white px-5 py-2 rounded-full text-sm font-semibold pressable tracking-tight-custom hover:bg-gray-800 transition-colors shadow-md">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="relative z-10 flex flex-col items-center justify-center min-h-screen pt-32 pb-20 px-6">

        <!-- Hero Section -->
        <div class="max-w-5xl text-center w-full mt-12 md:mt-24 mb-24">
            <div class="stagger-item stagger-1 inline-flex items-center gap-2 bg-white/50 backdrop-blur-md border border-gray-200 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wide mb-8 text-gray-600 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                ATLAS OS 3.0 IS HERE
            </div>

            <h1 class="stagger-item stagger-2 text-6xl md:text-8xl lg:text-[110px] font-bold tracking-ultra-tight text-[#1d1d1f] leading-[1.05] mb-8">
                Design that <br class="hidden md:block"/> commands focus.
            </h1>

            <p class="stagger-item stagger-3 text-xl md:text-2xl text-gray-500 max-w-3xl mx-auto leading-relaxed mb-12 font-medium tracking-tight-custom">
                A surgical instrument for your data. Experience absolute clarity with an interface crafted for pure performance and premium aesthetics.
            </p>

            <div class="stagger-item stagger-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary pressable text-lg px-8 py-4 w-full sm:w-auto">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary pressable text-lg px-8 py-4 w-full sm:w-auto">
                        Start for free
                    </a>
                    <a href="{{ route('login') }}" class="btn-secondary pressable text-lg px-8 py-4 w-full sm:w-auto">
                        Sign in to account
                    </a>
                @endauth
            </div>
        </div>

        <!-- Bento Grid Layered Aesthetic -->
        <div class="w-full max-w-6xl mx-auto stagger-item stagger-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 auto-rows-[minmax(240px,_auto)]">

                <!-- Main Feature Card -->
                <div class="glass-card md:col-span-2 p-10 flex flex-col justify-between group overflow-hidden relative pressable cursor-pointer">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <h3 class="text-gray-500 font-semibold text-sm tracking-widest uppercase mb-2">Performance</h3>
                                <h2 class="text-3xl font-bold tracking-tight-custom text-[#1d1d1f]">Lightning Fast</h2>
                            </div>
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                        </div>
                        <p class="text-gray-600 font-medium max-w-md mb-8">
                            Built on a modern stack with instantaneous interactions and fluid motion that feels like magic.
                        </p>
                    </div>

                    <!-- Abstract UI Mockup -->
                    <div class="mt-auto pt-8 border-t border-gray-100/50 relative z-10 flex items-end gap-3">
                        <div class="w-1/3 bg-gray-100 rounded-t-lg h-24 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 ease-out"></div>
                        <div class="w-1/3 bg-blue-100 rounded-t-lg h-32 transform translate-y-2 group-hover:-translate-y-2 transition-transform duration-500 ease-out"></div>
                        <div class="w-1/3 bg-gray-100 rounded-t-lg h-16 transform translate-y-6 group-hover:translate-y-2 transition-transform duration-500 ease-out"></div>
                    </div>
                </div>

                <!-- Secondary Card -->
                <div class="glass-card p-10 flex flex-col justify-between group overflow-hidden relative pressable cursor-pointer">
                    <div class="relative z-10">
                        <h3 class="text-gray-500 font-semibold text-sm tracking-widest uppercase mb-2">Security</h3>
                        <h2 class="text-2xl font-bold tracking-tight-custom text-[#1d1d1f] mb-4">Fort Knox Level</h2>
                        <p class="text-gray-600 font-medium text-sm">
                            Enterprise-grade encryption with zero-trust architecture built natively into the core.
                        </p>
                    </div>

                    <div class="mt-8 flex justify-center">
                        <div class="w-24 h-24 rounded-full border-8 border-gray-100 flex items-center justify-center relative group-hover:border-blue-100 transition-colors duration-500">
                            <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Small Cards -->
                <div class="glass-card p-8 flex items-center justify-between group pressable cursor-pointer">
                    <div>
                        <h3 class="font-bold text-lg text-[#1d1d1f]">Real-time Sync</h3>
                        <p class="text-sm text-gray-500 font-medium">Across all your devices</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                    </div>
                </div>

                <div class="glass-card md:col-span-2 p-8 flex items-center justify-between group pressable cursor-pointer bg-gradient-to-r from-gray-900 to-black text-white hover:shadow-2xl transition-shadow">
                    <div>
                        <h3 class="font-bold text-2xl tracking-tight-custom mb-1">Ready to elevate your workflow?</h3>
                        <p class="text-gray-400 font-medium">Join thousands of professionals using Atlas today.</p>
                    </div>
                    <a href="{{ route('register') }}" class="bg-white text-black px-6 py-3 rounded-full font-bold text-sm pressable hidden sm:block">
                        Get Started Now
                    </a>
                </div>

            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 w-full border-t border-gray-200/50 bg-white/50 backdrop-blur-xl mt-20">
        <div class="max-w-7xl mx-auto px-6 py-12 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 bg-black text-white flex items-center justify-center font-bold text-xs rounded-full">A</div>
                <span class="font-bold tracking-tight-custom text-[#1d1d1f]">Atlas OS</span>
            </div>
            <div class="text-sm font-medium text-gray-500">
                &copy; {{ date('Y') }} Monochrome Inc. All rights reserved.
            </div>
            <div class="flex gap-6 text-sm font-medium text-gray-500">
                <a href="#" class="hover:text-black transition-colors">Privacy</a>
                <a href="#" class="hover:text-black transition-colors">Terms</a>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 20) {
                nav.style.paddingTop = '1rem';
                nav.style.paddingBottom = '1rem';
            } else {
                nav.style.paddingTop = '1.5rem';
                nav.style.paddingBottom = '1.5rem';
            }
        });
    </script>
</body>
</html>
