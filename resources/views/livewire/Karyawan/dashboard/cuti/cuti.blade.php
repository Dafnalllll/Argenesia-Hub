@section('title', 'Cuti || Argenesia Hub')
<div>
    <!-- Judul Manajemen Cuti -->
    <div class="w-full flex justify-start mt-12 mb-10">
    <div class="flex items-center gap-4">
        <img src="{{ asset('img/cuti/cuti.webp') }}" alt="Cuti" class="w-10 h-10 drop-shadow-lg animate-bounce-slow" />
        <span class="text-4xl font-extrabold bg-white bg-clip-text text-transparent drop-shadow-lg tracking-wide">
            Manajemen Cuti
        </span>
    </div>
</div>
    <!-- Card Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 mt-20">
        <!-- Card Sisa Cuti -->
        <div class="bg-white/30 backdrop-blur-md rounded-xl shadow p-6 flex flex-col items-center hover:scale-105 transition-all cursor-pointer">
            <img src="{{ asset('img/cuti/pengajuan.webp') }}" alt="Sisa Cuti" class="w-10 h-10 mb-2" />
            <span class="text-3xl font-bold text-[#0074D9]">{{ $sisaCuti }}</span>
            <span class="mt-2 text-gray-700">Sisa Cuti</span>
            <span class="text-xs text-gray-500 mt-1 text-center">Cuti yang masih bisa kamu ajukan tahun ini.</span>
        </div>
        <!-- Card Total Pengajuan -->
        <div class="bg-white/30 backdrop-blur-md rounded-xl shadow p-6 flex flex-col items-center hover:scale-105 transition-all cursor-pointer">
            <img src="{{ asset('img/cuti/cuti.webp') }}" alt="Total Pengajuan" class="w-10 h-10 mb-2" />
            <span class="text-3xl font-bold text-[#F53003]">{{ $totalPengajuan }}</span>
            <span class="mt-2 text-gray-700">Total Pengajuan</span>
            <span class="text-xs text-gray-500 mt-1 text-center">Total semua pengajuan cuti yang pernah kamu lakukan.</span>
        </div>
        <!-- Card Cuti Diproses -->
        <div class="bg-white/30 backdrop-blur-md rounded-xl shadow p-6 flex flex-col items-center hover:scale-105 transition-all cursor-pointer">
            <img src="{{ asset('img/cuti/riwayat.webp') }}" alt="Cuti Diproses" class="w-10 h-10 mb-2" />
            <span class="text-3xl font-bold text-[#16a34a]">{{ $cutiDiproses }}</span>
            <span class="mt-2 text-gray-700">Cuti Diproses</span>
            <span class="text-xs text-gray-500 mt-1 text-center">Pengajuan cuti yang sedang menunggu persetujuan.</span>
        </div>
    </div>

    <!-- Overview Pengajuan Cuti -->
    <div class="bg-white/40 backdrop-blur-md rounded-2xl shadow-lg p-8 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-[#0074D9]">Pengajuan Cuti Terakhir</h2>
        </div>
        @if($pengajuanTerakhir)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <span class="block text-gray-700 font-semibold">Tanggal Mulai</span>
                    <span class="block text-gray-900">{{ $pengajuanTerakhir->tanggal_mulai }}</span>
                </div>
                <div>
                    <span class="block text-gray-700 font-semibold">Tipe Cuti</span>
                    <span class="block text-gray-900">{{ $pengajuanTerakhir->tipeCuti->nama_cuti ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-gray-700 font-semibold">Status</span>
                    <span class="block
                        @if($pengajuanTerakhir->status == 'Diterima') text-green-600
                        @elseif($pengajuanTerakhir->status == 'Ditolak') text-red-600
                        @else text-yellow-600 @endif
                        font-semibold">
                        {{ $pengajuanTerakhir->status }}
                    </span>
                </div>
            </div>
        @else
            <div class="text-gray-500">Belum ada pengajuan cuti.</div>
        @endif
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
                    <th class="py-2 px-3 border-b border-gray-300">Tanggal Mulai</th>
                    <th class="py-2 px-3 border-b border-gray-300">Tanggal Selesai</th>
                    <th class="py-2 px-3 border-b border-gray-300">Jenis</th>
                    <th class="py-2 px-3 border-b border-gray-300">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($riwayatPengajuan as $item)
                    <tr>
                        <td class="py-2 px-3">{{ $item->tanggal_mulai }}</td>
                        <td class="py-2 px-3">{{ $item->tanggal_selesai }}</td>
                        <td class="py-2 px-3">{{ $item->tipeCuti->nama_cuti ?? '-' }}</td>
                        <td class="py-2 px-3">
                            <span class="px-3 py-1 rounded-full font-semibold border
                                @if($item->status == 'Diterima') border-green-500 text-green-700 bg-green-50
                                @elseif($item->status == 'Ditolak') border-red-500 text-red-700 bg-red-50
                                @else border-yellow-500 text-yellow-700 bg-yellow-50 @endif">
                                {{ $item->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-2 px-3 text-center text-gray-500">Belum ada riwayat pengajuan cuti.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            <a href="/cuti/riwayat" class="inline-block px-4 py-2 rounded-lg bg-[#F53003] text-white font-semibold shadow hover:bg-[#c41e00] transition-all hover:scale-105 cursor-pointer">Lihat Riwayat Lengkap</a>
        </div>
    </div>
</div>


