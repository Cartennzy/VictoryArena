@extends('layouts.auth')

@section('title', 'Victory Arena | Register Customer')

@section('content')

{{-- ================= CUSTOM STYLES: SAAS SPORTS THEME ================= --}}
<style>
    .saas-register-card {
        background: rgba(10, 16, 30, 0.82);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 28px;
        padding: 40px 36px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.75),
                    0 0 40px -10px rgba(220, 38, 38, 0.25);
        color: #f8fafc;
        position: relative;
        z-index: 10;
        animation: cardAppear 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes cardAppear {
        from {
            opacity: 0;
            transform: translateY(24px) scale(0.97);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .saas-logo-box {
        width: 82px;
        height: 82px;
        border-radius: 50%;
        margin: 0 auto 16px;
        padding: 3px;
        background: linear-gradient(135deg, #dc2626, #2563eb);
        box-shadow: 0 0 25px rgba(220, 38, 38, 0.45);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.4s ease;
    }
    .saas-logo-box:hover {
        transform: scale(1.08) rotate(3deg);
        box-shadow: 0 0 35px rgba(220, 38, 38, 0.7);
    }
    .saas-logo-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        background: #080d1a;
    }

    .saas-input-group {
        position: relative;
        margin-bottom: 18px;
    }
    .saas-input-group .input-icon {
        position: absolute;
        top: 50%;
        left: 18px;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.1rem;
        transition: color 0.25s ease;
        z-index: 2;
        pointer-events: none;
    }
    .saas-input {
        width: 100%;
        height: 50px;
        background: rgba(15, 23, 42, 0.65);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 14px;
        padding: 0 16px 0 48px;
        color: #ffffff;
        font-size: 0.92rem;
        font-weight: 500;
        transition: all 0.25s ease;
        outline: none;
    }
    .saas-input::placeholder {
        color: #64748b;
        font-size: 0.88rem;
    }
    .saas-input:focus {
        background: rgba(15, 23, 42, 0.95);
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.18);
        color: #ffffff;
    }
    .saas-input:focus + .input-icon,
    .saas-input-group:focus-within .input-icon {
        color: #ef4444;
    }

    .btn-action-primary {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 50px;
        border-radius: 14px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.92rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 10px 25px -5px rgba(220, 38, 38, 0.5);
        transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
    }
    .btn-action-primary:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 15px 30px -5px rgba(220, 38, 38, 0.65);
    }
    .btn-action-primary:active {
        transform: translateY(2px) scale(0.98) !important;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3) !important;
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
        0% {
            transform: scale(0);
            opacity: 0.6;
        }
        100% {
            transform: scale(3.5);
            opacity: 0;
        }
    }
</style>

<div class="saas-register-card text-center">

    <div class="saas-logo-box">
        <img src="{{ asset('assets/logo-victory-arena.png') }}"
             alt="Victory Arena"
             class="saas-logo-img">
    </div>

    <h3 class="fw-black text-uppercase tracking-tight text-white mb-1" style="font-weight: 800; letter-spacing: -0.02em;">
        Daftar <span style="color: #ef4444;">Member</span>
    </h3>
    <p class="text-slate-400 mb-4" style="font-size: 0.85rem; color: #94a3b8;">
        Buat akun tim & mulai reservasi lapangan Victory Arena
    </p>

    <form method="POST" action="{{ route('customer.register.store') }}">
        @csrf

        <div class="saas-input-group text-start">
            <input type="text"
                   name="name"
                   class="saas-input @error('name') is-invalid @enderror"
                   placeholder="Nama Lengkap / Nama Tim"
                   value="{{ old('name') }}"
                   required
                   autofocus>
            <i class="bi bi-person input-icon"></i>

            @error('name')
                <div class="invalid-feedback d-block mt-1 ps-2" style="color: #f87171; font-size: 0.8rem;">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="saas-input-group text-start">
            <input type="email"
                   name="email"
                   class="saas-input @error('email') is-invalid @enderror"
                   placeholder="Alamat Email Aktif"
                   value="{{ old('email') }}"
                   required
                   autocomplete="email">
            <i class="bi bi-envelope input-icon"></i>

            @error('email')
                <div class="invalid-feedback d-block mt-1 ps-2" style="color: #f87171; font-size: 0.8rem;">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="saas-input-group text-start mb-4">
            <input type="password"
                   name="password"
                   class="saas-input @error('password') is-invalid @enderror"
                   placeholder="Kata Sandi (Min. 6 Karakter)"
                   required
                   autocomplete="new-password">
            <i class="bi bi-shield-lock input-icon"></i>

            @error('password')
                <div class="invalid-feedback d-block mt-1 ps-2" style="color: #f87171; font-size: 0.8rem;">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn-action-primary mb-4">
            <span>Daftar Sekarang</span>
            <i class="bi bi-arrow-right-short" style="font-size: 1.3rem;"></i>
        </button>

        <div class="text-center" style="font-size: 0.85rem; color: #94a3b8;">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="text-white text-decoration-none fw-bold" style="color: #ef4444 !important;">
                Masuk di Sini
            </a>
        </div>
    </form>

</div>

<script>
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-action-primary');
    if (!btn) return;

    const rect = btn.getBoundingClientRect();
    const ripple = document.createElement('span');

    const diameter = Math.max(rect.width, rect.height);
    const radius = diameter / 2;

    ripple.style.width = ripple.style.height = `${diameter}px`;
    ripple.style.left = `${e.clientX - rect.left - radius}px`;
    ripple.style.top = `${e.clientY - rect.top - radius}px`;
    ripple.classList.add('ripple-wave');

    const prevRipple = btn.querySelector('.ripple-wave');
    if (prevRipple) {
        prevRipple.remove();
    }

    btn.appendChild(ripple);

    setTimeout(() => {
        ripple.remove();
    }, 650);
});
</script>

@endsection