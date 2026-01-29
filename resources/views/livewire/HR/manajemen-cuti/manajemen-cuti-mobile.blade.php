<div class="block md:hidden px-2 py-16 md:p-8">
    <h1 class="text-xl font-bold mb-6 text-white flex items-center justify-center gap-3">
        <img src="{{ asset('img/cuti/cuti.webp') }}" alt="Admin" class="w-7 h-7" />
        Manajemen Cuti
    </h1>
    <!-- Statistik Card -->
    <div class="grid grid-cols-2 gap-3 mb-6">
        <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow p-3 flex flex-col items-center">
            <svg class="w-7 h-7 text-indigo-500 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="6" y="4" width="12" height="16" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
                <path d="M9 4V2h6v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div class="text-lg font-bold text-indigo-700">{{ $totalPengajuan }}</div>
            <div class="text-xs text-indigo-700 font-semibold">Pengajuan</div>
        </div>
        <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow p-3 flex flex-col items-center">
            <svg class="w-7 h-7 text-green-500 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div class="text-lg font-bold text-green-700">{{ $totalDisetujui }}</div>
            <div class="text-xs text-green-700 font-semibold">Disetujui</div>
        </div>
        <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow p-3 flex flex-col items-center">
            <svg class="w-7 h-7 text-red-500 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div class="text-lg font-bold text-red-700">{{ $totalDitolak }}</div>
            <div class="text-xs text-red-700 font-semibold">Ditolak</div>
        </div>
        <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow p-3 flex flex-col items-center">
            <svg class="w-7 h-7 text-yellow-500 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div class="text-lg font-bold text-yellow-700">{{ $totalMenunggu }}</div>
            <div class="text-xs text-yellow-700 font-semibold">Menunggu</div>
        </div>
    </div>

    <!-- Riwayat Pengajuan Cuti Singkat (Tabel Mobile) -->
    <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow p-3 mt-6">
        <h2 class="text-base font-bold mb-3 text-gray-800">Riwayat Pengajuan Cuti</h2>
        <div class="overflow-x-auto w-75">
            <table class="min-w-100 w-full text-xs text-gray-700 rounded-2xl shadow-lg border-separate border-spacing-0">
                <thead>
                    <tr class="bg-linear-to-r from-indigo-500 to-blue-500 text-white">
                        <th class="py-3 px-4 rounded-tl-2xl text-left">Nama</th>
                        <th class="py-3 px-4 text-center">Tanggal</th>
                        <th class="py-3 px-4 text-center">Tipe</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 rounded-tr-2xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuanCuti as $item)
                        <tr>
                            <td class="py-2 px-4 text-left">{{ $item->karyawan->user->name ?? '-' }}</td>
                            <td class="py-2 px-4 text-center">{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('Y-m-d') }}</td>
                            <td class="py-2 px-4 text-center">{{ $item->tipeCuti->nama_cuti ?? '-' }}</td>
                            <td class="py-2 px-4 text-center">
                                @if($item->status === 'Disetujui')
                                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-semibold">Disetujui</span>
                                @elseif($item->status === 'Ditolak')
                                    <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-semibold">Ditolak</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded text-xs font-semibold">Menunggu</span>
                                @endif
                            </td>
                            <td class="py-2 px-4 text-center">
                                <button wire:click="showDetail({{ $item->id }})" title="Detail" class="inline-flex items-center">
                                    <img src="{{ asset('img/action/detail.webp') }}" alt="Detail" class="w-5 h-5 hover:scale-110 transition-transform cursor-pointer" />
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-700 py-4">Tidak ada data cuti ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex justify-end">
            <a href="/hr/manajemen-cuti/rekap-cuti"
                class="bg-indigo-500 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-600 transition font-semibold text-xs flex items-center gap-2 group hover:scale-105 ">
                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1 cursor-pointer" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Lihat Lengkap
            </a>
        </div>
    </div>

    <!-- Modal Detail Pengajuan Cuti -->
    @if($showDetailModal && $selectedCuti)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-2">
            <div class="bg-linear-to-r from-[#F53003] to-[#0074D9] rounded-xl p-4 shadow-lg w-full max-w-xs relative">
                <button wire:click="$set('showDetailModal', false)" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl cursor-pointer">&times;</button>
                <h3 class="text-base font-bold mb-3 text-indigo-700">Detail Pengajuan Cuti</h3>
                <div class="mb-1 text-xs"><span class="font-semibold">Nama :</span> {{ $selectedCuti->karyawan->user->name ?? '-' }}</div>
                <div class="mb-1 text-xs"><span class="font-semibold">Tanggal Pengajuan :</span> {{ \Carbon\Carbon::parse($selectedCuti->tanggal_pengajuan)->format('Y-m-d') }}</div>
                <div class="mb-1 text-xs"><span class="font-semibold">Tipe :</span> {{ $selectedCuti->tipeCuti->nama_cuti ?? '-' }}</div>
                <div class="mb-1 text-xs"><span class="font-semibold">Status :</span> {{ $selectedCuti->status }}</div>
                <div class="mb-1 text-xs"><span class="font-semibold">Tanggal Mulai :</span> {{ \Carbon\Carbon::parse($selectedCuti->tanggal_mulai)->format('Y-m-d') }}</div>
                <div class="mb-1 text-xs"><span class="font-semibold">Tanggal Selesai :</span> {{ \Carbon\Carbon::parse($selectedCuti->tanggal_selesai)->format('Y-m-d') }}</div>
                <div class="mb-1 text-xs"><span class="font-semibold">Keterangan :</span> {{ $selectedCuti->keterangan }}</div>
                <div class="mb-1 flex items-center gap-2 text-xs">
                    <span class="font-semibold">File :</span>
                    @if($selectedCuti->file_pengajuan)
                        <a href="{{ asset('storage/' . $selectedCuti->file_pengajuan) }}" target="_blank"
                            class="inline-flex items-center px-2 py-1 rounded bg-indigo-500 text-white hover:bg-indigo-600 transition text-xs gap-2">
                            <img src="{{ asset('img/action/file.webp') }}" alt="File" class="w-4 h-4" />
                            Lihat File
                        </a>
                    @else
                        <span class="text-gray-400">Tidak ada file</span>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
