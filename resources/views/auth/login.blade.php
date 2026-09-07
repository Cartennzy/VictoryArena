<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Masuk & Manajemen Lapangan | Victory Arena</title>

    {{-- Tailwind CSS & FontAwesome CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .font-sports {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            letter-spacing: -0.025em;
        }

        /* Glassmorphism Panel */
        .saas-card {
            background: rgba(13, 20, 36, 0.92);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 28px;
            box-shadow: 0 30px 65px -15px rgba(0, 0, 0, 0.8),
                        0 0 30px -10px rgba(220, 38, 38, 0.2);
        }

        /* Dark Premium Input System */
        .saas-input {
            width: 100%;
            height: 52px;
            background: rgba(8, 13, 26, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            padding: 0 46px;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.92rem;
            outline: none;
            transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .saas-input::placeholder {
            color: #64748b;
            font-weight: 500;
        }
        .saas-input:focus {
            background: rgba(11, 19, 38, 1);
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.22);
        }

        /* Main SaaS Button with 3D Push-down State */
        .btn-action-primary {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 54px;
            border-radius: 16px;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            border: 1px solid rgba(255, 255, 255, 0.22);
            color: #ffffff;
            font-weight: 900;
            font-size: 0.92rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 14px 28px -6px rgba(220, 38, 38, 0.65);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            user-select: none;
        }
        .btn-action-primary:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 18px 34px -6px rgba(220, 38, 38, 0.8);
        }
        .btn-action-primary:active {
            transform: translateY(2px) scale(0.98) !important;
            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.35) !important;
        }

        /* Google Button */
        .btn-google {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 50px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
            font-weight: 800;
            font-size: 0.86rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s ease;
            user-select: none;
        }
        .btn-google:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            transform: translateY(-2px);
        }
        .btn-google:active {
            transform: translateY(2px) scale(0.98) !important;
        }

        /* Ambient Glow Animations */
        @keyframes ambientPulse {
            0%, 100% { opacity: 0.35; transform: scale(1); }
            50% { opacity: 0.55; transform: scale(1.08); }
        }

        /* Ripple Wave Effect */
        .ripple-wave {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            pointer-events: none;
            transform: scale(0);
            animation: rippleAnim 0.65s cubic-bezier(0, 0, 0.2, 1);
        }
        @keyframes rippleAnim {
            0% { transform: scale(0); opacity: 0.7; }
            100% { transform: scale(3.5); opacity: 0; }
        }
    </style>
