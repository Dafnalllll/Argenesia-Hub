@section('title', 'Cuti || Argenesia Hub')
<div>
    <!-- Judul Manajemen Cuti -->
    <div class="w-full flex justify-start mt-12 mb-10">
    <div class="flex items-center gap-4">
        <img src="{{ asset('img/cuti/cuti.webp') }}" alt="Cuti" class="w-10 h-10 drop-shadow-lg animate-bounce-slow" />
        <span class="text-4xl font-extrabold bg-white bg-clip-text text-transparent drop-shadow-lg tracking-wide uppercase font-[Poppins]">
            Manajemen Cuti
        </span>
    </div>
</div>
    <!-- Card Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 mt-20">
        <!-- Card Sisa Cuti -->
        <div class="bg-white/30 backdrop-blur-md rounded-xl shadow p-6 flex flex-col items-center hover:scale-105 transition-all cursor-pointer">
            <img src="{{ asset('img/cuti/pengajuan.webp') }}" alt="Sisa Cuti" class="w-10 h-10 mb-2" />
            <span class="text-3xl font-bold text-[#0074D9]">5</span>
            <span class="mt-2 text-gray-700">Sisa Cuti</span>
            <span class="text-xs text-gray-500 mt-1 text-center">Cuti yang masih bisa kamu ajukan tahun ini.</span>
        </div>
        <!-- Card Total Pengajuan -->
        <div class="bg-white/30 backdrop-blur-md rounded-xl shadow p-6 flex flex-col items-center hover:scale-105 transition-all cursor-pointer">
            <img src="{{ asset('img/cuti/cuti.webp') }}" alt="Total Pengajuan" class="w-10 h-10 mb-2" />
            <span class="text-3xl font-bold text-[#F53003]">12</span>
            <span class="mt-2 text-gray-700">Total Pengajuan</span>
            <span class="text-xs text-gray-500 mt-1 text-center">Total semua pengajuan cuti yang pernah kamu lakukan.</span>
        </div>
        <!-- Card Cuti Diproses -->
        <div class="bg-white/30 backdrop-blur-md rounded-xl shadow p-6 flex flex-col items-center hover:scale-105 transition-all cursor-pointer">
            <img src="{{ asset('img/cuti/riwayat.webp') }}" alt="Cuti Diproses" class="w-10 h-10 mb-2" />
            <span class="text-3xl font-bold text-[#16a34a]">1</span>
            <span class="mt-2 text-gray-700">Cuti Diproses</span>
            <span class="text-xs text-gray-500 mt-1 text-center">Pengajuan cuti yang sedang menunggu persetujuan.</span>
        </div>
    </div>

    <!-- Overview Pengajuan Cuti -->
    <div class="bg-white/40 backdrop-blur-md rounded-2xl shadow-lg p-8 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-[#0074D9]">Pengajuan Cuti Terakhir</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="block text-gray-700 font-semibold">Tanggal Mulai</span>
                <span class="block text-gray-900">2026-01-20</span>
            </div>
            <div>
                <span class="block text-gray-700 font-semibold">Status</span>
                <span class="block text-yellow-600 font-semibold">Menunggu</span>
            </div>
        </div>
        <div class="mt-4">
            <a href="/cuti/pengajuan" class="inline-block px-4 py-2 rounded-lg bg-[#0074D9] text-white font-semibold shadow hover:bg-[#005fa3] transition-all hover:scale-105 cursor-pointer">Ajukan Cuti Baru</a>
        </div>
    </div>

    <!-- Overview Riwayat Pengajuan -->
    <div class="bg-white/40 backdrop-blur-md rounded-2xl shadow-lg p-8 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-[#F53003]">Riwayat Pengajuan Cuti Terbaru</h2>
        </div>
        <table class="min-w-full text-sm border border-gray-300 rounded-lg overflow-hidden mt-2">
            <thead class="bg-gray-100">
                <tr class="text-left text-gray-700">
                    <th class="py-2 px-3 border-b border-gray-300">Tanggal</th>
                    <th class="py-2 px-3 border-b border-gray-300">Jenis</th>
                    <th class="py-2 px-3 border-b border-gray-300">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr>
                    <td class="py-2 px-3">2026-01-22</td>
                    <td class="py-2 px-3">Tahunan</td>
                    <td class="py-2 px-3 text-green-600 font-semibold">Disetujui</td>
                </tr>
                <tr>
                    <td class="py-2 px-3">2026-01-20</td>
                    <td class="py-2 px-3">Sakit</td>
                    <td class="py-2 px-3 text-yellow-600 font-semibold">Menunggu</td>
                </tr>
                <tr>
                    <td class="py-2 px-3">2026-01-18</td>
                    <td class="py-2 px-3">Tahunan</td>
                    <td class="py-2 px-3 text-red-600 font-semibold">Ditolak</td>
                </tr>
                <tr>
                    <td class="py-2 px-3">2026-01-15</td>
                    <td class="py-2 px-3">Izin</td>
                    <td class="py-2 px-3 text-green-600 font-semibold">Disetujui</td>
                </tr>
                <tr>
                    <td class="py-2 px-3">2026-01-10</td>
                    <td class="py-2 px-3">Tahunan</td>
                    <td class="py-2 px-3 text-green-600 font-semibold">Disetujui</td>
                </tr>
            </tbody>
        </table>
        <div class="mt-4">
            <a href="/cuti/riwayat" class="inline-block px-4 py-2 rounded-lg bg-[#F53003] text-white font-semibold shadow hover:bg-[#c41e00] transition-all hover:scale-105 cursor-pointer">Lihat Riwayat Lengkap</a>
        </div>
    </div>
</div>


