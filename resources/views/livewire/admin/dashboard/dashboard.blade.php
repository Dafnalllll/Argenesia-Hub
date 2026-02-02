{{-- filepath: d:\Dafa Code\projek-pkl\resources\views\livewire\admin\dashboard\dashboard.blade.php --}}
@section('title', 'Dashboard Admin || Argenesia Hub')

<div>
    {{-- Mobile --}}
    @include('livewire.admin.dashboard.dashboard-mobile')

    <div class="hidden md:block p-6">

        {{-- Desktop --}}
        <h1 class="text-3xl font-bold mb-8 text-white tracking-wide animate-fade-in-down flex items-center gap-4">
            <img src="{{ asset('img/role/admin.webp') }}" alt="Admin" class="w-10 h-10" />
            Dashboard Admin
        </h1>
        <div class="flex flex-col md:flex-row gap-6 mb-8">
            <!-- Card 1 -->
            <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-6 flex flex-col items-center transform hover:scale-105 transition-transform duration-300 cursor-pointer">
                <img src="{{ asset('img/cuti/cuti.webp') }}" alt="Cuti" class="w-12 h-12 mb-2 " />
                <div class="text-4xl font-bold text-white mb-1">{{ $totalPengajuanCuti }}</div>
                <div class="text-lg text-white font-semibold mb-2 text-center">Total Pengajuan Cuti</div>
                <div class="text-xs text-white text-center mb-2 opacity-80">Jumlah seluruh pengajuan cuti oleh karyawan.</div>
                <a href="/admin/manajemen-cuti/rekap-cuti" class="mt-2 px-4 py-2 bg-blue-700 text-white rounded-lg font-semibold shadow hover:scale-110 transition-all">Lihat Rekap</a>
            </div>
            <!-- Card 2 -->
            <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-6 flex flex-col items-center transform hover:scale-105 transition-transform duration-300 cursor-pointer ">
                <img src="{{ asset('img/sidebar/karyawan.webp') }}" alt="Karyawan" class="w-12 h-12 mb-2 " />
                <div class="text-4xl font-bold text-white mb-1">{{ $totalKaryawan }}</div>
                <div class="text-lg text-white font-semibold mb-2">Total Karyawan</div>
                <div class="text-xs text-white text-center mb-2 opacity-80">Jumlah karyawan aktif yang terdaftar di perusahaan.</div>
                <a href="/admin/manajemen-karyawan" class="mt-2 px-4 py-2 bg-green-700  text-white rounded-lg font-semibold shadow hover:scale-110 transition-all">Lihat Karyawan</a>
            </div>
            <!-- Card 3 -->
            <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-6 flex flex-col items-center transform hover:scale-105 transition-transform duration-300 cursor-pointer ">
                <img src="{{ asset('img/cuti/kategori.webp') }}" alt="Rekap" class="w-12 h-12 mb-2 " />
                <div class="text-4xl font-bold text-white mb-1">{{ $totalTipeCuti }}</div>
                <div class="text-lg text-white font-semibold mb-2">Tipe Cuti</div>
                <div class="text-xs text-white text-center mb-2 opacity-80">Tipe cuti yang tersedia.</div>
                <a href="/admin/manajemen-cuti/atur-tipe-cuti" class="mt-2 px-4 py-2 bg-red-700 text-white rounded-lg font-semibold shadow hover:scale-110 transition-all">Atur Tipe</a>
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
                            <th class="py-3 px-4 rounded-tl-2xl text-center">Tanggal</th>
                            <th class="py-3 px-4 text-center">Nama</th>
                            <th class="py-3 px-4 text-center">Tipe</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 rounded-tr-2xl text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuanCutiTerbaru as $cuti)
                            <tr class="hover:bg-blue-100 transition text-center">
                                <td class="py-2 px-4">{{ \Carbon\Carbon::parse($cuti->created_at)->format('Y-m-d') }}</td>
                                <td class="py-2 px-4">{{ $cuti->karyawan->user->name ?? '-' }}</td>
                                <td class="py-2 px-4">{{ $cuti->tipeCuti->nama_cuti ?? '-' }}</td>
                                <td class="py-2 px-4">
                                    @if($cuti->status === 'Disetujui')
                                        <span class="text-green-600 font-bold">Disetujui</span>
                                    @elseif($cuti->status === 'Ditolak')
                                        <span class="text-red-600 font-bold">Ditolak</span>
                                    @else
                                        <span class="text-yellow-600 font-bold">Menunggu</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4">
                                    @if($cuti->file_pengajuan)
                                        <a href="{{ asset('storage/' . $cuti->file_pengajuan) }}" target="_blank" title="Lihat File">
                                            <img src="{{ asset('img/action/file.webp') }}" alt="File" class="w-6 h-6 inline-block hover:scale-110 transition-transform mx-auto" />
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-800">Tidak ada data pengajuan cuti.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel List Tipe Cuti -->
        <div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-6 mb-8">
            <h2 class="text-xl font-bold mb-4 text-gray-800">List Tipe Cuti Tersedia</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-gray-700">
                    <thead>
                        <tr class="bg-[#16a34a] text-white">
                            <th class="py-3 px-4 rounded-tl-2xl text-center">No</th>
                            <th class="py-3 px-4 text-center">Tipe Cuti</th>
                            <th class="py-3 px-4 text-center">Jumlah Hari</th>
                            <th class="py-3 px-4 rounded-tr-2xl text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($tipeCutis as $i => $tipe)
                        <tr class="hover:bg-gray-100 transition text-center">
                            <td class="py-2 px-4">{{ $i + 1 }}</td>
                            <td class="py-2 px-4">{{ $tipe->nama_cuti }}</td>
                            <td class="py-2 px-4">{{ $tipe->maksimal_hari ?? '-' }}</td>
                            <td class="py-2 px-4 flex justify-center gap-2">
                                <a href="{{ route('admin.manajemen-cuti.atur-tipe-cuti.edit', $tipe->id) }}"
                                    title="Edit">
                                    <img src="{{ asset('img/action/edit.webp') }}" alt="Edit" class="w-5 h-5 inline cursor-pointer hover:scale-110 transition" />
                                </a>
                                <button type="button" title="Delete" class="focus:outline-none"
                                    wire:click="confirmDelete({{ $tipe->id }})">
                                    <img src="{{ asset('img/action/delete.webp') }}" alt="Delete" class="w-6 h-6 cursor-pointer hover:scale-110 transition" />
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-800">Tidak ada tipe cuti tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>
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
                    Yakin ingin menghapus tipe cuti ini? Data yang dihapus <b>tidak dapat dikembalikan</b>.
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

        <!-- Tabel Riwayat Aktivitas Admin -->
        <livewire:Admin.AktivitasAdminTable />
    </div>
</div>


