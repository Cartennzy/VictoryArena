<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard | Victory Arena')</title>

    {{-- Tailwind CSS & FontAwesome --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .font-sports {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            letter-spacing: -0.025em;
        }

        /* Micro-Interactions & Button States */
        .btn-action {
            position: relative;
            overflow: hidden;
            user-select: none;
            transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .btn-action:hover {
            transform: translateY(-2px);
        }
        .btn-action:active {
            transform: translateY(2px) scale(0.98) !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4) !important;
        }

        /* Ripple Wave Effect */
        .ripple-wave {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.45);
            pointer-events: none;
            transform: scale(0);
            animation: rippleAnim 0.65s cubic-bezier(0, 0, 0.2, 1);
        }
        @keyframes rippleAnim {
            0% { transform: scale(0); opacity: 0.7; }
            100% { transform: scale(3.5); opacity: 0; }
        }

        /* Scrollbar Halus */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #080d1a;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #dc2626;
        }
    </style>
</head>
<body class="bg-[#080d1a] text-slate-100 font-sports min-h-screen selection:bg-red-600 selection:text-white">

    <div class="flex min-h-screen">
        {{-- Include Modular Admin Sidebar --}}
        @include('partials.admin.sidebar')

        {{-- Main Container (Offset Padding Left di Layar Desktop) --}}
        <div class="flex-1 flex flex-col min-w-0 md:pl-72">
            {{-- Include Modular Admin Top Navbar --}}
            @include('partials.admin.navbar')

            {{-- Main Dynamic Content --}}
            <main class="flex-1 p-5 sm:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Universal Ripple Script --}}
    <script>
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-action, .btn-action-primary');
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

            setTimeout(() => {
                ripple.remove();
            }, 650);
        });
    </script>
</body>
</html>