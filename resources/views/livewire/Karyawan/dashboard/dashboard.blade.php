@section('title', 'Dashboard || Argenesia Hub')
<div>
    <div class="fixed top-4 right-8 flex items-center space-x-4 z-10">
        <span class="text-lg font-semibold text-white">Selamat Datang, {{ Auth::user()->name }}</span>
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
            <span class="text-5xl font-extrabold text-[#0074D9] drop-shadow">12</span>
            <span class="mt-2 text-gray-800 font-semibold tracking-wide text-xl">Jumlah Cuti</span>
            <span class="mt-2 text-gray-600 text-sm text-center">Total cuti yang sudah kamu dapatkan selama bekerja.</span>
            <a href="/cuti/riwayat" class="mt-4 px-4 py-2 rounded-lg bg-[#0074D9] text-white font-semibold shadow hover:bg-[#005fa3] transition-all hover:scale-105">Lihat Riwayat</a>
        </div>
        <!-- Card 2 -->
        <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-10 flex flex-col items-center transition-transform hover:scale-105 hover:shadow-2xl w-full cursor-pointer">
            <img src="{{ asset('img/cuti/riwayat.webp') }}" alt="Sisa Cuti" class="w-14 h-14 mb-4 drop-shadow" />
            <span class="text-5xl font-extrabold text-[#F53003] drop-shadow">5</span>
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
            <h3 class="text-lg font-bold mb-4 text-[#0074D9]">Pengajuan Cuti Terbaru</h3>
            <table class="min-w-full text-sm border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-[#0074D9]">
                    <tr class="text-left text-gray-700">
                        <th class="py-2 px-3 border-b border-gray-300">Tanggal</th>
                        <th class="py-2 px-3 border-b border-gray-300">Tipe</th>
                        <th class="py-2 px-3 border-b border-gray-300">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($pengajuanTerbaru as $item)
        <tr>
            <td class="py-2 px-3">{{ $item->tanggal_mulai }}</td>
            <td class="py-2 px-3">{{ $item->tipeCuti->nama_cuti ?? '-' }}</td>
            <td class="py-2 px-3">
                <span class="px-3 py-1 rounded-full font-semibold border
                    @if($item->status == 'Diterima')
                        border-green-500 text-green-700 bg-green-50
                    @elseif($item->status == 'Ditolak')
                        border-red-500 text-red-700 bg-red-50
                    @else
                        border-yellow-500 text-yellow-700 bg-yellow-50
                    @endif">
                    {{ $item->status }}
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="py-2 px-3 text-center text-gray-700">Belum ada pengajuan cuti.</td>
        </tr>
    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Riwayat Kegiatan User-->
            <livewire:dashboard.aktivitas-table />
    </div>
</div>




