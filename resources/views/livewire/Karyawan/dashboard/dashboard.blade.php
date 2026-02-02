@section('title', 'Dashboard || Argenesia Hub')
<div x-data="{showNotif: false, showNotifAktif: false}"
    :class="(showNotif || showNotifAktif) ? 'overflow-hidden h-screen' : ''">

    <style>
    @layer utilities {
    .animate-floating {
        animation: floating 2s ease-in-out infinite;
    }
    @keyframes floating {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
    }
}
    </style>

    @php
        $isAktif = (Auth::user()->karyawan && Auth::user()->karyawan->status_karyawan === 'Aktif');
    @endphp

    <div class="fixed top-4 right-8 flex items-center space-x-4 z-10 cursor-pointer">
        <div class="relative"
            @click="showNotif = {{ $isAktif ? 'false' : 'true' }}; showNotifAktif = {{ $isAktif ? 'true' : 'false' }}">
            <img src="{{ asset('img/notif.webp') }}"
                alt="Notif"
                class="w-8 h-8 mr-2 {{ $isAktif ? '' : 'animate-floating' }}" />
            @unless($isAktif)
                <!-- Notif badge hanya jika belum aktif -->
                <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow animate-floating">
                    !
                </span>
            @endunless
        </div>
        <span class="hidden md:inline text-lg font-semibold text-white">
            Selamat Datang, {{ Auth::user()->name }}
        </span>
        <a href="/profil">
            <img src="{{ (Auth::user()->karyawan && Auth::user()->karyawan->foto) ? asset(Auth::user()->karyawan->foto) : asset('img/sidebar/profil.webp') }}"
                alt="Foto Profil"
                class="w-14 h-14 rounded-full object-cover shadow-md border-2 border-[#0074D9] cursor-pointer hover:scale-110 transition-all" />
        </a>
    </div>

    <!-- Judul Dashboard -->
    <div class="w-full flex justify-center md:justify-start mt-24 md:mt-12 px-2 md:px-12">
        <div class="flex  md:flex-row items-center gap-4">
            <img src="{{ asset('img/sidebar/dashboard.webp') }}" alt="Dashboard" class="w-10 h-10 drop-shadow-lg" />
            <span class="text-4xl font-bold bg-white bg-clip-text text-transparent tracking-wide text-center md:text-left">
                Dashboard
            </span>
        </div>
    </div>

    <!-- 3 Card Sebaris -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 px-8 w-full">
        <!-- Card 1 -->
        <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-10 flex flex-col items-center transition-transform hover:scale-105 hover:shadow-2xl w-full cursor-pointer">
            <img src="{{ asset('img/cuti/cuti.webp') }}" alt="Jumlah Cuti" class="w-14 h-14 mb-4 drop-shadow" />
            <span class="text-5xl font-extrabold text-[#0074D9] drop-shadow">
                {{ $jumlahCutiDisetujui }}
            </span>
            <span class="mt-2 text-gray-800 font-semibold tracking-wide text-xl">Jumlah Cuti</span>
            <span class="mt-2 text-gray-600 text-sm text-center">Total cuti yang sudah kamu dapatkan selama bekerja.</span>
            <a href="/cuti/riwayat" class="mt-4 px-4 py-2 rounded-lg bg-[#0074D9] text-white font-semibold shadow hover:bg-[#005fa3] transition-all hover:scale-105">Lihat Riwayat</a>
        </div>
        <!-- Card 2 -->
        <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-10 flex flex-col items-center transition-transform hover:scale-105 hover:shadow-2xl w-full cursor-pointer">
            <img src="{{ asset('img/cuti/riwayat.webp') }}" alt="Sisa Cuti" class="w-14 h-14 mb-4 drop-shadow" />
            <span class="text-5xl font-extrabold text-[#F53003] drop-shadow">
                {{ $sisaCuti }}
            </span>
            <span class="mt-2 text-gray-800 font-semibold tracking-wide text-xl">Sisa Cuti</span>
            <span class="mt-2 text-gray-600 text-sm text-center">Cuti yang masih bisa kamu ajukan tahun ini.</span>
            <a href="/cuti/pengajuan" class="mt-4 px-4 py-2 rounded-lg bg-[#F53003] text-white font-semibold shadow hover:bg-[#c41e00] transition-all hover:scale-105">Ajukan Cuti</a>
        </div>
        <!-- Card 3 -->
        <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-10 flex flex-col items-center transition-transform hover:scale-105 hover:shadow-2xl w-full cursor-pointer">
            <img src="{{ asset('img/cuti/pengajuan.webp') }}" alt="Total Pengajuan" class="w-14 h-14 mb-4 drop-shadow" />
            <span class="text-5xl font-extrabold text-[#16a34a] drop-shadow">
        {{ $totalPengajuan }}
    </span>
            <span class="mt-2 text-gray-800 font-semibold tracking-wide text-xl">Total Pengajuan Cuti</span>
            <span class="mt-2 text-gray-600 text-sm text-center">Jumlah total pengajuan cuti yang sudah kamu lakukan.</span>
            <a href="/cuti/riwayat" class="mt-4 px-4 py-2 rounded-lg bg-[#16a34a] text-white font-semibold shadow hover:bg-[#0e7c2f] transition-all hover:scale-105">Lihat Detail Pengajuan</a>
        </div>
    </div>

    <!-- 2 Tabel di Bawah Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4 px-6 w-full">
        <!-- Tabel 1 -->
        <div class="bg-white/40 backdrop-blur-md rounded-2xl shadow-lg p-6 overflow-x-auto mb-8">
            <h3 class="text-lg font-bold mb-4 text-black text-center md:text-left">Pengajuan Cuti Terbaru</h3>
            <table class="min-w-full text-sm border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-[#0074D9]">
                    <tr class="text-left text-gray-700">
                        <th class="py-2 px-3 border-b border-gray-300 text-left">Tanggal</th>
                        <th class="py-2 px-3 border-b border-gray-300 text-left">Tipe</th>
                        <th class="py-2 px-3 border-b border-gray-300 text-center">Status</th>
                        <th class="py-2 px-3 border-b border-gray-300 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($pengajuanTerbaru as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-2 px-3">{{ $item->tanggal_mulai }}</td>
                    <td class="py-2 px-3">{{ $item->tipeCuti->nama_cuti ?? '-' }}</td>
                    <td class="py-2 px-3 text-center    ">
                        <span class="px-3 py-1 rounded-full font-semibold border
                            @if($item->status == 'Disetujui')
                                border-green-500 text-green-700 bg-green-50
                            @elseif($item->status == 'Ditolak')
                                border-red-500 text-red-700 bg-red-50
                            @else
                                border-yellow-500 text-yellow-700 bg-yellow-50
                            @endif">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="py-2 px-4">
                        <div class="flex items-center justify-center gap-4">
                            <a href="{{ route('cuti.pengajuan.edit', $item->id) }}" title="Edit">
                                <img src="{{ asset('img/action/edit.webp') }}" alt="Edit" class="w-6 h-6 cursor-pointer hover:scale-110 transition" />
                            </a>
                            <button type="button" title="Delete" class="focus:outline-none"
                                wire:click="confirmDelete({{ $item->id }})">
                                <img src="{{ asset('img/action/delete.webp') }}" alt="Delete" class="w-6 h-6 cursor-pointer hover:scale-110 transition" />
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr class="hover:bg-gray-50 transition">
                        <td colspan="4" class="py-2 px-3 text-center text-gray-700">Belum ada pengajuan cuti.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Modal Konfirmasi Hapus Pengajuan Cuti --}}
        <div
            x-data="{ show: @entangle('showDeleteModal') }"
            x-show="show"
            x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
            style="display: none;"
        >
            <div class="bg-linear-to-r from-[#F53003] to-[#0074D9] rounded-xl p-8 shadow-lg w-full max-w-md relative">
                <button @click="show = false; $wire.showDeleteModal = false" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-xl cursor-pointer">&times;</button>
                <div class="flex items-center gap-3 mb-4">
                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" class="text-red-100" fill="currentColor"/>
                        <path d="M9 9l6 6M15 9l-6 6" stroke="red" stroke-width="2" fill="none"/>
                    </svg>
                    <h2 class="text-xl font-bold text-white">Konfirmasi Hapus</h2>
                </div>
                <p class="mb-6 text-gray-700 text-base">
                    Yakin ingin menghapus pengajuan cuti ini? Data yang dihapus <b>tidak dapat dikembalikan</b>.
                </p>
                <div class="flex justify-end gap-2">
                    <button @click="show = false; $wire.showDeleteModal = false" class="px-4 py-2 rounded bg-linear-to-r from-[#F53003] to-[#0074D9] text-gray-700 font-semibold cursor-pointer hover:scale-105 transition-all">Batal</button>
                    <button
                        @click="$wire.deletePengajuan()"
                        class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white font-semibold cursor-pointer hover:scale-105 transition-all"
                    >Hapus</button>
                </div>
            </div>
        </div>
        <!-- Riwayat Kegiatan User-->
            <livewire:dashboard.aktivitas-table />
    </div>
    <!-- Notif Modal -->
    @include('components.notif')

</div>
