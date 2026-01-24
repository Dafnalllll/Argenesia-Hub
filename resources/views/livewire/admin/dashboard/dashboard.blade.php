{{-- filepath: d:\Dafa Code\projek-pkl\resources\views\livewire\admin\dashboard\dashboard.blade.php --}}
@section('title', 'Dashboard Admin || Argenesia Hub')

<div class="p-6">
    <h1 class="text-3xl font-bold mb-8 text-white tracking-wide animate-fade-in-down">Dashboard Admin</h1>
    <div class="flex flex-col md:flex-row gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-6 flex flex-col items-center transform hover:scale-105 transition-transform duration-300 cursor-pointer">
            <img src="{{ asset('img/cuti/cuti.webp') }}" alt="Cuti" class="w-12 h-12 mb-2 " />
            <div class="text-4xl font-bold text-white mb-1">24</div>
            <div class="text-lg text-white font-semibold mb-2 text-center">Total Pengajuan Cuti</div>
            <div class="text-xs text-white text-center mb-2 opacity-80">Jumlah seluruh pengajuan cuti oleh karyawan.</div>
            <a href="/cuti-admin/rekap" class="mt-2 px-4 py-2 bg-blue-700 text-white rounded-lg font-semibold shadow hover:scale-110 transition-all">Lihat Rekap</a>
        </div>
        <!-- Card 2 -->
        <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-6 flex flex-col items-center transform hover:scale-105 transition-transform duration-300 cursor-pointer ">
            <img src="{{ asset('img/sidebar/karyawan.webp') }}" alt="Karyawan" class="w-12 h-12 mb-2 " />
            <div class="text-4xl font-bold text-white mb-1">12</div>
            <div class="text-lg text-white font-semibold mb-2">Total Karyawan</div>
            <div class="text-xs text-white text-center mb-2 opacity-80">Jumlah karyawan aktif yang terdaftar di perusahaan.</div>
            <a href="/manajemen-karyawan" class="mt-2 px-4 py-2 bg-green-700  text-white rounded-lg font-semibold shadow hover:scale-110 transition-all">Lihat Karyawan</a>
        </div>
        <!-- Card 3 -->
        <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-6 flex flex-col items-center transform hover:scale-105 transition-transform duration-300 cursor-pointer ">
            <img src="{{ asset('img/cuti/kategori.webp') }}" alt="Rekap" class="w-12 h-12 mb-2 " />
            <div class="text-4xl font-bold text-white mb-1">5</div>
            <div class="text-lg text-white font-semibold mb-2">Kategori Cuti</div>
            <div class="text-xs text-white text-center mb-2 opacity-80">Kategori cuti yang tersedia.</div>
            <a href="/cuti-admin/tipe" class="mt-2 px-4 py-2 bg-red-700 text-white rounded-lg font-semibold shadow hover:scale-110 transition-all">Atur Kategori</a>
        </div>
        <!-- Card 4 -->
        <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-6 flex flex-col items-center transform hover:scale-105 transition-transform duration-300 cursor-pointer ">
            <img src="{{ asset('img/sidebar/profil.webp') }}" alt="User" class="w-12 h-12 mb-2 " />
            <div class="text-4xl font-bold text-white mb-1">{{ $totalUser }}</div>
            <div class="text-lg text-white font-semibold mb-2">Total User</div>
            <div class="text-xs text-white text-center mb-2 opacity-80">Jumlah seluruh user yang sudah masuk ke sistem.</div>
            <a href="/admin/manajemen-user" class="mt-2 px-4 py-2 bg-yellow-700 text-white rounded-lg font-semibold shadow hover:scale-110 transition-all">Lihat User</a>
        </div>
    </div>

    <!-- Tabel Pengajuan Cuti -->
    <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-6 mb-8 ">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Pengajuan Cuti Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                <thead>
                    <tr class="bg-[#0074D9] text-white">
                        <th class="py-3 px-4 rounded-tl-2xl">Tanggal</th>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-blue-100 transition ">
                        <td class="py-2 px-4">2026-01-22</td>
                        <td class="py-2 px-4">Dafa</td>
                        <td class="py-2 px-4">Tahunan</td>
                        <td class="py-2 px-4 text-green-600 font-bold">Disetujui</td>
                        <td class="py-2 px-4">
                            <a href="#" class="text-blue-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-blue-100">
                        <td class="py-2 px-4">2026-01-20</td>
                        <td class="py-2 px-4">Rina</td>
                        <td class="py-2 px-4">Sakit</td>
                        <td class="py-2 px-4 text-yellow-600 font-bold">Menunggu</td>
                        <td class="py-2 px-4">
                            <a href="#" class="text-blue-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-blue-100">
                        <td class="py-2 px-4">2026-01-18</td>
                        <td class="py-2 px-4">Budi</td>
                        <td class="py-2 px-4">Tahunan</td>
                        <td class="py-2 px-4 text-red-600 font-bold">Ditolak</td>
                        <td class="py-2 px-4">
                            <a href="#" class="text-blue-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Tabel Riwayat Aktivitas Admin -->
    <livewire:Admin.AktivitasAdminTable />
</div>


