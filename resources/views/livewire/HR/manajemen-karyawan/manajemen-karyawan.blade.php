@section('title', 'Manajemen Karyawan || Argenesia Hub')

<div class="p-6"
    x-data="{
        search: '',
        currentPage: 1,
        perPage: 10,
        showModal: false,
        selectedKaryawan: null,
        karyawans: @js($karyawans),
        get filteredKaryawans() {
            if (!this.search) return this.karyawans;
            return this.karyawans.filter(k =>
                (k.user?.name ?? '').toLowerCase().includes(this.search.toLowerCase()) ||
                (k.user?.email ?? '').toLowerCase().includes(this.search.toLowerCase())
            );
        },
        get paginatedKaryawans() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.filteredKaryawans.slice(start, start + this.perPage);
        },
        get totalPages() {
            return Math.ceil(this.filteredKaryawans.length / this.perPage) || 1;
        },
        goToPage(page) {
            if (page < 1) page = 1;
            if (page > this.totalPages) page = this.totalPages;
            this.currentPage = page;
        },
        detail: @js($karyawans->keyBy('id'))
    }"
>

    {{-- MOBILE VIEW --}}
    @include('livewire.HR.manajemen-karyawan.manajemen-karyawan-mobile')

    {{-- DESKTOP VIEW --}}
    <div class="hidden md:flex items-center gap-3 mb-8 justify-start">
        <img
            src="{{ asset('img/sidebar/karyawan.webp') }}"
            alt="Admin"
            class="w-10 h-10"
        />
        <span
            class="text-lg font-bold text-white tracking-wide text-center"
        >
            Manajemen Karyawan
        </span>
    </div>

    <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-2xl shadow-2xl p-6 hidden md:block">

        <!-- Search -->
        <div class="hidden md:flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <div class="relative w-55 group">
                <input
                    type="text"
                    x-model="search"
                    @input="currentPage = 1"
                    placeholder="Cari karyawan..."
                    class="pl-10 pr-10 py-2 rounded-lg border border-gray-800 focus:outline-none w-full shadow transition-all duration-300
                        group-hover:scale-105 group-focus-within:scale-105 group-hover:shadow-lg group-focus-within:shadow-lg group-hover:border-[#F53003]"
                />
                <span class="absolute left-3 top-2.5 text-gray-700 transition-all duration-300 group-hover:scale-110 group-focus-within:scale-110 group-hover:text-[#F53003] group-focus-within:text-[#F53003]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                </span>
                <button
                    type="button"
                    x-show="search"
                    @click="search = ''; currentPage = 1"
                    class="absolute right-3 top-2.5 text-gray-700 hover:text-red-500 transition-all duration-200 cursor-pointer"
                    style="display: none;"
                    tabindex="-1"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Tabel Desktop -->
        <div class="overflow-x-auto hidden md:block">
            <table class="min-w-275 w-full text-sm text-gray-700 rounded-2xl shadow-lg border-separate border-spacing-0">
                <thead>
                    <tr class="bg-linear-to-r from-[#F53003] to-[#0074D9] text-white sticky top-0 z-10">
                        <th class="py-4 px-6 rounded-tl-2xl text-left">No</th>
                        <th class="py-4 px-6 text-left">Foto</th>
                        <th class="py-4 px-6 text-left">Nama</th>
                        <th class="py-4 px-6 text-left whitespace-nowrap">Kode Karyawan</th>
                        <th class="py-4 px-6 text-left">Email</th>
                        <th class="py-4 px-6 text-left">Status</th>
                        <th class="py-4 px-6 rounded-tr-2xl text-center">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(karyawan, i) in paginatedKaryawans" :key="karyawan.id">
                        <tr class="hover:bg-blue-50 transition border-b border-blue-100">
                            <td class="py-3 px-6 font-bold" x-text="(currentPage-1)*perPage + i + 1"></td>
                            <td class="py-3 px-6">
                                <template x-if="karyawan.foto">
                                    <img :src="'/' + karyawan.foto" alt="Foto" class="w-10 h-10 rounded-full object-cover border border-gray-300">
                                </template>
                                <template x-if="!karyawan.foto">
                                    <span class="inline-block w-10 h-10 rounded-full bg-gray-200 items-center justify-center text-gray-400">-</span>
                                </template>
                            </td>
                            <td class="py-3 px-6" x-text="karyawan.user?.name ?? '-'"></td>
                            <td class="py-3 px-6 pl-16">
                                <template x-if="karyawan.status_karyawan === 'Aktif'">
                                    <span x-text="'ARG-' + karyawan.kode_karyawan"></span>
                                </template>
                                <template x-if="karyawan.status_karyawan !== 'Aktif'">
                                    -
                                </template>
                            </td>
                            <td class="py-3 px-6" x-text="karyawan.user?.email ?? '-'"></td>
                            <td class="py-3 px-6">
                                <template x-if="karyawan.status_karyawan === 'Aktif'">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold shadow-sm">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                                        Aktif
                                    </span>
                                </template>
                                <template x-if="karyawan.status_karyawan !== 'Aktif'">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold shadow-sm">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                        Nonaktif
                                    </span>
                                </template>
                            </td>
                            <td class="py-3 px-6 flex justify-center gap-2">
                                <button
                                    @click="selectedKaryawan = karyawan.id; showModal = true"
                                    class="rounded-lg transition p-1 "
                                    title="Detail"
                                    type="button"
                                >
                                    <img src="{{ asset('img/action/detail.webp') }}" alt="Detail" class="w-5 h-5 object-contain hover:scale-110 transition-transform cursor-pointer "/>
                                </button>
                            </td>
                        </tr>
                    </template>
                    <template x-if="paginatedKaryawans.length === 0">
                        <tr>
                            <td colspan="7" class="py-6 text-center text-gray-700">Tidak ada karyawan ditemukan.</td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>


        <!-- Pagination Desktop -->
        <div class="mt-4">
                <template x-if="totalPages > 1">
                    <div class="flex justify-between items-center">
                        <!-- Jumlah Data -->
                        <div class="text-sm text-gray-700">
                            Menampilkan <span x-text="(currentPage - 1) * perPage + 1"></span> - <span x-text="Math.min(currentPage * perPage, filteredUsers.length)"></span> dari <span x-text="filteredUsers.length"></span> data
                        </div>
                        <!-- Navigasi Halaman -->
                        <div class="flex gap-2">
                            <button
                                @click="goToPage(currentPage - 1)"
                                :disabled="currentPage === 1"
                                class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
                            >
                                Sebelumnya
                            </button>
                            <template x-for="page in totalPages" :key="page">
                                <button
                                    @click="goToPage(page)"
                                    x-text="page"
                                    :class="{
                                        'bg-blue-600 text-white font-semibold': currentPage === page,
                                        'bg-gray-200 text-gray-700 hover:bg-blue-100': currentPage !== page
                                    }"
                                    class="px-4 py-2 rounded-lg transition-all duration-300 cursor-pointer"
                                ></button>
                            </template>
                            <button
                                @click="goToPage(currentPage + 1)"
                                :disabled="currentPage === totalPages"
                                class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
                            >
                                Selanjutnya
                            </button>
                        </div>
                    </div>
                </template>
            </div>

        <!-- Pagination Mobile -->
        <div class="flex justify-center items-center mt-4 md:hidden" x-show="totalPages > 1">
            <button
                @click="goToPage(currentPage-1)"
                :disabled="currentPage === 1"
                class="px-2 py-1 rounded bg-gray-200 text-gray-700 font-semibold mr-1 disabled:opacity-50 text-xs"
            >&laquo;</button>
            <span class="mx-2 text-xs font-semibold" x-text="currentPage + ' / ' + totalPages"></span>
            <button
                @click="goToPage(currentPage+1)"
                :disabled="currentPage === totalPages"
                class="px-2 py-1 rounded bg-gray-200 text-gray-700 font-semibold ml-1 disabled:opacity-50 text-xs"
            >&raquo;</button>
        </div>
    </div>

    <!-- Modal Detail Profil Karyawan (sama untuk desktop & mobile) -->
    <div
        x-show="showModal"
        x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
        style="display: none;"
    >
        <div class="bg-linear-to-r from-[#F53003] to-[#0074D9] rounded-xl p-8 shadow-lg w-full max-w-md relative">
            <button @click="showModal = false" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl cursor-pointer">&times;</button>
            <template x-if="selectedKaryawan && detail[selectedKaryawan]">
                <div>
                    <div class="flex items-center gap-4 mb-4">
                        <template x-if="detail[selectedKaryawan].foto">
                            <img :src="'/' + detail[selectedKaryawan].foto" class="w-16 h-16 rounded-full object-cover border" alt="Foto">
                        </template>
                        <template x-if="!detail[selectedKaryawan].foto">
                            <span class="inline-block w-16 h-16 rounded-full bg-gray-200  items-center justify-center text-gray-400 text-2xl">-</span>
                        </template>
                        <div>
                            <div class="font-bold text-lg" x-text="detail[selectedKaryawan].user?.name ?? '-'"></div>
                            <div class="text-sm text-gray-900" x-text="detail[selectedKaryawan].user?.email ?? '-'"></div>
                        </div>
                    </div>
                    <div class="mb-2"><b>Role:</b> <span x-text="detail[selectedKaryawan].user?.role?.name ?? '-'"></span></div>
                    <div class="mb-2"><b>Kode Karyawan:</b> <span x-text="detail[selectedKaryawan].kode_karyawan"></span></div>
                    <div class="mb-2"><b>Nomor Telepon:</b> <span x-text="detail[selectedKaryawan].nomor_telepon"></span></div>
                    <div class="mb-2"><b>Status:</b> <span x-text="detail[selectedKaryawan].status_karyawan"></span></div>
                    <div class="mb-2"><b>Tanggal Masuk:</b> <span x-text="detail[selectedKaryawan].tanggal_masuk ? (new Date(detail[selectedKaryawan].tanggal_masuk)).toLocaleDateString('id-ID') : '-'"></span></div>
                    <div class="mb-2"><b>Alamat:</b> <span x-text="detail[selectedKaryawan].alamat"></span></div>
                </div>
            </template>
        </div>
    </div>
</div>
