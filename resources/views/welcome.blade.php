<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atlas Medical System</title>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                        primary: '#0058bc',
                        'primary-dark': '#004493',
                        surface: '#fbfbfe',
                    }
                }
            }
        }
    </script>
    <!-- Staggered Entrance Animations & Global Styles -->
    <style>
        body {
            background-color: #fbfbfe;
            color: #1a1b1f;
        }

        /* Apple-like fluid easing curve */
        :root {
            --apple-ease: cubic-bezier(0.25, 1, 0.5, 1);
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-stagger-1 {
            animation: fadeInUp 0.8s var(--apple-ease) forwards;
            opacity: 0;
            animation-delay: 0.1s;
        }
        .animate-stagger-2 {
            animation: fadeInUp 0.8s var(--apple-ease) forwards;
            opacity: 0;
            animation-delay: 0.2s;
        }
        .animate-stagger-3 {
            animation: fadeInUp 0.8s var(--apple-ease) forwards;
            opacity: 0;
            animation-delay: 0.3s;
        }
        .animate-stagger-4 {
            animation: fadeInUp 0.8s var(--apple-ease) forwards;
            opacity: 0;
            animation-delay: 0.4s;
        }
        .animate-stagger-5 {
            animation: fadeInUp 0.8s var(--apple-ease) forwards;
            opacity: 0;
            animation-delay: 0.5s;
        }
        .animate-stagger-6 {
            animation: fadeInUp 0.8s var(--apple-ease) forwards;
            opacity: 0;
            animation-delay: 0.6s;
        }

        /* Glassmorphism utility */
        .glass {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 1);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
            border-radius: 1.5rem;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col relative overflow-x-hidden font-sans">

    <!-- Top Navigation (Glassmorphism) -->
    <header class="fixed top-0 w-full z-50 glass transition-all duration-300">
        <div class="flex justify-between items-center h-16 px-6 md:px-12 max-w-7xl mx-auto">
            <div class="flex items-center gap-2 cursor-pointer active:scale-[0.97] transition-transform duration-200">
                <img src="{{ asset('images/logo-text.png') }}" alt="Atlas Logo" class="h-8 w-auto">
            </div>
            <nav class="hidden md:flex gap-8 items-center">
                <a class="text-sm font-medium text-gray-600 hover:text-primary active:scale-[0.97] transition-all duration-200" href="#features">Features</a>
                <a class="text-sm font-medium text-gray-600 hover:text-primary active:scale-[0.97] transition-all duration-200" href="#solutions">Solutions</a>
                <a class="text-sm font-medium text-gray-600 hover:text-primary active:scale-[0.97] transition-all duration-200" href="#pricing">Pricing</a>
            </nav>
            <div class="flex items-center gap-4">
                <a class="text-sm font-medium text-gray-600 hover:text-primary active:scale-[0.97] transition-all duration-200" href="{{ route('login') }}">Login</a>
                <a class="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-full text-sm font-medium hover:bg-primary-dark active:scale-[0.97] transition-all duration-200 shadow-sm shadow-primary/30" href="/register">
                    <span>Get Started</span>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow pt-32 pb-24">
        <!-- Hero Section -->
        <section class="relative w-full min-h-[75vh] flex flex-col items-center justify-center px-6 md:px-12 text-center overflow-visible">

            <!-- Decorative background elements -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-blue-100 rounded-full blur-[120px] opacity-50 -z-10 pointer-events-none"></div>

            <div class="max-w-4xl mx-auto flex flex-col items-center">
                <!-- Tag -->
                <div class="animate-stagger-1 inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-primary px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider mb-8 shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">stars</span>
                    <span>The Future of Clinic Management</span>
                </div>

                <!-- Main Heading with Negative Tracking -->
                <h1 class="animate-stagger-2 text-5xl md:text-7xl font-bold text-gray-900 tracking-tighter leading-[1.1] mb-6">
                    Redefining clinical excellence <br class="hidden md:block"/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-400">with intelligence.</span>
                </h1>

                <!-- Body text with Neutral Tracking -->
                <p class="animate-stagger-3 text-lg md:text-xl text-gray-500 tracking-normal max-w-2xl leading-relaxed mb-10 font-light">
                    Atlas is the premium operating system for modern medical practices. Streamline your workflows, automate scheduling, and enhance patient care effortlessly.
                </p>

                <!-- CTA Buttons with Physical Interactions -->
                <div class="animate-stagger-4 flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <a class="bg-gray-900 text-white rounded-full px-8 py-3.5 text-base font-medium flex items-center justify-center gap-2 shadow-lg shadow-gray-900/20 hover:bg-gray-800 active:scale-[0.97] transition-all duration-200" href="/register">
                        Start your journey
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                    <a class="bg-white text-gray-900 border border-gray-200 rounded-full px-8 py-3.5 text-base font-medium flex items-center justify-center gap-2 shadow-sm hover:bg-gray-50 active:scale-[0.97] transition-all duration-200" href="{{ route('login') }}">
                        Login to workspace
                    </a>
                </div>
            </div>
        </section>

        <!-- Features Bento Grid -->
        <section class="py-24 px-6 md:px-12 max-w-7xl mx-auto" id="features">
            <div class="text-center mb-16 animate-stagger-5">
                <h2 class="text-3xl md:text-4xl font-semibold text-gray-900 tracking-tight mb-4">Crafted for perfection.</h2>
                <p class="text-gray-500 text-lg font-light tracking-normal max-w-2xl mx-auto">Every interaction in Atlas is designed to reduce friction and elevate your clinic's daily operations to new heights.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="animate-stagger-6 glass-card p-8 flex flex-col items-start hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-primary flex items-center justify-center mb-6 shadow-inner">
                        <span class="material-symbols-outlined text-[24px]">clinical_notes</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 tracking-tight mb-3">Intelligent Records</h3>
                    <p class="text-gray-500 text-sm leading-relaxed tracking-normal">Context-aware timeline views that adapt to your medical specialty, reducing cognitive load.</p>
                </div>

                <!-- Card 2 -->
                <div class="animate-stagger-6 glass-card p-8 flex flex-col items-start hover:-translate-y-1 transition-transform duration-300" style="animation-delay: 0.7s;">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6 shadow-inner">
                        <span class="material-symbols-outlined text-[24px]">event_available</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 tracking-tight mb-3">Fluid Scheduling</h3>
                    <p class="text-gray-500 text-sm leading-relaxed tracking-normal">A beautiful, drag-and-drop interface that makes managing multiple doctors feel like magic.</p>
                </div>

                <!-- Card 3 -->
                <div class="animate-stagger-6 glass-card p-8 flex flex-col items-start hover:-translate-y-1 transition-transform duration-300" style="animation-delay: 0.8s;">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6 shadow-inner">
                        <span class="material-symbols-outlined text-[24px]">auto_awesome</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 tracking-tight mb-3">Smart Automations</h3>
                    <p class="text-gray-500 text-sm leading-relaxed tracking-normal">Let our system handle reminders, billing, and follow-ups while you focus on care.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="glass border-t border-gray-200/50 mt-auto">
        <div class="max-w-7xl mx-auto px-6 md:px-12 py-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo-text.png') }}" alt="Atlas Logo" class="h-6 w-auto grayscale opacity-60">
            </div>
            <nav class="flex gap-8">
                <a class="text-sm text-gray-500 hover:text-gray-900 active:scale-[0.97] transition-all duration-200" href="#">Privacy</a>
                <a class="text-sm text-gray-500 hover:text-gray-900 active:scale-[0.97] transition-all duration-200" href="#">Terms</a>
                <a class="text-sm text-gray-500 hover:text-gray-900 active:scale-[0.97] transition-all duration-200" href="#">Contact</a>
            </nav>
            <p class="text-sm text-gray-400">&copy; 2024 Atlas Medical System.</p>
        </div>
    </footer>

</body>
</html>
