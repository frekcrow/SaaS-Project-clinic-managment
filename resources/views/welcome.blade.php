<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atlas OS - Mono</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:200,300,400,500,600,700,800,900" rel="stylesheet" />

    <!-- Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Typography overrides */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #000;
            color: #fff;
            -webkit-font-smoothing: antialiased;
        }

        /* Fluid Typography and Heavy Contrast */
        h1, h2, h3, h4 {
            letter-spacing: -0.04em;
            font-weight: 800;
        }

        .tracking-ultra-tight {
            letter-spacing: -0.06em;
        }

        .text-body {
            color: #888;
            font-weight: 400;
            letter-spacing: -0.01em;
        }

        /* Monochromatic palette overrides */
        .border-mono {
            border-color: #222;
        }

        .bg-mono-light {
            background-color: #111;
        }

        .bg-mono-lighter {
            background-color: #1a1a1a;
        }

        .text-mono-dark {
            color: #000;
        }

        .bg-mono-white {
            background-color: #fff;
        }

        /* Physical Interactions */
        .pressable {
            transition: transform 0.15s cubic-bezier(0.2, 0, 0, 1), background-color 0.15s ease, border-color 0.15s ease;
        }
        .pressable:active {
            transform: scale(0.97);
        }
        .pressable:hover {
            background-color: #1a1a1a;
            border-color: #333;
        }

        .btn-primary {
            transition: transform 0.15s cubic-bezier(0.2, 0, 0, 1), background-color 0.15s ease, filter 0.15s ease;
        }
        .btn-primary:active {
            transform: scale(0.97);
        }
        .btn-primary:hover {
            filter: brightness(0.9);
        }


        /* Staggered Animations */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
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
        .stagger-7 { animation-delay: 0.7s; }
        .stagger-8 { animation-delay: 0.8s; }


        /* Abstract Chart Styles */
        .chart-bar-container {
            display: flex;
            align-items: flex-end;
            gap: 4px;
            height: 60px;
        }

        .chart-bar {
            background-color: #333;
            width: 100%;
            border-radius: 2px 2px 0 0;
            transition: background-color 0.2s ease, height 0.5s ease;
        }

        .chart-bar.active {
            background-color: #fff;
        }

        .chart-bar:hover {
            background-color: #666;
        }

        .line-graph {
            width: 100%;
            height: 40px;
            position: relative;
            overflow: hidden;
        }

        .line-segment {
            position: absolute;
            height: 2px;
            background-color: #fff;
            transform-origin: left center;
        }

        /* Grid Background Pattern */
        .mono-grid {
             background-image: linear-gradient(#111 1px, transparent 1px), linear-gradient(90deg, #111 1px, transparent 1px);
             background-size: 32px 32px;
             background-position: center center;
        }

        /* Blur overlay for depth */
        .blur-overlay {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col relative overflow-x-hidden selection:bg-white selection:text-black">

    <!-- Grid Background -->
    <div class="fixed inset-0 mono-grid z-0 opacity-40 pointer-events-none"></div>

    <!-- Navigation -->
    <nav class="relative z-50 w-full pt-8 pb-4 px-6 md:px-12 max-w-[90rem] mx-auto flex justify-between items-center stagger-item stagger-1">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-white text-black flex items-center justify-center font-bold text-xl rounded-sm tracking-tighter">
                A
            </div>
            <span class="font-bold text-xl tracking-tight">Atlas</span>
        </div>
        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-[#888]">
            <a href="#" class="hover:text-white transition-colors">Features</a>
            <a href="#" class="hover:text-white transition-colors">Methodology</a>
            <a href="#" class="hover:text-white transition-colors">Enterprise</a>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="text-sm font-medium hover:text-gray-300 transition-colors">Log in</a>
            <a href="{{ route('register') }}" class="bg-mono-white text-mono-dark px-5 py-2 rounded-full text-sm font-bold btn-primary tracking-tight">Get Started</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="relative z-10 flex-grow flex flex-col items-center justify-center pt-20 pb-32 px-6">

        <!-- Hero Section -->
        <div class="max-w-4xl text-center mb-24 w-full">
            <div class="stagger-item stagger-2 inline-flex items-center gap-2 border border-mono bg-mono-light px-4 py-1.5 rounded-full text-xs font-medium tracking-wide mb-8 text-[#aaa]">
                <span class="w-2 h-2 rounded-full bg-white"></span>
                SYSTEM V2.0 LIVE
            </div>
            <h1 class="stagger-item stagger-3 text-6xl md:text-8xl tracking-ultra-tight leading-[1.05] mb-8">
                Absolute Clarity.
            </h1>
            <p class="stagger-item stagger-4 text-xl md:text-2xl text-body max-w-2xl mx-auto leading-relaxed mb-12">
                A surgical instrument for data. No distractions, no noise. Just pure monochromatic efficiency designed for focus.
            </p>
        </div>

        <!-- Dashboard Demo (Bento Grid) -->
        <div class="w-full max-w-[90rem] mx-auto stagger-item stagger-5">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 md:gap-6 auto-rows-[minmax(180px,_auto)]">

                <!-- Main KPI Card -->
                <div class="md:col-span-8 border border-mono bg-mono-light rounded-3xl p-8 md:p-10 flex flex-col justify-between pressable cursor-default group relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-12">
                            <div>
                                <h3 class="text-[#888] font-medium text-sm tracking-wide uppercase mb-2">Total Volume</h3>
                                <div class="text-5xl font-bold tracking-tighter">84,209</div>
                            </div>
                            <div class="bg-white/10 px-3 py-1 rounded-full text-white text-xs font-semibold">
                                +12.4%
                            </div>
                        </div>

                        <!-- Abstract Line Chart -->
                        <div class="line-graph w-full opacity-80 group-hover:opacity-100 transition-opacity">
                            <div class="line-segment" style="width: 20%; left: 0; bottom: 10px; transform: rotate(-15deg);"></div>
                            <div class="line-segment" style="width: 25%; left: 19%; bottom: 15px; transform: rotate(5deg);"></div>
                            <div class="line-segment" style="width: 30%; left: 43%; bottom: 10px; transform: rotate(-10deg);"></div>
                            <div class="line-segment" style="width: 35%; left: 72%; bottom: 20px; transform: rotate(-25deg);"></div>
                        </div>
                    </div>
                </div>

                <!-- Secondary KPI -->
                <div class="md:col-span-4 border border-mono bg-mono-light rounded-3xl p-8 flex flex-col justify-between pressable cursor-default">
                    <div>
                        <h3 class="text-[#888] font-medium text-sm tracking-wide uppercase mb-2">Active Sessions</h3>
                        <div class="text-4xl font-bold tracking-tighter">1,042</div>
                    </div>

                    <!-- Abstract Progress/Activity -->
                    <div class="mt-8 flex flex-col gap-3">
                        <div class="w-full h-1 bg-[#222] rounded-full overflow-hidden">
                            <div class="w-[70%] h-full bg-white rounded-full"></div>
                        </div>
                        <div class="w-full h-1 bg-[#222] rounded-full overflow-hidden">
                            <div class="w-[45%] h-full bg-[#888] rounded-full"></div>
                        </div>
                        <div class="w-full h-1 bg-[#222] rounded-full overflow-hidden">
                            <div class="w-[90%] h-full bg-[#555] rounded-full"></div>
                        </div>
                    </div>
                </div>

                <!-- Activity Chart -->
                <div class="md:col-span-6 border border-mono bg-mono-light rounded-3xl p-8 flex flex-col justify-between pressable cursor-default">
                     <h3 class="text-[#888] font-medium text-sm tracking-wide uppercase mb-6">Velocity</h3>
                     <div class="chart-bar-container w-full">
                         <div class="chart-bar" style="height: 30%;"></div>
                         <div class="chart-bar" style="height: 45%;"></div>
                         <div class="chart-bar active" style="height: 80%;"></div>
                         <div class="chart-bar" style="height: 60%;"></div>
                         <div class="chart-bar" style="height: 50%;"></div>
                         <div class="chart-bar" style="height: 90%;"></div>
                         <div class="chart-bar" style="height: 70%;"></div>
                         <div class="chart-bar" style="height: 40%;"></div>
                         <div class="chart-bar active" style="height: 100%;"></div>
                         <div class="chart-bar" style="height: 85%;"></div>
                         <div class="chart-bar" style="height: 65%;"></div>
                         <div class="chart-bar" style="height: 55%;"></div>
                     </div>
                </div>

                <!-- Status Block -->
                <div class="md:col-span-3 border border-mono bg-mono-light rounded-3xl p-8 flex flex-col items-center justify-center pressable cursor-default text-center">
                     <div class="w-16 h-16 rounded-full border-[4px] border-[#333] flex items-center justify-center mb-4 relative">
                          <div class="absolute inset-0 rounded-full border-[4px] border-white border-t-transparent border-l-transparent transform rotate-45"></div>
                          <span class="text-xl font-bold">99%</span>
                     </div>
                     <h3 class="text-white font-semibold text-lg tracking-tight">System Health</h3>
                     <p class="text-[#888] text-sm mt-1">All clusters nominal</p>
                </div>

                <!-- List/Log Block -->
                <div class="md:col-span-3 border border-mono bg-mono-light rounded-3xl p-6 flex flex-col pressable cursor-default overflow-hidden">
                     <h3 class="text-[#888] font-medium text-sm tracking-wide uppercase mb-4 px-2">Recent Events</h3>
                     <div class="flex flex-col gap-2">
                         <div class="flex items-center gap-3 p-2 rounded-lg bg-[#1a1a1a]">
                             <div class="w-2 h-2 rounded-full bg-white"></div>
                             <div class="flex-1 text-sm font-medium truncate">Node deployment</div>
                             <div class="text-xs text-[#666]">2m</div>
                         </div>
                         <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-[#1a1a1a] transition-colors">
                             <div class="w-2 h-2 rounded-full bg-[#555]"></div>
                             <div class="flex-1 text-sm font-medium text-[#aaa] truncate">Sync complete</div>
                             <div class="text-xs text-[#666]">14m</div>
                         </div>
                         <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-[#1a1a1a] transition-colors">
                             <div class="w-2 h-2 rounded-full bg-[#555]"></div>
                             <div class="flex-1 text-sm font-medium text-[#aaa] truncate">Backup verified</div>
                             <div class="text-xs text-[#666]">1h</div>
                         </div>
                     </div>
                </div>

            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="relative z-10 w-full border-t border-mono mt-auto bg-black blur-overlay">
        <div class="max-w-[90rem] mx-auto px-6 md:px-12 py-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm font-medium text-[#666]">
            <div class="flex items-center gap-2">
                 <div class="w-4 h-4 bg-white text-black flex items-center justify-center font-bold text-[8px] rounded-sm">A</div>
                 <span>Atlas OS</span>
            </div>
            <div>&copy; {{ date('Y') }} Monochrome Inc.</div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (prefersReducedMotion) {
                document.querySelectorAll('.stagger-item').forEach(el => {
                    el.style.animation = 'none';
                    el.style.opacity = '1';
                });
            }
        });
    </script>
</body>
</html>