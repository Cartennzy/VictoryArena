@extends('layouts.customer')

@section('title', 'Edit Profil & Pengaturan Akun | Victory Arena')

@section('content')

{{-- ================= PRODUCTION SPORTS SAAS STYLES ================= --}}
<style>
    .saas-card {
        background: rgba(13, 20, 36, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 26px;
        box-shadow: 0 20px 50px -12px rgba(0, 0, 0, 0.7);
        transition: border-color 0.25s ease;
    }
    .saas-card:hover {
        border-color: rgba(255, 255, 255, 0.14);
    }

    .saas-input-custom {
        width: 100%;
        height: 52px;
        background: rgba(8, 13, 26, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 14px;
        padding: 0 16px 0 48px;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.92rem;
        outline: none;
        transition: all 0.22s ease;
    }
    .saas-input-custom:focus {
        background: rgba(10, 16, 30, 0.95);
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2);
    }

    /* Primary SaaS Button */
    .btn-action-primary {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 52px;
        border-radius: 15px;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
        font-weight: 800;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 12px 28px -6px rgba(220, 38, 38, 0.55);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
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

    /* Avatar Glow & Camera Overlay */
    .avatar-wrapper {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }
    .avatar-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        border-radius: 28px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .avatar-wrapper:hover .avatar-overlay {
        opacity: 1;
    }

    /* Universal Ripple */
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

<div class="max-w-6xl mx-auto py-4 sm:py-6 space-y-8 text-slate-100 font-sans">

    {{-- ================= TOP BAR NAVIGATION ================= --}}
    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 pb-6 border-b border-slate-800">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-red-950/60 border border-red-800/60 text-red-400 text-xs font-black tracking-widest uppercase mb-2">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                Account Customization
            </div>
            <h1 class="text-3xl sm:text-4xl font-black uppercase tracking-tight text-white">Edit Informasi Profil</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Ubah identitas member, kontak WhatsApp pemesan, nama tim, dan keamanan password Anda.</p>
        </div>

        <a href="{{ route('customer.profile') }}" 
           class="btn-action self-start sm:self-auto px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-750 text-xs font-bold uppercase tracking-wider">
            <i class="fa-solid fa-arrow-left mr-2 text-red-500"></i> Kembali ke Profil
        </a>
    </div>

    {{-- Flash Alerts --}}
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-base shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold flex items-start gap-3">
            <i class="fa-solid fa-circle-exclamation text-base mt-0.5 shrink-0"></i>
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ================= 2-COLUMN BALANCED FORM LAYOUT ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        {{-- KOLOM KIRI: EDIT DATA IDENTITAS & FOTO AVATAR (7 COLS) --}}
        <div class="lg:col-span-7 saas-card p-6 sm:p-8">
            <div class="flex items-center justify-between pb-5 mb-6 border-b border-slate-800">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-red-500 block mb-0.5">FORMULIR BIODATA</span>
                    <h3 class="text-xl font-black uppercase text-white tracking-wide">Data Profil & Tim</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-750 flex items-center justify-center text-slate-400">
                    <i class="fa-solid fa-id-badge"></i>
                </div>
            </div>

            <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Interactive Avatar Upload with Live Preview --}}
                <div class="flex flex-col sm:flex-row items-center gap-6 p-5 rounded-2xl bg-slate-900/60 border border-slate-800">
                    <label for="avatarInputEdit" class="avatar-wrapper shrink-0">
                        <div class="w-24 h-24 rounded-3xl overflow-hidden border-2 border-red-600 bg-slate-950 flex items-center justify-center shadow-lg shadow-red-600/30">
                            <img id="avatarPreviewEdit" 
                                 src="{{ !empty($user->avatar) ? asset('storage/'.$user->avatar) : '' }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-full h-full object-cover {{ empty($user->avatar) ? 'hidden' : '' }}">
                            
                            <div id="avatarFallbackEdit" class="w-full h-full bg-gradient-to-tr from-red-600 to-rose-500 text-white font-black text-3xl flex items-center justify-center {{ !empty($user->avatar) ? 'hidden' : '' }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>

                        <div class="avatar-overlay">
                            <i class="fa-solid fa-camera text-white text-xl"></i>
                            <span class="text-[9px] font-black uppercase text-white mt-1">Ubah Foto</span>
                        </div>
                    </label>

                    <input type="file" 
                           id="avatarInputEdit" 
                           name="avatar" 
                           accept="image/png, image/jpeg, image/jpg" 
                           class="hidden" 
                           onchange="previewEditImage(event)">

                    <div class="text-center sm:text-left">
                        <h4 class="text-sm font-black uppercase text-white tracking-wide">Ganti Foto Profil</h4>
                        <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                            Klik avatar untuk upload foto baru. Format yang didukung: JPG, PNG, atau JPEG (Maks. 2MB).
                        </p>
                        <button type="button" 
                                onclick="document.getElementById('avatarInputEdit').click()" 
                                class="mt-2.5 px-4 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 text-xs font-bold uppercase tracking-wider transition-colors inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-upload text-[11px]"></i> Pilih Berkas Foto
                        </button>
                    </div>
                </div>

                {{-- Inputs --}}
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            <input type="text" name="name" class="saas-input-custom" value="{{ old('name', $user->name) }}" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Nomor WhatsApp Aktif</label>
                        <div class="relative">
                            <i class="fa-brands fa-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-emerald-400 text-base"></i>
                            <input type="tel" name="phone" class="saas-input-custom" value="{{ old('phone', $user->phone) }}" placeholder="081234567890" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Alamat Email</label>
                        <div class="relative">
                            <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            <input type="email" name="email" class="saas-input-custom" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Nama Tim / Komunitas</label>
                        <div class="relative">
                            <i class="fa-solid fa-shield-halved absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            <input type="text" name="team_name" class="saas-input-custom" value="{{ old('team_name', $user->team_name ?? '') }}" placeholder="Contoh: Garuda FC">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Domisili / Kota</label>
                    <div class="relative">
                        <i class="fa-solid fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                        <input type="text" name="address" class="saas-input-custom" value="{{ old('address', $user->address ?? '') }}" placeholder="Contoh: Tambun Selatan, Bekasi">
                    </div>
                </div>

                <button type="submit" class="btn-action-primary">
                    <span>Simpan Perubahan Profil</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>

        {{-- KOLOM KANAN: GANTI PASSWORD (5 COLS) --}}
        <div class="lg:col-span-5 space-y-6">
            
            <div class="saas-card p-6 sm:p-8">
                <div class="flex items-center justify-between pb-5 mb-6 border-b border-slate-800">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-0.5">AUTENTIKASI</span>
                        <h3 class="text-xl font-black uppercase text-white tracking-wide">Ganti Kata Sandi</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-750 flex items-center justify-center text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                </div>

                <form method="POST" action="{{ route('customer.profile.password') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Password Saat Ini</label>
                        <div class="relative">
                            <i class="fa-solid fa-key absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            <input type="password" name="current_password" class="saas-input-custom" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Password Baru</label>
                        <div class="relative">
                            <i class="fa-solid fa-shield-halved absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            <input type="password" name="new_password" class="saas-input-custom" placeholder="Minimal 6 karakter" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-300 mb-2">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <i class="fa-solid fa-check-double absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            <input type="password" name="new_password_confirmation" class="saas-input-custom" placeholder="Ketik ulang password baru" required>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn-action-primary !bg-slate-900 hover:!bg-slate-800 !border-slate-750">
                            <i class="fa-solid fa-shield-cat text-xs mr-1 text-slate-400"></i>
                            <span>Update Kata Sandi</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Security Tips Info Box --}}
            <div class="p-5 rounded-2xl bg-slate-900/60 border border-slate-800 space-y-2">
                <div class="flex items-center gap-2 text-xs font-black uppercase text-amber-400">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>Tips Keamanan Akun</span>
                </div>
                <p class="text-[11px] text-slate-400 leading-relaxed">
                    Pastikan nomor WhatsApp Anda selalu aktif untuk menerima konfirmasi status booking dan notifikasi tiket lapangan secara instan.
                </p>
            </div>

        </div>

    </div>

</div>

{{-- ================= LIVE IMAGE PREVIEW & RIPPLE SCRIPT ================= --}}
<script>
function previewEditImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreviewEdit');
            const fallback = document.getElementById('avatarFallbackEdit');
            
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (fallback) {
                fallback.classList.add('hidden');
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Universal Button Ripple Effect
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-action-primary, .btn-action');
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