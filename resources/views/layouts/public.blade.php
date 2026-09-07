<!doctype html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Victory Arena | Reservasi Futsal')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>

<body class="bg-[#080d1a] text-slate-100 antialiased selection:bg-red-600 selection:text-white">

    @yield('content')

    {{-- Script Universal Efek Ripple & Klik --}}
    <script>
        document.addEventListener('pointerdown', function (e) {
            const btn = e.target.closest('.btn-action');
            if (!btn || btn.hasAttribute('disabled')) return;

            const rect = btn.getBoundingClientRect();
            const circle = document.createElement('span');
            const diameter = Math.max(rect.width, rect.height);
            const radius = diameter / 2;

            circle.style.width = circle.style.height = `${diameter}px`;
            circle.style.left = `${e.clientX - rect.left - radius}px`;
            circle.style.top = `${e.clientY - rect.top - radius}px`;
            circle.classList.add('ripple-wave');

            const oldRipple = btn.querySelector('.ripple-wave');
            if (oldRipple) oldRipple.remove();

            btn.appendChild(circle);

            setTimeout(() => {
                circle.remove();
            }, 650);
        });
    </script>
</body>
</html>