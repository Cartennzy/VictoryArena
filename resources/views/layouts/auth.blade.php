<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title','Victory Arena')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* =====================================================
           BASE STYLE (ASLI KAMU – DIPERTAHANKAN)
        ====================================================== */
        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0b2447, #19376d);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0;
        }

        /* =====================================================
           WRAPPER PARALLAX (TAMBAHAN – TIDAK MENGGANTI APA PUN)
        ====================================================== */
        .auth-bg-wrap {
            position: fixed;
            inset: 0;
            z-index: -3;
            pointer-events: none;
            will-change: transform;
        }

        /* =====================================================
           SILK BACKGROUND – NAVY (ASLI KAMU)
        ====================================================== */
        .auth-bg {
            position: absolute;
            inset: -25%;
            background:
                radial-gradient(1200px circle at 15% 25%,
                    #09008a 0%, rgba(9,0,138,.55) 35%, transparent 65%),
                radial-gradient(1000px circle at 85% 70%,
                    #1b1f6b 0%, rgba(27,31,107,.45) 40%, transparent 70%),
                radial-gradient(900px circle at 50% 50%,
                    #050315 0%, #050315 60%);
            filter: blur(80px);
            animation: silkFlow 26s cubic-bezier(.45,0,.55,1) infinite alternate;
            will-change: transform;
        }

        @keyframes silkFlow {
            0%   { transform: translate3d(0,0,0) scale(1) rotate(0deg); }
            50%  { transform: translate3d(-4%,-3%,0) scale(1.12) rotate(1.2deg); }
            100% { transform: translate3d(-8%,-6%,0) scale(1.25) rotate(2.5deg); }
        }

        /* =====================================================
           NOISE / GRAIN (ASLI KAMU)
        ====================================================== */
        .auth-noise {
            position: fixed;
            inset: 0;
            z-index: -2;
            pointer-events: none;
            opacity: 0.025;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        }

        /* =====================================================
           AUTH CARD (ASLI KAMU)
        ====================================================== */
        .auth-card {
            background: rgba(255,255,255,.15);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(0,0,0,.25);
            color: #fff;
            position: relative;
            z-index: 1;
        }

        /* =====================================================
           LOGO LOGIN (ASLI KAMU)
        ====================================================== */
        .auth-logo-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 18px;
        }

        .auth-logo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            background: #ffffff;
            border: 3px solid rgba(255,255,255,.9);
            box-shadow:
                0 0 0 3px rgba(255,255,255,.35),
                0 0 18px 6px rgba(255,255,255,.45),
                0 12px 30px rgba(0,0,0,.35);
            transition: all .45s ease;
            position: relative;
            overflow: hidden;
        }

        .auth-logo::after {
            content: "";
            position: absolute;
            top: -60%;
            left: -60%;
            width: 220%;
            height: 220%;
            background: linear-gradient(
                120deg,
                transparent 40%,
                rgba(255,255,255,.85) 50%,
                transparent 60%
            );
            transform: translateX(-120%);
            transition: .9s ease;
        }

        .auth-logo-wrapper:hover .auth-logo {
            transform: scale(1.1);
            box-shadow:
                0 0 0 4px rgba(255,255,255,.5),
                0 0 30px 10px rgba(255,255,255,.65),
                0 18px 40px rgba(0,0,0,.45);
        }

        .auth-logo-wrapper:hover .auth-logo::after {
            transform: translateX(120%);
        }

        /* =====================================================
           FORM (ASLI KAMU)
        ====================================================== */
        .form-control {
            border-radius: 12px;
            padding-left: 45px;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #adb5bd;
        }

        .btn-primary {
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
        }

        .btn-outline-light {
            border-radius: 12px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-outline-light:hover {
            background: rgba(255,255,255,.15);
            color: #fff;
        }

        .invalid-feedback {
            font-size: 0.85rem;
        }

        /* =====================================================
           RESPONSIVE MOBILE
        ====================================================== */
        @media (max-width: 576px) {
            body { padding: 20px; }
            .auth-card { padding: 30px 24px; border-radius: 18px; }
            .auth-logo { width: 72px; height: 72px; }
        }
    </style>
</head>

<body>

    <!-- BACKGROUND (FIXED STRUCTURE) -->
    <div class="auth-bg-wrap" id="authBgWrap">
        <div class="auth-bg"></div>
    </div>
    <div class="auth-noise"></div>

    <!-- CONTENT -->
    @yield('content')

    <!-- =====================================================
         PARALLAX MOUSE (BENAR-BENAR GERAK)
    ====================================================== -->
    <script>
    (function () {
        const wrap = document.getElementById('authBgWrap');
        if (!wrap) return;

        const isTouch = window.matchMedia('(pointer: coarse)').matches;
        if (isTouch) return;

        let targetX = 0, targetY = 0;
        let currentX = 0, currentY = 0;

        document.addEventListener('mousemove', (e) => {
            targetX = (e.clientX / window.innerWidth - 0.5) * 35;
            targetY = (e.clientY / window.innerHeight - 0.5) * 35;
        });

        function animate() {
            currentX += (targetX - currentX) * 0.08;
            currentY += (targetY - currentY) * 0.08;

            wrap.style.transform =
                `translate3d(${currentX}px, ${currentY}px, 0)`;

            requestAnimationFrame(animate);
        }

        animate();
    })();
    </script>

</body>
</html>
