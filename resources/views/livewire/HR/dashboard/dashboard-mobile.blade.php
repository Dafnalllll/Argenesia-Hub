<div class="block md:hidden -ml-1 py-4 md:p-8 ">
    <h1 class="text-xl font-bold mb-6 text-white flex items-center justify-center gap-3 mt-10">
        <img src="{{ asset('img/role/hr.webp') }}" alt="HR" class="w-7 h-7" />
        Dashboard HR
    </h1>
    <div class="space-y-4">
        {{-- Card Statistik (Stacked) --}}
        <div class="space-y-3">
            <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow-lg p-4 flex flex-col items-center">
                <span class="text-base font-bold text-[#0074D9] mb-1">Jumlah Karyawan</span>
                <span class="text-2xl font-bold text-[#0074D9] mb-1">{{ $totalKaryawan }}</span>
                <span class="text-xs text-gray-500 text-center">Total seluruh karyawan aktif di perusahaan.</span>
            </div>
            <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow-lg p-4 flex flex-col items-center">
                <span class="text-base font-bold text-yellow-600 mb-1">Total Pengajuan Cuti</span>
                <span class="text-2xl font-bold text-yellow-600 mb-1">{{ $totalPengajuan }}</span>
                <span class="text-xs text-gray-500 text-center">Jumlah seluruh pengajuan cuti yang masuk.</span>
            </div>
            <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow-lg p-4 flex flex-col items-center">
                <span class="text-base font-bold text-green-600 mb-1">Cuti Disetujui</span>
                <span class="text-2xl font-bold text-green-500 mb-1">{{ $totalDiterima }}</span>
                <span class="text-xs text-gray-500 text-center">Total pengajuan cuti yang sudah disetujui HR.</span>
            </div>
            <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow-lg p-4 flex flex-col items-center">
                <span class="text-base font-bold text-red-600 mb-1">Cuti Ditolak</span>
                <span class="text-2xl font-bold text-red-500 mb-1">{{ $totalDitolak }}</span>
                <span class="text-xs text-gray-500 text-center">Jumlah pengajuan cuti yang ditolak HR.</span>
            </div>
            <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow-lg p-4 flex flex-col items-center">
                <span class="text-base font-bold text-[#0074D9] mb-1">Karyawan Cuti Bulan Ini</span>
                <span class="text-2xl font-bold text-[#0074D9] mb-1">{{ $karyawanCutiBulanIni }}</span>
                <span class="text-xs text-gray-500 text-center">Jumlah karyawan yang mengambil cuti pada bulan ini.</span>
            </div>
        </div>
        {{-- Tabel Ringkasan (Scroll) --}}
        <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow-lg p-2">
            <div class="flex justify-center md:justify-between items-center mb-2">
                <h2 class="text-lg font-bold text-center md:text-left">Pengajuan Cuti Terbaru</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-max w-full text-xs text-gray-700 rounded-xl shadow border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-linear-to-r from-[#F53003] to-[#0074D9] text-white">
                            <th class="py-2 px-2 rounded-tl-xl text-left">No</th>
                            <th class="py-2 px-2 text-left">Nama</th>
                            <th class="py-2 px-2 text-left">Tipe</th>
                            <th class="py-2 px-2 text-left">Tanggal</th>
                            <th class="py-2 px-2 rounded-tr-xl text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuanTerbaru as $i => $cuti)
                            <tr class="hover:bg-blue-50 transition border-b border-blue-100">
                                <td class="py-1 px-2 font-bold">{{ $i+1 }}</td>
                                <td class="py-1 px-2">{{ $cuti->karyawan->user->name ?? '-' }}</td>
                                <td class="py-1 px-2">{{ $cuti->tipeCuti->nama_cuti ?? '-' }}</td>
                                <td class="py-1 px-2">{{ \Illuminate\Support\Str::limit($cuti->created_at, 10, '') }}</td>
                                <td class="py-1 px-2">
                                    @if($cuti->status == 'Disetujui')
                                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">Diterima</span>
                                    @elseif($cuti->status == 'Ditolak')
                                        <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-semibold">Ditolak</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-xs font-semibold">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-800">Tidak ada data cuti terbaru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <a href="{{ route('hr.manajemen-cuti.rekap-cuti') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 mt-8 rounded-lg bg-linear-to-r from-[#0074D9] to-[#F53003] text-white font-bold shadow-md hover:scale-105 hover:shadow-lg transition-all duration-200 text-sm group">
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l7-7-7-7M22 12H3"/>
                            </svg>
                            Lihat Semua
                </a>
            </div>
        </div>
        {{-- Aktivitas HR mobile (di bawah tabel cuti terbaru) --}}
        <livewire:hr.aktivitas-h-r-table />
    </div>
</div>
