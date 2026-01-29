

<div class="block md:hidden -ml-1 py-4 md:p-8 ">
    <h1 class="text-2xl font-bold text-white mb-4 text-center">Dashboard HR</h1>
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
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-bold">Pengajuan Cuti Terbaru</h2>
                <a href="{{ route('hr.manajemen-cuti.rekap-cuti') }}"
                    class="text-[#0074D9] font-semibold hover:underline text-sm">Lihat Semua</a>
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
            </div>
        </div>
        {{-- Aktivitas HR mobile (di bawah tabel cuti terbaru) --}}
        <livewire:hr.aktivitas-h-r-table />
    </div>
</div>
