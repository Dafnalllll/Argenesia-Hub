@section('title', 'Dashboard HR || Argenesia Hub')

<div class="p-6">
    {{-- MOBILE VIEW --}}
    @include('livewire.HR.dashboard.dashboard-mobile')
    {{-- DESKTOP VIEW --}}
    <div class="hidden md:block">
        <h1 class="text-3xl font-bold text-white mb-6">Dashboard HR</h1>
        <div class="space-y-8">
            {{-- Card Statistik --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 transition-all cursor-pointer">
                    <span class="text-lg font-bold text-[#0074D9] mb-1">Jumlah Karyawan</span>
                    <span class="text-3xl font-bold text-[#0074D9] mb-1">{{ $totalKaryawan }}</span>
                    <span class="text-xs text-gray-500 text-center">Total seluruh karyawan aktif di perusahaan.</span>
                </div>
                <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 transition-all cursor-pointer">
                    <span class="text-lg font-bold text-yellow-600 mb-1">Total Pengajuan Cuti</span>
                    <span class="text-3xl font-bold text-yellow-600 mb-1">{{ $totalPengajuan }}</span>
                    <span class="text-xs text-gray-500 text-center">Jumlah seluruh pengajuan cuti yang masuk.</span>
                </div>
                <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 transition-all cursor-pointer">
                    <span class="text-lg font-bold text-green-600 mb-1">Cuti Disetujui</span>
                    <span class="text-3xl font-bold text-green-500 mb-1">{{ $totalDiterima }}</span>
                    <span class="text-xs text-gray-500 text-center">Total pengajuan cuti yang sudah disetujui HR.</span>
                </div>
                <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 transition-all cursor-pointer">
                    <span class="text-lg font-bold text-red-600 mb-1">Cuti Ditolak</span>
                    <span class="text-3xl font-bold text-red-500 mb-1">{{ $totalDitolak }}</span>
                    <span class="text-xs text-gray-500 text-center">Jumlah pengajuan cuti yang ditolak HR.</span>
                </div>
            </div>
            {{-- Card Karyawan Cuti Bulan Ini --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow-lg p-6 flex flex-col items-center hover:scale-105 transition-all cursor-pointer">
                    <span class="text-lg font-bold text-orange-600 mb-1">Karyawan Cuti Bulan Ini</span>
                    <span class="text-3xl font-bold text-orange-600 mb-1">{{ $karyawanCutiBulanIni }}</span>
                    <span class="text-xs text-gray-500 text-center">Jumlah karyawan yang mengambil cuti pada bulan ini.</span>
                </div>
            </div>
            {{-- Tabel Ringkasan Pengajuan Cuti Terbaru --}}
            <div>
                <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-xl shadow-lg p-6 h-full flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Pengajuan Cuti Terbaru</h2>
                        <a href="{{ route('hr.manajemen-cuti.rekap-cuti') }}"
                            class="text-[#0074D9] font-semibold hover:underline">Lihat Semua</a>
                    </div>
                    <div class="overflow-x-auto flex-1">
                        <table class="min-w-275 w-full text-sm text-gray-700 rounded-2xl shadow-lg border-separate border-spacing-0">
                            <thead>
                                <tr class="bg-linear-to-r from-[#F53003] to-[#0074D9] text-white sticky top-0 z-10">
                                    <th class="py-4 px-6 rounded-tl-2xl text-left">No</th>
                                    <th class="py-4 px-6 text-left">Nama Karyawan</th>
                                    <th class="py-4 px-6 text-left">Tipe</th>
                                    <th class="py-4 px-6 text-left">Tanggal Pengajuan</th>
                                    <th class="py-4 px-6 rounded-tr-2xl text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuanTerbaru as $i => $cuti)
                                    <tr class="hover:bg-blue-50 transition border-b border-blue-100">
                                        <td class="py-3 px-6 font-bold">{{ $i+1 }}</td>
                                        <td class="py-3 px-6">{{ $cuti->karyawan->user->name ?? '-' }}</td>
                                        <td class="py-3 px-6">{{ $cuti->tipeCuti->nama_cuti ?? '-' }}</td>
                                        <td class="py-3 px-6">{{ \Illuminate\Support\Str::limit($cuti->created_at, 10, '') }}</td>
                                        <td class="py-3 px-6">
                                            @if($cuti->status == 'Disetujui')
                                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Diterima</span>
                                            @elseif($cuti->status == 'Ditolak')
                                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Ditolak</span>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Menunggu</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-gray-800">Tidak ada data cuti terbaru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Aktivitas HR (di bawah tabel cuti terbaru) --}}
            <livewire:hr.aktivitas-h-r-table />
        </div>
    </div>
</div>
