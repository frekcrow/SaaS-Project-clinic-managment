<!DOCTYPE html>
<html lang="en" dir="ltr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atlas Medical System</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            /* Apple-like easing */
            --ease-out: cubic-bezier(0.23, 1, 0.32, 1);
            --ease-in-out: cubic-bezier(0.77, 0, 0.175, 1);
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            font-optical-sizing: auto;
            background-color: #fafafa;
            color: #1a1a1a;
        }

        /* Typography */
        .display-text {
            line-height: 1.05;
            letter-spacing: -0.02em;
        }

        .body-text {
            line-height: 1.5;
            letter-spacing: 0;
        }

        /* Interaction - Press Feedback */
        .press-effect {
            transition: transform 160ms var(--ease-out);
            display: inline-block;
        }

        .press-effect:active {
            transform: scale(0.97);
        }

        /* Glassmorphism */
        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
        }

        /* Animations */
        @keyframes smoothEnter {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stagger-1 { animation: smoothEnter 0.8s var(--ease-out) 0.1s both; }
        .stagger-2 { animation: smoothEnter 0.8s var(--ease-out) 0.2s both; }
        .stagger-3 { animation: smoothEnter 0.8s var(--ease-out) 0.3s both; }
        .stagger-4 { animation: smoothEnter 0.8s var(--ease-out) 0.4s both; }

        @media (prefers-reduced-motion: reduce) {
            .stagger-1, .stagger-2, .stagger-3, .stagger-4 {
                animation: fadeEnter 0.4s ease both;
                transform: none !important;
            }
            .press-effect {
                transition: opacity 0.2s ease;
                transform: none !important;
            }
            .press-effect:active {
                opacity: 0.7;
                transform: none !important;
            }
        }

        @keyframes fadeEnter {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col relative overflow-x-hidden">

    <!-- Navigation -->
    <header class="fixed top-0 w-full z-50 glass-nav">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 press-effect">
                <img src="{{ asset('images/logo-text.png') }}" alt="Atlas Logo" class="h-8 auto">
            </a>

            <nav class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-sm font-medium text-gray-600 hover:text-gray-900 press-effect transition-colors">Features</a>
                <a href="#" class="text-sm font-medium text-gray-600 hover:text-gray-900 press-effect transition-colors">Solutions</a>
                <a href="#" class="text-sm font-medium text-gray-600 hover:text-gray-900 press-effect transition-colors">Pricing</a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 press-effect transition-colors">Log In</a>
                <a href="/register" class="text-sm font-medium bg-black text-white px-4 py-2 rounded-full hover:bg-gray-800 press-effect transition-colors">
                    Get Started
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow pt-32 pb-24">
        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-6 flex flex-col items-center text-center mt-12 mb-32">
            <div class="inline-flex items-center gap-2 bg-gray-100 text-gray-800 px-4 py-1.5 rounded-full text-sm font-medium mb-8 stagger-1">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                The Future of Clinic Management
            </div>

            <h1 class="display-text text-5xl md:text-7xl font-bold max-w-4xl text-gray-900 mb-6 stagger-2">
                Run your clinic with <br class="hidden md:block"/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">fluid intelligence.</span>
            </h1>

            <p class="body-text text-lg md:text-xl text-gray-500 max-w-2xl mx-auto mb-10 stagger-3">
                Streamline workflows, enhance patient care, and automate operations with our liquid-smooth, intelligent platform designed for modern medical practices.
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-4 stagger-4">
                <a href="/register" class="w-full sm:w-auto bg-black text-white px-8 py-3.5 rounded-full font-medium text-base press-effect transition-colors hover:bg-gray-800 shadow-lg shadow-gray-200">
                    Start for free
                </a>
                <a href="#features" class="w-full sm:w-auto bg-white text-gray-900 border border-gray-200 px-8 py-3.5 rounded-full font-medium text-base press-effect transition-colors hover:bg-gray-50 shadow-sm">
                    Explore Features
                </a>
            </div>
        </section>

        <!-- Features Bento Grid -->
        <section id="features" class="max-w-7xl mx-auto px-6 mb-32 pt-16">
            <div class="text-center mb-16 stagger-1">
                <h2 class="display-text text-3xl md:text-4xl font-bold text-gray-900 mb-4">Intelligent Architecture</h2>
                <p class="body-text text-gray-500 max-w-2xl mx-auto">Designed to reduce cognitive load and accelerate clinical decision making.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="glass-card rounded-3xl p-8 flex flex-col h-full stagger-2 relative overflow-hidden group">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center mb-8 text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3 display-text">Smart Patient Records</h3>
                    <p class="body-text text-gray-500 text-sm mt-auto">Context-aware timeline views and predictive analytics for comprehensive patient histories.</p>
                </div>

                <!-- Feature 2 -->
                <div class="glass-card rounded-3xl p-8 flex flex-col h-full stagger-3 relative overflow-hidden">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center mb-8 text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3 display-text">Automated Appointments</h3>
                    <p class="body-text text-gray-500 text-sm mt-auto">AI-driven scheduling that optimizes clinic throughput and minimizes patient wait times.</p>
                </div>

                <!-- Feature 3 -->
                <div class="glass-card rounded-3xl p-8 flex flex-col h-full stagger-4 relative overflow-hidden">
                    <div class="w-12 h-12 rounded-2xl bg-teal-50 flex items-center justify-center mb-8 text-teal-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3 display-text">Telegram Bot Integration</h3>
                    <p class="body-text text-gray-500 text-sm mt-auto">Seamless asynchronous communication with patients via secure, automated messaging channels.</p>
                </div>
            </div>
        </section>

        <!-- Showcase Section -->
        <section class="max-w-7xl mx-auto px-6 mb-24">
             <div class="glass-card rounded-[2.5rem] p-8 md:p-16 flex flex-col lg:flex-row items-center gap-12 lg:gap-24 overflow-hidden relative border-0 bg-white">
                <!-- Soft Glow -->
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-50 pointer-events-none"></div>

                <div class="w-full lg:w-1/2 flex flex-col stagger-2 relative z-10">
                    <span class="text-sm font-semibold text-blue-600 uppercase tracking-widest mb-4">Clinical Workflow</span>
                    <h2 class="display-text text-3xl md:text-5xl font-bold text-gray-900 mb-6">Seamless Handoffs, Zero Friction.</h2>
                    <p class="body-text text-lg text-gray-500 mb-8">
                        Experience a UI that disappears when you don't need it and surfaces critical information exactly when you do. Atlas ensures that data flows effortlessly between departments.
                    </p>
                    <ul class="flex flex-col gap-4">
                        <li class="flex items-center gap-3 text-gray-600 body-text">
                            <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            End-to-end encryption for all data in transit.
                        </li>
                        <li class="flex items-center gap-3 text-gray-600 body-text">
                            <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            Real-time sync across all clinical devices.
                        </li>
                    </ul>
                </div>

                <div class="w-full lg:w-1/2 relative stagger-3 z-10">
                    <div class="aspect-[4/3] rounded-3xl overflow-hidden bg-gray-100 relative shadow-2xl border border-gray-200/50">
                        <img src="https://encrypted-tbn0.gstatic.com/licensed-image?q=tbn:ANd9GcTsjipy1Swzv-mNCDcgc_hqD-8bbvAubIrvXQ_Or8axJLCJ_0Amcsb11OVrhzirCuP9jdKXxFOGRwJ5UTg" alt="Doctor App" class="w-full h-full object-cover">
                        <!-- Floating element -->
                        <div class="absolute bottom-6 left-6 right-6 md:left-auto md:right-[-2rem] bg-white/90 backdrop-blur-xl p-4 rounded-2xl shadow-xl border border-gray-100 flex items-center gap-4 animate-[smoothEnter_1s_var(--ease-out)_1s_both]">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Transfer Complete</p>
                                <p class="text-xs text-gray-500 mt-0.5">Records transferred to Cardiology.</p>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-100 bg-white">
        <div class="max-w-7xl mx-auto px-6 py-12 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2 grayscale opacity-60">
                <img src="{{ asset('images/logo-text.png') }}" alt="Atlas Logo" class="h-6 auto">
            </div>
            <div class="flex gap-8">
                <a href="#" class="text-sm text-gray-500 hover:text-gray-900 press-effect transition-colors">Privacy</a>
                <a href="#" class="text-sm text-gray-500 hover:text-gray-900 press-effect transition-colors">Terms</a>
                <a href="#" class="text-sm text-gray-500 hover:text-gray-900 press-effect transition-colors">Security</a>
            </div>
            <p class="text-sm text-gray-400">
                &copy; {{ date('Y') }} Atlas Medical Systems.
            </p>
        </div>
    </footer>

</body>
</html>