</head>
<body class="bg-[#070b16] text-slate-100 font-sports min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-10 relative overflow-x-hidden selection:bg-red-600 selection:text-white">

    {{-- Atmospheric Background Lights --}}
    <div class="fixed -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[450px] bg-red-600/15 rounded-full blur-[140px] pointer-events-none" style="animation: ambientPulse 8s ease-in-out infinite;"></div>
    <div class="fixed bottom-0 right-0 w-96 h-96 bg-blue-900/15 rounded-full blur-[130px] pointer-events-none"></div>

    <div class="w-full max-w-5xl relative z-10 my-auto">

        {{-- Top Return Link --}}
        <div class="mb-5 flex justify-between items-center px-2">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-left text-[11px] text-red-500"></i>
                <span>Kembali ke Beranda</span>
            </a>

            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest hidden sm:inline-block">
                Victory Arena Systems v2.4
            </span>
        </div>

        {{-- Split Production Container --}}
        <div class="saas-card overflow-hidden grid grid-cols-1 lg:grid-cols-12 items-stretch">

            {{-- LEFT SIDE: SHOWCASE / STATUS PANEL (5 COLS - DESKTOP ONLY) --}}
            <div class="hidden lg:flex lg:col-span-5 flex-col justify-between p-10 bg-gradient-to-br from-slate-900/90 via-slate-950/90 to-red-950/40 border-r border-slate-800/80 relative overflow-hidden">
                <div class="absolute -top-20 -left-20 w-60 h-60 bg-red-600/20 rounded-full blur-3xl pointer-events-none"></div>

                <div>
                    {{-- Logo Brand --}}
                    <div class="flex items-center gap-3.5 mb-10">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-slate-900 border-2 border-red-600 p-0.5 shadow-lg shadow-red-600/40 shrink-0">
                            <img src="{{ asset('assets/logo-victory-arena.png') }}" alt="Logo" class="w-full h-full object-cover rounded-full">
                        </div>
                        <div>
                            <span class="text-xl font-black uppercase tracking-wider text-white">VICTORY <span class="text-red-500">ARENA</span></span>
                            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Sports Stadium Cloud</span>
                        </div>
                    </div>

                    {{-- Feature Bullets --}}
                    <div class="space-y-6">
                        <div class="space-y-1">
                            <div class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-wider text-red-400">
                                <i class="fa-solid fa-bolt text-red-500"></i>
                                <span>Real-Time Matrix Slot</span>
                            </div>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Jadwal pertandingan sinkron langsung tanpa risiko double-booking antar-tim.
                            </p>
                        </div>

                        <div class="space-y-1">
                            <div class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-wider text-red-400">
                                <i class="fa-solid fa-qrcode text-red-500"></i>
                                <span>Instant Digital Pass</span>
                            </div>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Bukti booking berformat tiket digital terintegrasi untuk verifikasi petugas arena.
                            </p>
                        </div>

                        <div class="space-y-1">
                            <div class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-wider text-red-400">
                                <i class="fa-solid fa-shield-halved text-red-500"></i>
                                <span>Multi-Role Access</span>
                            </div>
                            <p class="text-xs text-slate-400 leading-relaxed">
                                Satu portal terpadu untuk member komunitas maupun panel administrasi arena.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Mini Live Stats Indicator --}}
                <div class="pt-8 border-t border-slate-800/80 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Kondisi Lapangan</span>
                        <p class="text-xs font-black text-white mt-0.5">3 Arena Aktif Turnamen</p>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Operasional
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDE: LOGIN FORM PORTAL (7 COLS) --}}
            <div class="lg:col-span-7 p-7 sm:p-10 flex flex-col justify-center">

                {{-- Mobile Brand Logo (Hanya Tampil di Mobile) --}}
                <div class="lg:hidden text-center mb-6">
                    <div class="inline-block p-0.5 rounded-full bg-slate-900 border-2 border-red-600 shadow-lg shadow-red-600/30 mb-2">
                        <img src="{{ asset('assets/logo-victory-arena.png') }}" alt="Logo" class="w-14 h-14 object-cover rounded-full">
                    </div>
                    <h2 class="text-xl font-black uppercase text-white tracking-wider">VICTORY <span class="text-red-500">ARENA</span></h2>
                </div>

                {{-- Form Header & Dynamic Role Badge --}}
                <div class="mb-7">
                    <div id="roleBadge" class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900 border border-slate-800 text-slate-400 text-[10px] font-black uppercase tracking-widest mb-3 transition-all">
                        <span id="roleDot" class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        <span id="roleText">Single Sign-On Portal</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-white">
                        Otorisasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-400">Masuk Akun</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-1">Masukkan kredensial Anda untuk membuka akses sistem.</p>
                </div>

                {{-- Alert Error Notification --}}
                @if($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold flex items-start gap-3 shadow-lg shadow-red-950/40">
                        <i class="fa-solid fa-circle-exclamation text-base mt-0.5 shrink-0"></i>
                        <div>
                            <span class="font-black uppercase tracking-wide block mb-0.5">Autentikasi Gagal:</span>
                            <ul class="list-disc list-inside space-y-0.5 font-normal text-[11px]">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email Input --}}
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <i id="emailIcon" class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm transition-colors"></i>
                            <input type="email" 
                                   name="email" 
                                   id="userEmail"
                                   class="saas-input" 
                                   value="{{ old('email') }}" 
                                   placeholder="nama@email.com atau admin@victory.com" 
                                   required 
                                   autofocus 
                                   oninput="detectAdminEmail(this.value)">
                        </div>
                    </div>

                    {{-- Password Input with Eye Toggle --}}
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            <input type="password" 
                                   name="password" 
                                   id="userPassword" 
                                   class="saas-input" 
                                   placeholder="••••••••••••" 
                                   required>
                            <button type="button" 
                                    onclick="togglePasswordVisibility()" 
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 transition-colors focus:outline-none">
                                <i id="eyeIcon" class="fa-solid fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-1">
                        <button type="submit" id="btnSubmit" class="btn-action-primary">
                            <i class="fa-solid fa-right-to-bracket text-xs" id="btnIcon"></i>
                            <span id="btnText">Masuk Sekarang</span>
                        </button>
                    </div>
                </form>

                {{-- Google Divider --}}
                <div class="relative my-6 text-center">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-800"></div></div>
                    <span class="relative px-3 text-[10px] font-black uppercase tracking-widest text-slate-500 bg-[#0d1424]">Atau Otorisasi</span>
                </div>

                {{-- Google OAuth Button --}}
                <a href="{{ route('google.redirect') }}" class="btn-google">
                    <i class="fa-brands fa-google text-red-500 text-sm"></i>
                    <span>Masuk dengan Google</span>
                </a>

                {{-- Register Link Footer --}}
                <div class="mt-6 pt-5 border-t border-slate-800/80 flex items-center justify-between text-xs">
                    <span class="text-slate-400">Belum punya akun pemain?</span>
                    <a href="{{ route('customer.register') }}" class="font-black text-red-400 hover:text-red-300 uppercase tracking-wider transition-colors">
                        Daftar Member <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                    </a>
                </div>

            </div>

        </div>

        {{-- Bottom Security Notice --}}
        <div class="text-center mt-6 flex items-center justify-center gap-2 text-[11px] text-slate-500 font-semibold uppercase tracking-wider">
            <i class="fa-solid fa-shield-halved text-emerald-500"></i>
            <span>Sistem Otentikasi Enkripsi SHA-256 Aktif</span>
        </div>

    </div>

    {{-- Interactive Dynamic Script --}}
    <script>
        function detectAdminEmail(val) {
            const cleanVal = val.trim().toLowerCase();
            const badge = document.getElementById('roleBadge');
            const dot = document.getElementById('roleDot');
            const text = document.getElementById('roleText');
            const emailIcon = document.getElementById('emailIcon');
            const btnText = document.getElementById('btnText');
            const btnIcon = document.getElementById('btnIcon');

            if (cleanVal === 'admin@victory.com') {
                badge.className = 'inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-950/80 border border-red-800 text-red-400 text-[10px] font-black uppercase tracking-widest mb-3';
                dot.className = 'w-1.5 h-1.5 rounded-full bg-red-500 animate-ping';
                text.innerText = 'Admin Command Center Mode';
                emailIcon.className = 'fa-solid fa-shield-halved absolute left-4 top-1/2 -translate-y-1/2 text-red-500 text-sm';
                btnText.innerText = 'Otorisasi Akses Admin';
                btnIcon.className = 'fa-solid fa-shield-halved text-xs';
            } else {
                badge.className = 'inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900 border border-slate-800 text-slate-400 text-[10px] font-black uppercase tracking-widest mb-3';
                dot.className = 'w-1.5 h-1.5 rounded-full bg-slate-400';
                text.innerText = 'Single Sign-On Portal';
                emailIcon.className = 'fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm';
                btnText.innerText = 'Masuk Sekarang';
                btnIcon.className = 'fa-solid fa-right-to-bracket text-xs';
            }
        }

        function togglePasswordVisibility() {
            const pwd = document.getElementById('userPassword');
            const icon = document.getElementById('eyeIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                pwd.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Universal Ripple Script
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-action-primary, .btn-google');
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