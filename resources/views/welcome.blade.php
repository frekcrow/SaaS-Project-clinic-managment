<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atlas | Premium Medical System</title>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            DEFAULT: '#0058bc',
                            dark: '#004493',
                            light: '#e6f0fa',
                        },
                        surface: '#fbfbfe',
                    },
                    animation: {
                        'float': 'float 8s ease-in-out infinite',
                        'float-delayed': 'float 8s ease-in-out 4s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0) scale(1)' },
                            '50%': { transform: 'translateY(-20px) scale(1.05)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #0f172a; /* Dark sleek background */
            color: #f8fafc;
        }

        :root {
            --ease-out: cubic-bezier(0.23, 1, 0.32, 1);
            --ease-in-out: cubic-bezier(0.77, 0, 0.175, 1);
        }

        /* Group Stagger Animations */
        @keyframes fadeUpAndIn {
            from {
                opacity: 0;
                transform: translateY(24px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .stagger-item {
            opacity: 0;
            animation: fadeUpAndIn 800ms var(--ease-out) forwards;
        }

        .stagger-1 { animation-delay: 100ms; }
        .stagger-2 { animation-delay: 200ms; }
        .stagger-3 { animation-delay: 300ms; }
        .stagger-4 { animation-delay: 400ms; }
        .stagger-5 { animation-delay: 500ms; }
        .stagger-6 { animation-delay: 600ms; }

        .stagger-fast {
             animation: fadeUpAndIn 400ms var(--ease-out) forwards;
        }

        /* Glassmorphism Classes */
        .glass-nav {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .glass-panel {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 24px 48px -12px rgba(0, 0, 0, 0.5);
            transition: transform 300ms var(--ease-out), border-color 300ms var(--ease-out);
        }

        @media (hover: hover) and (pointer: fine) {
            .glass-panel:hover {
                transform: translateY(-4px) scale(1.01);
                border-color: rgba(255, 255, 255, 0.15);
            }
        }

        /* Interactive Elements */
        .pressable {
            transition: transform 160ms var(--ease-out), background-color 160ms var(--ease-out), opacity 160ms var(--ease-out);
        }

        .pressable:active {
            transform: scale(0.97);
        }

        /* Text Gradients */
        .text-gradient {
            background: linear-gradient(135deg, #fff 0%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-gradient-primary {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Ambient Orbs */
        .orb-1 {
            background: radial-gradient(circle at center, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0) 70%);
        }
        .orb-2 {
            background: radial-gradient(circle at center, rgba(139, 92, 246, 0.12) 0%, rgba(139, 92, 246, 0) 70%);
        }

        /* Typography Polish */
        .tracking-tight-custom {
            letter-spacing: -0.04em;
        }

        .tracking-tighter-custom {
            letter-spacing: -0.06em;
        }

    </style>
</head>
<body class="antialiased min-h-screen flex flex-col relative overflow-x-hidden font-sans selection:bg-blue-500/30">

    <!-- Ambient Background -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-[20%] -left-[10%] w-[70vw] h-[70vw] rounded-full orb-1 blur-[100px] mix-blend-screen animate-float"></div>
        <div class="absolute top-[40%] -right-[20%] w-[60vw] h-[60vw] rounded-full orb-2 blur-[120px] mix-blend-screen animate-float-delayed"></div>

        <!-- Subtle Grid Overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdib3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAzNHYtNGgtMnY0aC00djJoNHY0aDJ2LTRoNHYtMmgtNHzmMC0zMFYwaC0ydjRoLTR2Mmg0djRoMnYtNGg0VjRoLTR6bS0zMCAwVjBoLTJ2NGgtNHYyaDR2NGgydi00aDRWNGgtNHptMCAzMHYtNGgtMnY0aC00djJoNHY0aDJ2LTRoNHYtMmgtNHoiIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wMyIvPjwvZz48L3N2Zz4=')] opacity-50"></div>
    </div>

    <!-- Navigation -->
    <header class="fixed top-0 w-full z-50 glass-nav transition-all duration-300">
        <div class="flex justify-between items-center h-20 px-6 md:px-12 max-w-[90rem] mx-auto stagger-item stagger-fast stagger-1">
            <div class="flex items-center gap-3 pressable cursor-pointer">
                <!-- Assuming logo-text.png is dark text, we might just use text for dark mode if it doesn't look good, but we'll try to use it with invert or keep it if it's already white -->
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <span class="material-symbols-outlined text-white">medical_services</span>
                </div>
                <span class="text-xl font-bold tracking-tight text-white hidden sm:block">Atlas</span>
            </div>

            <nav class="hidden md:flex gap-10 items-center">
                <a class="text-sm font-medium text-slate-300 hover:text-white pressable" href="#platform">Platform</a>
                <a class="text-sm font-medium text-slate-300 hover:text-white pressable" href="#solutions">Solutions</a>
                <a class="text-sm font-medium text-slate-300 hover:text-white pressable" href="#security">Security</a>
            </nav>

            <div class="flex items-center gap-4">
                @auth
                    <a class="text-sm font-medium text-slate-300 hover:text-white pressable px-4 py-2" href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <a class="hidden sm:block text-sm font-medium text-slate-300 hover:text-white pressable px-4 py-2" href="{{ route('login') }}">Sign In</a>
                    <a class="flex items-center gap-2 bg-white text-slate-900 px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-slate-100 pressable shadow-lg shadow-white/10" href="/register">
                        <span>Get Started</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-grow pt-32 pb-24 relative z-10 flex flex-col justify-center">
        <!-- Hero Section -->
        <section class="w-full min-h-[75vh] flex flex-col items-center justify-center px-6 md:px-12 text-center mt-12 md:mt-0">
            <div class="max-w-5xl mx-auto flex flex-col items-center">

                <!-- Pill Badge -->
                <div class="stagger-item stagger-1 inline-flex items-center gap-2 bg-blue-500/10 border border-blue-500/20 text-blue-400 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider mb-8 uppercase backdrop-blur-md">
                    <div class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></div>
                    <span>Atlas OS v2.0 Available</span>
                </div>

                <!-- Main Headline (Optical Typography) -->
                <h1 class="stagger-item stagger-2 text-6xl md:text-8xl font-extrabold tracking-tighter-custom leading-[1.05] mb-8 text-white">
                    The operating system <br class="hidden md:block"/>
                    for <span class="text-gradient-primary">modern clinics.</span>
                </h1>

                <!-- Subheadline -->
                <p class="stagger-item stagger-3 text-lg md:text-2xl text-slate-400 tracking-tight-custom max-w-3xl leading-relaxed mb-12 font-light">
                    Beautifully designed to reduce cognitive load. Experience intelligent scheduling, seamless patient records, and automated billing in one fluid workspace.
                </p>

                <!-- CTA Actions -->
                <div class="stagger-item stagger-4 flex flex-col sm:flex-row gap-5 w-full sm:w-auto items-center justify-center">
                    <a class="w-full sm:w-auto bg-blue-600 text-white rounded-full px-8 py-4 text-base font-medium flex items-center justify-center gap-2 shadow-xl shadow-blue-900/40 hover:bg-blue-500 pressable border border-blue-400/20" href="/register">
                        Start your journey
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </a>
                    <a class="w-full sm:w-auto bg-slate-800/50 text-white border border-slate-700/50 rounded-full px-8 py-4 text-base font-medium flex items-center justify-center gap-2 hover:bg-slate-700/50 hover:border-slate-600 pressable backdrop-blur-sm" href="{{ route('login') }}">
                        <span class="material-symbols-outlined text-[20px] text-slate-400">login</span>
                        Sign into workspace
                    </a>
                </div>
            </div>

            <!-- Hero Interface Mockup / Visual Anchor -->
            <div class="stagger-item stagger-5 w-full max-w-6xl mx-auto mt-24 perspective-1000">
                <div class="w-full h-48 md:h-96 rounded-t-3xl glass-panel border-b-0 overflow-hidden relative" style="transform: rotateX(5deg) scale(0.95); transform-origin: bottom; box-shadow: 0 -20px 60px -15px rgba(59, 130, 246, 0.2);">
                    <!-- Fake UI Header -->
                    <div class="h-12 border-b border-slate-700/50 flex items-center px-6 gap-2 bg-slate-900/80">
                        <div class="w-3 h-3 rounded-full bg-slate-700"></div>
                        <div class="w-3 h-3 rounded-full bg-slate-700"></div>
                        <div class="w-3 h-3 rounded-full bg-slate-700"></div>
                    </div>
                    <!-- Fake UI Body -->
                    <div class="p-8 flex gap-6 h-full opacity-30">
                        <div class="w-64 hidden md:flex flex-col gap-4">
                            <div class="h-8 bg-slate-700/50 rounded-lg w-full"></div>
                            <div class="h-8 bg-slate-700/50 rounded-lg w-3/4"></div>
                            <div class="h-8 bg-slate-700/50 rounded-lg w-5/6"></div>
                        </div>
                        <div class="flex-1 flex flex-col gap-4">
                            <div class="h-32 bg-slate-700/30 rounded-2xl w-full border border-slate-700/50"></div>
                            <div class="flex gap-4">
                                <div class="h-32 bg-slate-700/30 rounded-2xl flex-1 border border-slate-700/50"></div>
                                <div class="h-32 bg-slate-700/30 rounded-2xl flex-1 border border-slate-700/50"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-transparent to-transparent z-10"></div>
                </div>
            </div>
        </section>

        <!-- Bento Grid Features Section -->
        <section class="py-32 px-6 md:px-12 max-w-[90rem] mx-auto w-full relative z-10" id="platform">

            <div class="text-center mb-20 stagger-item stagger-1">
                <h2 class="text-3xl md:text-5xl font-bold text-white tracking-tight-custom mb-6">Designed for flow.</h2>
                <p class="text-slate-400 text-lg md:text-xl font-light tracking-tight-custom max-w-2xl mx-auto">
                    Every pixel is engineered to get out of your way, letting you focus entirely on providing exceptional patient care.
                </p>
            </div>

            <!-- Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 auto-rows-[minmax(300px,_auto)]">

                <!-- Large Feature 1 -->
                <div class="md:col-span-8 glass-panel rounded-3xl p-10 flex flex-col justify-between stagger-item stagger-2 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full blur-[60px] group-hover:bg-blue-500/20 transition-colors duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-blue-500/20 text-blue-400 flex items-center justify-center mb-8 border border-blue-500/30">
                            <span class="material-symbols-outlined text-[28px]">vital_signs</span>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-semibold text-white tracking-tight-custom mb-4">Intelligent EMR</h3>
                        <p class="text-slate-400 text-lg leading-relaxed max-w-md">Context-aware timeline views that adapt to your specialty. Access patient history, prescriptions, and lab results in a single, fluid interface.</p>
                    </div>
                </div>

                <!-- Small Feature 1 -->
                <div class="md:col-span-4 glass-panel rounded-3xl p-10 flex flex-col justify-between stagger-item stagger-3 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-purple-500/10 rounded-full blur-[50px] group-hover:bg-purple-500/20 transition-colors duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-purple-500/20 text-purple-400 flex items-center justify-center mb-8 border border-purple-500/30">
                            <span class="material-symbols-outlined text-[24px]">calendar_month</span>
                        </div>
                        <h3 class="text-xl font-semibold text-white tracking-tight-custom mb-3">Fluid Scheduling</h3>
                        <p class="text-slate-400 leading-relaxed">Drag-and-drop interfaces that make managing multi-doctor queues feel like magic.</p>
                    </div>
                </div>

                <!-- Small Feature 2 -->
                <div class="md:col-span-4 glass-panel rounded-3xl p-10 flex flex-col justify-between stagger-item stagger-4 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-emerald-500/10 rounded-full blur-[50px] group-hover:bg-emerald-500/20 transition-colors duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-8 border border-emerald-500/30">
                            <span class="material-symbols-outlined text-[24px]">payments</span>
                        </div>
                        <h3 class="text-xl font-semibold text-white tracking-tight-custom mb-3">Automated Billing</h3>
                        <p class="text-slate-400 leading-relaxed">Seamlessly generate invoices, track revenues, and manage multi-tenant financials effortlessly.</p>
                    </div>
                </div>

                <!-- Large Feature 2 -->
                <div class="md:col-span-8 glass-panel rounded-3xl p-10 flex flex-col justify-between stagger-item stagger-5 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-orange-500/10 rounded-full blur-[60px] group-hover:bg-orange-500/20 transition-colors duration-500"></div>
                    <div class="relative z-10 flex h-full flex-col justify-between">
                        <div>
                            <div class="w-14 h-14 rounded-2xl bg-orange-500/20 text-orange-400 flex items-center justify-center mb-8 border border-orange-500/30">
                                <span class="material-symbols-outlined text-[28px]">forum</span>
                            </div>
                            <h3 class="text-2xl md:text-3xl font-semibold text-white tracking-tight-custom mb-4">Patient Communications</h3>
                        </div>
                        <p class="text-slate-400 text-lg leading-relaxed max-w-md">Integrated WhatsApp and Telegram webhooks. Notify patients of appointments, delays, and updates automatically without lifting a finger.</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- Bottom CTA -->
        <section class="py-24 px-6 relative z-10 text-center flex flex-col items-center">
            <div class="stagger-item stagger-6 glass-panel rounded-3xl p-12 md:p-20 max-w-4xl w-full border border-blue-500/20 bg-blue-900/10 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-blue-500/5 to-transparent"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-5xl font-bold text-white tracking-tight-custom mb-6">Ready to elevate your practice?</h2>
                    <p class="text-slate-400 text-lg mb-10 max-w-xl mx-auto">Join modern clinics running on Atlas and experience the difference of premium software.</p>
                    <a class="inline-flex bg-white text-slate-900 rounded-full px-10 py-4 text-base font-semibold items-center justify-center gap-2 hover:bg-slate-100 pressable shadow-xl shadow-white/10" href="/register">
                        Create your workspace
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="glass-nav mt-auto relative z-10">
        <div class="max-w-[90rem] mx-auto px-6 md:px-12 py-12 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2 opacity-60">
                <span class="material-symbols-outlined text-white">medical_services</span>
                <span class="text-lg font-bold tracking-tight text-white">Atlas</span>
            </div>
            <nav class="flex gap-8">
                <a class="text-sm text-slate-500 hover:text-slate-300 pressable" href="#">Privacy</a>
                <a class="text-sm text-slate-500 hover:text-slate-300 pressable" href="#">Terms</a>
                <a class="text-sm text-slate-500 hover:text-slate-300 pressable" href="#">Security</a>
            </nav>
            <p class="text-sm text-slate-500">&copy; {{ date('Y') }} Atlas Medical OS. All rights reserved.</p>
        </div>
    </footer>

    <!-- Initialize staggered animations on load -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Check for reduced motion
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (prefersReducedMotion) {
                // Remove animation classes if reduced motion is preferred
                document.querySelectorAll('.stagger-item').forEach(el => {
                    el.style.animation = 'none';
                    el.style.opacity = '1';
                    el.style.transform = 'none';
                });
            }
        });
    </script>
</body>
</html>