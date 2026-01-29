<div class="block md:hidden px-2 py-6">
    <!-- Judul -->
    <h1 class="text-xl font-bold mb-6 text-white flex items-center justify-center gap-3 mt-10">
        <img src="{{ asset('img/role/admin.webp') }}" alt="Admin" class="w-7 h-7" />
        Dashboard Admin
    </h1>
    <!-- Statistik Card (bisa grid 2 kolom) -->
    <div class="grid grid-cols-2 gap-3 mb-6">
        <!-- Card Pengajuan Cuti -->
        <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-xl shadow p-3 flex flex-col items-center">
            <img src="{{ asset('img/cuti/cuti.webp') }}" alt="Cuti" class="w-10 h-10 mb-2" />
            <div class="text-2xl font-bold text-white mb-1">{{ $totalPengajuanCuti }}</div>
            <div class="text-sm text-white font-semibold mb-2 text-center">Pengajuan Cuti</div>
            <a href="/cuti-admin/rekap" class="mt-2 px-3 py-1 bg-blue-700 text-white rounded-lg font-semibold shadow text-xs">Lihat Rekap</a>
        </div>
        <!-- Card Karyawan -->
        <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-xl shadow p-3 flex flex-col items-center">
            <img src="{{ asset('img/sidebar/karyawan.webp') }}" alt="Karyawan" class="w-10 h-10 mb-2" />
            <div class="text-2xl font-bold text-white mb-1">{{ $totalKaryawan }}</div>
            <div class="text-sm text-white font-semibold mb-2 text-center">Karyawan</div>
            <a href="/admin/manajemen-karyawan" class="mt-2 px-3 py-1 bg-green-700 text-white rounded-lg font-semibold shadow text-xs">Lihat Karyawan</a>
        </div>
        <!-- Card Tipe Cuti -->
        <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-xl shadow p-3 flex flex-col items-center">
            <img src="{{ asset('img/cuti/kategori.webp') }}" alt="Rekap" class="w-10 h-10 mb-2" />
            <div class="text-2xl font-bold text-white mb-1">{{ $totalTipeCuti }}</div>
            <div class="text-sm text-white font-semibold mb-2 text-center">Tipe Cuti</div>
            <a href="/admin/manajemen-cuti/atur-tipe-cuti" class="mt-2 px-3 py-1 bg-red-700 text-white rounded-lg font-semibold shadow text-xs">Atur Tipe</a>
        </div>
        <!-- Card User -->
        <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-xl shadow p-3 flex flex-col items-center">
            <img src="{{ asset('img/sidebar/profil.webp') }}" alt="User" class="w-10 h-10 mb-2" />
            <div class="text-2xl font-bold text-white mb-1">{{ $totalUser }}</div>
            <div class="text-sm text-white font-semibold mb-2 text-center">User</div>
            <a href="/admin/manajemen-user" class="mt-2 px-3 py-1 bg-yellow-700 text-white rounded-lg font-semibold shadow text-xs">Lihat User</a>
        </div>
    </div>
    <!-- Tabel Pengajuan Cuti Terbaru (versi mobile) -->
    <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-xl shadow p-3 mb-6">
        <h2 class="text-base font-bold mb-3 text-gray-800">Pengajuan Cuti Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-xs text-gray-700">
                <thead>
                    <tr class="bg-[#0074D9] text-white">
                        <th class="py-2 px-2 text-center">Tanggal</th>
                        <th class="py-2 px-2 text-center">Nama</th>
                        <th class="py-2 px-2 text-center">Tipe</th>
                        <th class="py-2 px-2 text-center">Status</th>
                        <th class="py-2 px-2 text-center">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuanCutiTerbaru as $cuti)
                        <tr class="hover:bg-blue-100 transition text-center">
                            <td class="py-1 px-2">{{ \Carbon\Carbon::parse($cuti->created_at)->format('Y-m-d') }}</td>
                            <td class="py-1 px-2">{{ $cuti->karyawan->user->name ?? '-' }}</td>
                            <td class="py-1 px-2">{{ $cuti->tipeCuti->nama_cuti ?? '-' }}</td>
                            <td class="py-1 px-2">
                                @if($cuti->status === 'Disetujui')
                                    <span class="text-green-600 font-bold">Disetujui</span>
                                @elseif($cuti->status === 'Ditolak')
                                    <span class="text-red-600 font-bold">Ditolak</span>
                                @else
                                    <span class="text-yellow-600 font-bold">Menunggu</span>
                                @endif
                            </td>
                            <td class="py-1 px-2">
                                @if($cuti->file_pengajuan)
                                    <a href="{{ asset('storage/' . $cuti->file_pengajuan) }}" target="_blank" title="Lihat File">
                                        <img src="{{ asset('img/action/file.webp') }}" alt="File" class="w-5 h-5 inline-block hover:scale-110 transition-transform mx-auto" />
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-800">Tidak ada data pengajuan cuti.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Tabel Riwayat Aktivitas Admin (mobile) -->
    <livewire:Admin.AktivitasAdminTable />
</div>
