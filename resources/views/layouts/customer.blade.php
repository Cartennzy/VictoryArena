<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Victory Arena | Customer Portal')</title>

    {{-- Tailwind & Font Awesome --}}
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, sans-serif;
            background-color: #080d1a;
            color: #f8fafc;
            min-height: 100vh;
        }

        /* Ripple Effect Universal */
        .btn-action {
            position: relative;
            overflow: hidden;
            user-select: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-action:hover {
            transform: translateY(-2px);
        }
        .btn-action:active {
            transform: translateY(2px) scale(0.97) !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3) !important;
        }
        .ripple-wave {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.45);
            pointer-events: none;
            transform: scale(0);
            animation: rippleAnim 0.65s cubic-bezier(0, 0, 0.2, 1);
        }
        @keyframes rippleAnim {
            0% { transform: scale(0); opacity: 0.6; }
            100% { transform: scale(3.5); opacity: 0; }
        }
    </style>
</head>
<body class="bg-[#080d1a] min-h-screen">

    {{-- SIDEBAR COMPONENT --}}
    @include('partials.customer.sidebar')

    {{-- KONTEN UTAMA DENGAN JARAK DARI SIDEBAR (md:pl-72) --}}
    <div class="md:pl-72 flex flex-col min-h-screen transition-all duration-300">
        
        {{-- NAVBAR ATAS --}}
        @include('partials.customer.navbar')

        {{-- MAIN CONTENT VIEW --}}
        <main class="flex-grow p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        @include('partials.customer.footer')
    </div>

    {{-- Universal Ripple Script --}}
    <script>
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-action');
            if (!btn || btn.hasAttribute('disabled')) return;

            const rect = btn.getBoundingClientRect();
            const ripple = document.createElement('span');

            const diameter = Math.max(rect.width, rect.height);
            const radius = diameter / 2;

            ripple.style.width = ripple.style.height = `${diameter}px`;
            ripple.style.left = `${e.clientX - rect.left - radius}px`;
            ripple.style.top = `${e.clientY - rect.top - radius}px`;
            ripple.classList.add('ripple-wave');

            const prevRipple = btn.querySelector('.ripple-wave');
            if (prevRipple) prevRipple.remove();

            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 650);
        });
    </script>
</body>
</html>