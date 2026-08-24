<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Atlas Medical System</title>
<!-- Material Symbols -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Tailwind Config -->
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface-variant": "#e3e2e7",
                        "background": "#faf9fe",
                        "on-tertiary-container": "#fdfcff",
                        "on-primary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary-container": "#fffbff",
                        "surface-container-highest": "#e3e2e7",
                        "on-surface-variant": "#414755",
                        "tertiary-fixed": "#e2e2e7",
                        "surface": "#faf9fe",
                        "on-primary-container": "#fefcff",
                        "secondary": "#4c4aca",
                        "on-primary-fixed-variant": "#004493",
                        "surface-bright": "#faf9fe",
                        "error": "#ba1a1a",
                        "on-tertiary-fixed-variant": "#45474b",
                        "inverse-on-surface": "#f1f0f5",
                        "on-background": "#1a1b1f",
                        "on-tertiary": "#ffffff",
                        "surface-tint": "#005bc1",
                        "on-tertiary-fixed": "#1a1c1f",
                        "tertiary": "#5a5c60",
                        "surface-container-low": "#f4f3f8",
                        "surface-container": "#eeedf3",
                        "primary": "#0058bc",
                        "primary-container": "#0070eb",
                        "inverse-primary": "#adc6ff",
                        "outline": "#717786",
                        "on-secondary": "#ffffff",
                        "primary-fixed": "#d8e2ff",
                        "secondary-container": "#6664e4",
                        "surface-container-high": "#e9e7ed",
                        "error-container": "#ffdad6",
                        "secondary-fixed-dim": "#c2c1ff",
                        "on-error-container": "#93000a",
                        "tertiary-fixed-dim": "#c6c6cb",
                        "on-primary-fixed": "#001a41",
                        "on-secondary-fixed-variant": "#3631b4",
                        "on-secondary-fixed": "#0c006a",
                        "surface-dim": "#dad9df",
                        "primary-fixed-dim": "#adc6ff",
                        "tertiary-container": "#737479",
                        "outline-variant": "#c1c6d7",
                        "inverse-surface": "#2f3034",
                        "on-error": "#ffffff",
                        "on-surface": "#1a1b1f",
                        "secondary-fixed": "#e2dfff"
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px",
                        "2xl": "1.5rem",
                        "3xl": "2rem"
                    },
                    spacing: {
                        "lg": "24px",
                        "xl": "40px",
                        "sm": "8px",
                        "unit": "4px",
                        "md": "16px",
                        "gutter": "24px",
                        "margin-desktop": "48px",
                        "margin-mobile": "16px",
                        "xs": "4px",
                        "container-max": "1440px",
                        "xxl": "64px",
                        "3xl": "96px",
                        "4xl": "128px"
                    },
                    fontFamily: {
                        "display-lg": ["Inter", "sans-serif"],
                        "headline-md": ["Inter", "sans-serif"],
                        "headline-lg-mobile": ["Inter", "sans-serif"],
                        "body-lg": ["Inter", "sans-serif"],
                        "body-md": ["Inter", "sans-serif"],
                        "label-md": ["Inter", "sans-serif"],
                        "headline-lg": ["Inter", "sans-serif"],
                        "body-sm": ["Inter", "sans-serif"]
                    },
                    fontSize: {
                        "display-lg": ["48px", { lineHeight: "56px", letterSpacing: "-0.02em", fontWeight: "700" }],
                        "headline-md": ["24px", { lineHeight: "32px", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "headline-lg-mobile": ["24px", { lineHeight: "32px", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "body-lg": ["18px", { lineHeight: "28px", fontWeight: "400" }],
                        "body-md": ["16px", { lineHeight: "24px", fontWeight: "400" }],
                        "label-md": ["12px", { lineHeight: "16px", letterSpacing: "0.05em", fontWeight: "600" }],
                        "headline-lg": ["32px", { lineHeight: "40px", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "body-sm": ["14px", { lineHeight: "20px", fontWeight: "400" }]
                    },
                    boxShadow: {
                        'glass': '0 4px 30px rgba(0, 0, 0, 0.1)',
                        'glass-inner': 'inset 0 0 0 1px rgba(255, 255, 255, 0.4)',
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                    }
                },
            },
        }
    </script>
<!-- Liquid Glass Styles -->
<style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: theme('colors.background');
            color: theme('colors.on-background');
            overflow-x: hidden;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .glass-floating {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(50px);
            -webkit-backdrop-filter: blur(50px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        .btn-primary {
            background-color: theme('colors.primary');
            color: theme('colors.on-primary');
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: theme('colors.primary-container');
            transform: translateY(-2px);
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid theme('colors.primary');
            color: theme('colors.primary');
            transition: all 0.3s ease;
        }

        .btn-glass:hover {
            background: theme('colors.primary');
            color: theme('colors.on-primary');
        }

        /* Ambient Glow Effect */
        .ambient-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.5;
            z-index: -1;
            pointer-events: none;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col relative">
<!-- TopAppBar -->
<header class="fixed top-0 w-full z-50 backdrop-blur-xl bg-white/70 border-b border-white/40 shadow-sm transition-all duration-300">
<div class="flex justify-between items-center h-16 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
<div class="flex items-center gap-md">
<img src="{{ asset('images/logo-text.png') }}" alt="Atlas Logo" class="h-10 auto">
</div>
<nav class="hidden md:flex gap-lg items-center">
<a class="text-on-surface-variant font-label-md text-label-md hover:text-primary transition-colors duration-300" href="#">Features</a>
<a class="text-on-surface-variant font-label-md text-label-md hover:text-primary transition-colors duration-300" href="#">Solutions</a>
<a class="text-on-surface-variant font-label-md text-label-md hover:text-primary transition-colors duration-300" href="#">Pricing</a>
</nav>
<div class="flex items-center gap-sm">
    <a class="text-on-surface-variant font-label-md text-label-md hover:text-primary transition-colors duration-300 mr-sm" href="{{ route('login') }}">تسجيل الدخول</a>
    <a class="flex items-center gap-sm bg-primary/10 text-primary px-md py-sm rounded-full font-label-md text-label-md hover:bg-primary hover:text-on-primary transition-colors duration-300 active:scale-95" href="/register">
        <span>Get Started</span>
        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
    </a>
</div>
</div>
</header>
<main class="flex-grow pt-[80px]">
<!-- Hero Section -->
<section class="relative w-full min-h-[90vh] flex items-center justify-center px-margin-mobile md:px-margin-desktop py-xxl overflow-hidden">
<!-- Background Image -->
<div class="absolute inset-0 z-0">
<img alt="Hero background" class="w-full h-full object-cover object-center opacity-80" src="https://encrypted-tbn1.gstatic.com/licensed-image?q=tbn:ANd9GcTMHz2wRSDh48kYnOlQXVw1mNAUSsxcFtwrQrCTjdIupXkMcnsNKe8YOForQkgzi_12rwHmxfu3Ka11wio"/>
<!-- Overlay gradient to ensure text readability -->
<div class="absolute inset-0 bg-gradient-to-b from-background/40 via-background/20 to-background/90"></div>
</div>
<!-- Floating Glass Card Content -->
<div class="relative z-10 w-full max-w-3xl mx-auto glass-floating rounded-3xl p-xl md:p-3xl text-center flex flex-col items-center gap-lg">
<div class="inline-flex items-center gap-sm bg-primary/10 text-primary px-md py-xs rounded-full font-label-md text-label-md mb-md">
<span class="material-symbols-outlined text-[16px]">stars</span>
<span>New Era of Clinic Management</span>
</div>
<h1 class="font-headline-lg-mobile md:font-display-lg text-headline-lg-mobile md:text-display-lg text-on-surface max-w-2xl leading-tight">
                    Atlas Medical System:<br/>
<span class="text-primary bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">The Future of Clinic Management</span>
</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl mx-auto mt-sm">
                    Streamline workflows, enhance patient care, and automate operations with our liquid-smooth, intelligent platform.
                </p>
<div class="mt-xl flex flex-col sm:flex-row gap-md w-full sm:w-auto">
<a class="btn-primary rounded-xl px-xl py-md font-label-md text-label-md flex items-center justify-center gap-sm shadow-lg shadow-primary/30" href="/register">
                        Get Started
                        <span class="material-symbols-outlined text-[20px]">rocket_launch</span>
</a>
<a class="btn-glass rounded-xl px-xl py-md font-label-md text-label-md flex items-center justify-center gap-sm" href="{{ route('login') }}">
                        Login <span class="material-symbols-outlined text-[20px]">login</span>
</a>
<a class="btn-glass rounded-xl px-xl py-md font-label-md text-label-md flex items-center justify-center gap-sm" href="#features">
                        Explore Features
                    </a>
</div>
</div>
</section>
<!-- Features Section (Bento Grid Style) -->
<section class="py-3xl px-margin-mobile md:px-margin-desktop relative" id="features">
<div class="ambient-glow bg-secondary/20 w-[600px] h-[600px] top-0 left-[-200px]"></div>
<div class="max-w-container-max mx-auto">
<div class="text-center mb-xxl">
<h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-md">Intelligent Architecture</h2>
<p class="font-body-md text-body-md text-on-surface-variant max-w-2xl mx-auto">Designed to reduce cognitive load and accelerate clinical decision making.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
<!-- Feature 1 -->
<div class="glass-panel rounded-2xl p-xl flex flex-col h-full hover:-translate-y-2 transition-transform duration-300">
<div class="w-14 h-14 rounded-xl bg-primary-container/20 text-primary flex items-center justify-center mb-lg">
<span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">medical_information</span>
</div>
<h3 class="font-headline-md text-headline-md text-on-surface mb-sm">Smart Patient Records</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-auto">Context-aware timeline views and predictive analytics for comprehensive patient histories.</p>
</div>
<!-- Feature 2 -->
<div class="glass-panel rounded-2xl p-xl flex flex-col h-full hover:-translate-y-2 transition-transform duration-300">
<div class="w-14 h-14 rounded-xl bg-secondary-container/20 text-secondary flex items-center justify-center mb-lg">
<span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">calendar_month</span>
</div>
<h3 class="font-headline-md text-headline-md text-on-surface mb-sm">Automated Appointments</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-auto">AI-driven scheduling that optimizes clinic throughput and minimizes patient wait times.</p>
</div>
<!-- Feature 3 -->
<div class="glass-panel rounded-2xl p-xl flex flex-col h-full hover:-translate-y-2 transition-transform duration-300">
<div class="w-14 h-14 rounded-xl bg-surface-tint/20 text-surface-tint flex items-center justify-center mb-lg">
<span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">smart_toy</span>
</div>
<h3 class="font-headline-md text-headline-md text-on-surface mb-sm">Telegram Bot Integration</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-auto">Seamless asynchronous communication with patients via secure, automated messaging channels.</p>
</div>
</div>
</div>
</section>
<!-- Showcase Section -->
<section class="py-3xl px-margin-mobile md:px-margin-desktop relative overflow-hidden bg-surface-container-lowest">
<div class="ambient-glow bg-primary/10 w-[800px] h-[800px] bottom-[-200px] right-[-200px]"></div>
<div class="max-w-container-max mx-auto flex flex-col lg:flex-row items-center gap-xxl">
<div class="w-full lg:w-1/2 relative rounded-3xl overflow-hidden shadow-2xl">
<img alt="Doctor using tablet" class="w-full h-auto object-cover rounded-3xl" src="https://encrypted-tbn0.gstatic.com/licensed-image?q=tbn:ANd9GcTsjipy1Swzv-mNCDcgc_hqD-8bbvAubIrvXQ_Or8axJLCJ_0Amcsb11OVrhzirCuP9jdKXxFOGRwJ5UTg"/>
<!-- Floating Notification UI -->
<div class="absolute bottom-lg right-lg lg:-right-lg z-20 glass-floating rounded-xl p-md flex items-center gap-md max-w-[300px] animate-[slideUp_1s_ease-out]">
<div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
</div>
<div>
<p class="font-label-md text-label-md text-on-surface mb-xs">Transfer Complete</p>
<p class="font-body-sm text-body-sm text-on-surface-variant text-xs">Patient records successfully securely transferred to Cardiology Dept.</p>
</div>
</div>
</div>
<div class="w-full lg:w-1/2 flex flex-col gap-lg">
<span class="font-label-md text-label-md text-primary tracking-widest uppercase">Clinical Workflow</span>
<h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Seamless Handoffs, Zero Friction.</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant">
                        Experience a UI that disappears when you don't need it and surfaces critical information exactly when you do. Atlas ensures that data flows effortlessly between departments, empowering your team to focus on what matters most: patient care.
                    </p>
<ul class="flex flex-col gap-md mt-md">
<li class="flex items-center gap-md text-on-surface-variant font-body-md">
<span class="material-symbols-outlined text-primary">done</span>
                            End-to-end encryption for all data in transit.
                        </li>
<li class="flex items-center gap-md text-on-surface-variant font-body-md">
<span class="material-symbols-outlined text-primary">done</span>
                            Real-time sync across all clinical devices.
                        </li>
</ul>
</div>
</div>
</section>
</main>
<!-- Footer -->
<footer class="bg-surface dark:bg-surface-dim w-full py-xl border-t border-outline-variant/30 mt-auto">
<div class="flex flex-col md:flex-row justify-between items-center px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto gap-lg">
<div class="text-headline-md font-headline-md text-primary flex items-center gap-sm">
<img src="{{ asset('images/logo-text.png') }}" alt="Atlas Logo" class="h-6 auto opacity-80 grayscale">
</div>
<nav class="flex flex-wrap justify-center gap-lg">
<a class="font-body-sm text-body-sm text-on-surface-variant hover:text-secondary transition-colors underline-offset-4 hover:underline" href="#">Privacy Policy</a>
<a class="font-body-sm text-body-sm text-on-surface-variant hover:text-secondary transition-colors underline-offset-4 hover:underline" href="#">Terms of Service</a>
<a class="font-body-sm text-body-sm text-on-surface-variant hover:text-secondary transition-colors underline-offset-4 hover:underline" href="#">Security</a>
<a class="font-body-sm text-body-sm text-on-surface-variant hover:text-secondary transition-colors underline-offset-4 hover:underline" href="#">Contact</a>
</nav>
<p class="font-body-sm text-body-sm text-on-surface-variant">© 2024 Atlas Medical Systems. All rights reserved.</p>
</div>
</footer>
<style>
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body></html>