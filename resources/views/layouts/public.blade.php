<!doctype html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Victory Arena | Premier Futsal Stadium & Booking')</title>

    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <style>
        :root {
            --primary-red: #e50914;
            --primary-red-hover: #f40612;
            --primary-red-active: #b80710;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #0b0e14;
            color: #f1f5f9;
            overflow-x: hidden;
            -webkit-tap-highlight-color: transparent;
        }

        /* Ambient Glow & Backdrop */
        .glass-nav {
            background: rgba(15, 20, 29, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Modern Button Styles & Ripple Container */
        .btn-primary-saas {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #e50914 0%, #b80710 100%);
            box-shadow: 0 4px 20px -2px rgba(229, 9, 20, 0.45);
            transition: transform 0.18s cubic-bezier(0.4, 0, 0.2, 1), 
                        box-shadow 0.18s cubic-bezier(0.4, 0, 0.2, 1),
                        background-color 0.18s ease;
            cursor: pointer;
            user-select: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* Hover Elevation */
        .btn-primary-saas:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -2px rgba(229, 9, 20, 0.6);
            background: linear-gradient(135deg, #f40612 0%, #c40812 100%);
        }

        /* Active / Pressed State */
        .btn-primary-saas:active {
            transform: translateY(1px) scale(0.97);
            box-shadow: 0 2px 10px rgba(229, 9, 20, 0.4);
            background: var(--primary-red-active);
        }

        /* Button Secondary Outline Style */
        .btn-secondary-saas {
            position: relative;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.14);
            color: #ffffff;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            user-select: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .btn-secondary-saas:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .btn-secondary-saas:active {
            transform: translateY(1px) scale(0.97);
            background: rgba(255, 255, 255, 0.12);
        }

        /* Ripple Wave Effect Animation */
        .btn-ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.45);
            transform: scale(0);
            animation: ripple-animation 600ms linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Premium Court Cards */
        .saas-card {
            background: #131720;
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 18px;
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), 
                        border-color 0.25s ease, 
                        box-shadow 0.25s ease;
        }

        .saas-card:hover {
            transform: translateY(-4px);
            border-color: rgba(229, 9, 20, 0.4);
            box-shadow: 0 16px 36px -10px rgba(0, 0, 0, 0.7), 
                        0 0 20px 0 rgba(229, 9, 20, 0.15);
        }

        /* Mobile Image Fallback Styling */
        .court-img-holder {
            background: linear-gradient(135deg, #1e2430 0%, #161b24 100%);
        }
    </style>
</head>

<body class="bg-[#0b0e14] text-slate-100 antialiased selection:bg-red-600 selection:text-white min-h-screen flex flex-col">

    {{-- Top Announcement Bar --}}
    <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-800 text-white text-[11px] md:text-xs font-bold tracking-widest text-center py-2 px-4 shadow-md uppercase">
        <i class="fa-solid fa-trophy mr-1 text-yellow-300"></i> The Official Booking Portal of Victory Arena &bull; One Team, One Dream
    </div>

    {{-- Modern SaaS Navigation --}}
    <header class="sticky top-0 z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                {{-- Logo Section --}}
                <a href="{{ url('/') }}" class="flex items-center gap-3.5 group">
                    <div class="relative w-11 h-11 flex items-center justify-center rounded-xl bg-gradient-to-br from-red-600 to-red-900 border border-white/10 shadow-lg group-hover:scale-105 transition-transform duration-300 overflow-hidden">
                        <img src="{{ asset('images/logo.png') }}" 
                             alt="Victory Arena Logo" 
                             class="w-full h-full object-contain p-1"
                             onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'fa-solid fa-futbol text-white text-xl\'></i>';">
                    </div>
                    <div>
                        <div class="text-xl font-extrabold tracking-tight text-white flex items-center gap-1 leading-tight">
                            VICTORY <span class="text-red-500">ARENA</span>
                        </div>
                        <div class="text-[10px] font-semibold tracking-widest text-slate-400 uppercase">
                            Stadium & Booking
                        </div>
                    </div>
                </a>

                {{-- Desktop Menu --}}
                <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-300">
                    <a href="{{ url('/') }}" class="hover:text-white transition-colors duration-200">HOME</a>
                    <a href="#arena" class="hover:text-white transition-colors duration-200">ARENA & JADWAL</a>
                    <a href="#harga" class="hover:text-white transition-colors duration-200">DAFTAR HARGA</a>
                    <a href="#fasilitas" class="hover:text-white transition-colors duration-200">FASILITAS</a>
                    <a href="#kontak" class="hover:text-white transition-colors duration-200">KONTAK</a>
                </nav>

                {{-- Action Login Button with Ripple Effect --}}
                <div class="flex items-center gap-3">
                    <a href="{{ url('/login') }}" 
                       class="btn-primary-saas px-5 py-2.5 rounded-full text-xs md:text-sm font-bold tracking-wide text-white">
                        <i class="fa-solid fa-circle-user mr-2 text-white/90"></i>
                        MASUK / LOGIN
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Dynamic Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-white/5 bg-[#080a0e] py-8 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} Victory Arena Futsal System. All rights reserved.</p>
    </footer>

    {{-- Ripple Wave Effect Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const rippleElements = document.querySelectorAll('.btn-primary-saas, .btn-secondary-saas, .btn-ripple-trigger');

            rippleElements.forEach(btn => {
                btn.addEventListener('pointerdown', function (e) {
                    const rect = this.getBoundingClientRect();
                    const circle = document.createElement('span');
                    const diameter = Math.max(rect.width, rect.height);
                    const radius = diameter / 2;

                    circle.style.width = circle.style.height = `${diameter}px`;
                    circle.style.left = `${e.clientX - rect.left - radius}px`;
                    circle.style.top = `${e.clientY - rect.top - radius}px`;
                    circle.classList.add('btn-ripple');

                    const ripple = this.querySelector('.btn-ripple');
                    if (ripple) {
                        ripple.remove();
                    }

                    this.appendChild(circle);

                    setTimeout(() => {
                        circle.remove();
                    }, 600);
                });
            });
        });
    </script>
</body>
</html>