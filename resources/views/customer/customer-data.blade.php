@extends('layouts.customer')

@section('title', 'Lengkapi Data Tim & Kontak | Victory Arena')

@section('content')

{{-- ================= STYLES & INTERACTION ANIMATIONS ================= --}}
<style>
    /* Card Glassmorphism Level SaaS */
    .saas-box {
        background: rgba(13, 20, 36, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 28px;
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7),
                    0 0 35px -10px rgba(220, 38, 38, 0.2);
        animation: formFadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes formFadeUp {
        0% {
            opacity: 0;
            transform: translateY(22px) scale(0.98);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Input Field Elements */
    .saas-field-group {
        position: relative;
        margin-bottom: 22px;
    }
    .saas-field-group .input-icon-box {
        position: absolute;
        top: 42px;
        left: 18px;
        color: #64748b;
        font-size: 1rem;
        transition: color 0.2s ease;
        pointer-events: none;
        z-index: 2;
    }
    .saas-input-custom {
        width: 100%;
        height: 52px;
        background: rgba(8, 13, 26, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 14px;
        padding: 0 16px 0 50px;
        color: #ffffff;
        font-size: 0.92rem;
        font-weight: 500;
        transition: all 0.22s ease;
        outline: none;
    }
    .saas-input-custom::placeholder {
        color: #475569;
        font-size: 0.88rem;
    }
    .saas-input-custom:focus {
        background: rgba(10, 16, 30, 0.95);
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.18);
        color: #ffffff;
    }
    .saas-field-group:focus-within .input-icon-box {
        color: #ef4444;
    }

    /* Tombol Utama Interaktif */
    .btn-action-primary {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 54px;
        border-radius: 16px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        border: 1px solid rgba(255, 255, 255, 0.18);
        color: #ffffff;
        font-weight: 800;
        font-size: 0.92rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        box-shadow: 0 14px 28px -6px rgba(220, 38, 38, 0.55);
        transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
    }
    .btn-action-primary:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 18px 32px -6px rgba(220, 38, 38, 0.7);
    }
    .btn-action-primary:active {
        transform: translateY(2px) scale(0.98) !important;
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3) !important;
    }

    /* Ripple Animation */
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

<div class="max-w-3xl mx-auto py-4 sm:py-8">

    {{-- ================= STEP PROGRESS BAR ================= --}}
    <div class="mb-8 p-5 rounded-2xl bg-slate-900/60 border border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-3.5">
            <div class="w-9 h-9 rounded-xl bg-red-600 text-white font-black text-sm flex items-center justify-center shadow-md shadow-red-600/40">
                1
            </div>
            <div>
                <p class="text-xs font-black uppercase tracking-wider text-white">Langkah 1</p>
                <p class="text-[11px] text-slate-400">Verifikasi Kontak & Tim</p>
            </div>
        </div>

        <div class="hidden sm:block w-16 h-[2px] bg-slate-800"></div>

        <div class="flex items-center gap-3.5 opacity-50">
            <div class="w-9 h-9 rounded-xl bg-slate-800 text-slate-400 font-black text-sm flex items-center justify-center">
                2
            </div>
            <div>
                <p class="text-xs font-black uppercase tracking-wider text-slate-400">Langkah 2</p>
                <p class="text-[11px] text-slate-500">Pilih Slot & Lapangan</p>
            </div>
        </div>

        <div class="hidden sm:block w-16 h-[2px] bg-slate-800"></div>

        <div class="flex items-center gap-3.5 opacity-50">
            <div class="w-9 h-9 rounded-xl bg-slate-800 text-slate-400 font-black text-sm flex items-center justify-center">
                3
            </div>
            <div>
                <p class="text-xs font-black uppercase tracking-wider text-slate-400">Langkah 3</p>
                <p class="text-[11px] text-slate-500">Kick-Off Match</p>
            </div>
        </div>
    </div>

    {{-- ================= NOTIFIKASI INFO ================= --}}
    <div class="mb-8 p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-red-950/40 to-slate-900 border border-red-800/40 flex items-start gap-4">
        <div class="w-10 h-10 rounded-xl bg-red-600/20 border border-red-500/30 text-red-500 flex items-center justify-center text-lg shrink-0 mt-0.5">
            <i class="fa-solid fa-address-card"></i>
        </div>
        <div>
            <h4 class="text-xs font-black uppercase tracking-wider text-white">Konfirmasi Data Reservasi</h4>
            <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                Nomor WhatsApp yang Anda daftarkan akan digunakan operator lapangan untuk mengirimkan invoice digital, tiket masuk arena, dan update konfirmasi jadwal secara otomatis.
            </p>
        </div>
    </div>

    {{-- ================= CARD FORM UTAMA ================= --}}
    <div class="saas-box p-6 sm:p-10">
        
        {{-- Header Form --}}
        <div class="flex items-center justify-between pb-6 mb-8 border-b border-slate-800/80">
            <div>
                <span class="text-red-500 text-[10px] font-black uppercase tracking-widest block mb-1">DATA PEMESAN RESMI</span>
                <h2 class="text-2xl font-black uppercase tracking-tight text-white">Profil Tim & Kontak</h2>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-slate-900 border border-slate-750 flex items-center justify-center text-slate-400 text-xl shadow-inner">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        {{-- Form Action ke CustomerDataController --}}
        <form method="POST" action="{{ route('customer.customer.store') }}">
            @csrf

            <div class="grid sm:grid-cols-2 gap-5">
                
                {{-- Nama Akun (Readonly) --}}
                <div class="saas-field-group">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">Nama Akun Terdaftar</label>
                    <div class="input-icon-box">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <input type="text"
                           class="saas-input-custom opacity-60 cursor-not-allowed border-slate-800 bg-slate-950/80 font-bold"
                           value="{{ $user->name }}"
                           disabled>
                </div>

                {{-- Email Akun (Readonly) --}}
                <div class="saas-field-group">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">Email Akun</label>
                    <div class="input-icon-box">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <input type="text"
                           class="saas-input-custom opacity-60 cursor-not-allowed border-slate-800 bg-slate-950/80 font-bold"
                           value="{{ $user->email }}"
                           disabled>
                </div>

            </div>

            {{-- Nomor WhatsApp (Wajib) --}}
            <div class="saas-field-group">
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-300">
                        Nomor WhatsApp Aktif <span class="text-red-500">*</span>
                    </label>
                    <span class="text-[11px] text-slate-500">Wajib untuk tiket match</span>
                </div>
                <div class="input-icon-box">
                    <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                </div>
                <input type="tel"
                       name="phone"
                       class="saas-input-custom @error('phone') border-red-500 @enderror"
                       placeholder="Contoh: 08996602425"
                       value="{{ old('phone') }}"
                       required
                       autofocus>

                @error('phone')
                    <p class="text-red-400 text-xs mt-1.5 font-bold flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Nama Tim / Komunitas --}}
            <div class="saas-field-group">
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-300">
                        Nama Tim / Klub / Komunitas
                    </label>
                    <span class="text-[11px] text-slate-500">Ditampilkan pada Scoreboard</span>
                </div>
                <div class="input-icon-box">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <input type="text"
                       name="team_name"
                       class="saas-input-custom @error('team_name') border-red-500 @enderror"
                       placeholder="Contoh: Garuda Muda FC / Mabar Santai FC"
                       value="{{ old('team_name') }}">

                @error('team_name')
                    <p class="text-red-400 text-xs mt-1.5 font-bold flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Domisili / Alamat --}}
            <div class="saas-field-group mb-8">
                <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">
                    Domisili Asal Tim (Opsional)
                </label>
                <div class="input-icon-box">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <input type="text"
                       name="address"
                       class="saas-input-custom @error('address') border-red-500 @enderror"
                       placeholder="Contoh: Tambun Selatan, Bekasi Timur"
                       value="{{ old('address') }}">

                @error('address')
                    <p class="text-red-400 text-xs mt-1.5 font-bold flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Tombol Lanjutkan dengan Ripple Effect --}}
            <button type="submit" class="btn-action-primary">
                <span>Simpan Profil & Lanjut Pilih Jam</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
            
            <p class="text-center text-[11px] text-slate-500 mt-4">
                Data Anda terlindungi oleh enkripsi SSL Victory Arena dan hanya digunakan untuk kebutuhan verifikasi lapangan.
            </p>
        </form>

    </div>

</div>

{{-- ================= UNIVERSAL RIPPLE SCRIPT ================= --}}
<script>
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-action-primary');
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

@endsection