@section('title', 'Profil || Argenesia Hub')
<div class="flex-1 flex items-start justify-center pt-16 md:pt-8 pb-8 min-h-screen">
    <div class="relative w-full max-w-6xl mx-8 bg-white/60 backdrop-blur-2xl border border-white/40 rounded-3xl shadow-2xl p-10 flex flex-col gap-8 overflow-hidden">
        <!-- Decorative Gradient Blobs -->
        <div class="absolute -top-20 -left-20 w-60 h-60 bg-linear-to-br from-[#0074D9]/30 to-[#F53003]/20 rounded-full blur-2xl opacity-60 z-0"></div>
        <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-linear-to-tr from-[#F53003]/30 to-[#0074D9]/20 rounded-full blur-2xl opacity-60 z-0"></div>
        <div class="relative z-10 flex flex-col items-center">
            <!-- Avatar -->
            <div class="relative mb-4">
                <div class="w-28 h-28 rounded-full bg-linear-to-tr from-[#0074D9] to-[#F53003] p-1 shadow-xl animate-pulse-slow">
                    <img src="{{ $foto ? asset($foto) : asset('img/sidebar/profil.webp') }}" alt="Foto Profil"
                        class="w-full h-full rounded-full object-cover border-4 border-white shadow-lg hover:scale-105 transition-all duration-300 cursor-pointer" />
                </div>
                @if($editMode)
                    <label for="foto_baru"
                        class="absolute bottom-0 right-0 bg-linear-to-tr from-[#0074D9] to-[#F53003] text-white rounded-full p-2 shadow-lg cursor-pointer hover:scale-110 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </label>
                    <input id="foto_baru" type="file" wire:model="foto_baru" class="hidden">
                @endif
            </div>
            <h2 class="text-2xl font-extrabold bg-linear-to-r from-[#0074D9] to-[#F53003] bg-clip-text text-transparent drop-shadow tracking-wide uppercase mb-1">{{ $username ?? 'Username' }}</h2>
            <span class="text-[#F53003] text-sm mb-2 flex items-center gap-2 bg-white/70 px-3 py-1 rounded-lg shadow">
                <img src="{{ asset('img/profil/id.webp') }}" alt="ID" class="w-5 h-5" />
                ARG -
                @if($status_karyawan === 'Aktif' && $kode_karyawan)
                    {{ $kode_karyawan }}
                @else
                    <span class="text-gray-400"></span>
                @endif
            </span>
            @if ($foto_baru)
                <img src="{{ $foto_baru->temporaryUrl() }}" class="w-16 h-16 rounded-full mt-2 object-cover border-2 border-[#0074D9] shadow-lg">
            @endif
        </div>
        <!-- Info Card -->
        <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-8 pt-16">
            <div class="bg-white/80 rounded-2xl shadow-lg p-5 flex flex-col gap-3 border border-[#0074D9]/10">
                <label class="flex items-center gap-2 text-sm font-semibold text-[#F53003]">
                    <img src="{{ asset('img/auth/email.webp') }}" alt="Email" class="w-5 h-5" /> Email
                </label>
                <input type="email"
                    class="w-full px-4 py-2 rounded-lg border border-[#0074D9]/30 bg-white/60 focus:outline-none cursor-not-allowed"
                    value="{{ $email ?? '-' }}" disabled>
            </div>
            <div class="bg-white/80 rounded-2xl shadow-lg p-5 flex flex-col gap-3 border border-[#0074D9]/10">
                <label class="flex items-center gap-2 text-sm font-semibold text-[#0074D9]">
                    <img src="{{ asset('img/profil/join.webp') }}" alt="Tanggal Masuk" class="w-5 h-5" /> Tanggal Masuk
                </label>
                <input type="text"
                    class="w-full px-4 py-2 rounded-lg border border-[#0074D9]/30 bg-white/60 focus:outline-none cursor-not-allowed"
                    value="{{ $tanggal_masuk ?? '-' }}" disabled>
            </div>
            <div class="bg-white/80 rounded-2xl shadow-lg p-5 flex flex-col gap-3 border border-[#F53003]/10">
                <label class="flex items-center gap-2 text-sm font-semibold text-[#F53003]">
                    <img src="{{ asset('img/profil/status.webp') }}" alt="Status" class="w-5 h-5" /> Status Karyawan
                </label>
                <input type="text"
                    class="w-full px-4 py-2 rounded-lg border border-[#F53003]/30 bg-white/60 focus:outline-none cursor-not-allowed"
                    value="{{ $status_karyawan ?: 'Nonaktif' }}" disabled>
            </div>
            <div class="bg-white/80 rounded-2xl shadow-lg p-5 flex flex-col gap-3 border border-[#0074D9]/10">
                <label class="flex items-center gap-2 text-sm font-semibold text-[#0074D9]">
                    <img src="{{ asset('img/profil/phone.webp') }}" alt="Phone" class="w-5 h-5" /> Nomor Telepon
                </label>
                <input type="text" wire:model="nomor_telepon"
                    class="w-full px-4 py-2 rounded-lg border border-[#0074D9]/30 bg-white/60 focus:outline-none {{ !$editMode ? 'cursor-not-allowed' : '' }}"
                    {{ !$editMode ? 'disabled' : '' }}>
            </div>
            <div class="bg-white/80 rounded-2xl shadow-lg p-5 flex flex-col gap-3 border border-[#F53003]/10 md:col-span-2">
                <label class="flex items-center gap-2 text-sm font-semibold text-[#F53003]">
                    <img src="{{ asset('img/profil/address.webp') }}" alt="Alamat" class="w-5 h-5" /> Alamat
                </label>
                <textarea wire:model="alamat"
                    class="w-full px-4 py-2 rounded-lg border border-[#F53003]/30 bg-white/60 focus:outline-none resize-none {{ !$editMode ? 'cursor-not-allowed' : '' }}"
                    rows="2" {{ !$editMode ? 'disabled' : '' }}></textarea>
            </div>
        </div>
        <!-- Tombol -->
        <div class="mt-8 flex justify-end space-x-2 relative z-10">
            @if(!$editMode)
                <button wire:click="enableEdit"
                    class="px-6 py-2 bg-linear-to-r from-[#0074D9] to-[#F53003] text-white rounded-lg shadow-lg hover:scale-105 hover:shadow-2xl transition-all font-bold cursor-pointer">
                    Edit
                </button>
            @else
                <button wire:click="updateProfil"
                    class="px-6 py-2 bg-linear-to-r from-[#F53003] to-[#0074D9] text-white rounded-lg shadow-lg hover:scale-105 hover:shadow-2xl transition-all font-bold cursor-pointer">
                    Update
                </button>
                <button wire:click="cancelEdit"
                    class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg shadow hover:bg-gray-400 hover:scale-105 transition-all font-bold cursor-pointer">
                    Batal
                </button>
            @endif
        </div>
        <!-- Animasi pulse-slow hanya untuk avatar -->
        <style>
        @keyframes pulse-slow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(0,116,217,0.2), 0 0 0 0 rgba(245,48,3,0.15);}
            50% { box-shadow: 0 0 0 12px rgba(0,116,217,0.08), 0 0 0 24px rgba(245,48,3,0.07);}
        }
        .animate-pulse-slow {
            animation: pulse-slow 2.5s infinite;
        }
        </style>
    </div>
</div>
