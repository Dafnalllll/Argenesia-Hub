<div class="p-8 mt-14"
    x-data="{
        search: '',
        currentPage: 1,
        perPage: 8,
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
    <h1 class="text-xl font-bold mb-4 text-white tracking-wide flex items-center justify-center gap-3">
        <img src="{{ asset('img/sidebar/karyawan.webp') }}" alt="Karyawan" class="w-8 h-8" />
        Manajemen Karyawan
    </h1>
    <div class="bg-white/70 backdrop-blur-md border border-white/30 rounded-xl shadow-lg p-4">
        <!-- Search -->
        <div class="flex flex-col gap-3 mb-4">
            <div class="relative w-full group">
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
                <!-- Ikon silang/reset -->
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
        <!-- Table Mobile -->
        <div class="overflow-x-auto w-75">
            <table class="min-w-175 w-full text-xs text-gray-700 rounded-2xl shadow-lg border-separate border-spacing-0">
                <thead>
                    <tr class="bg-linear-to-r from-[#F53003] to-[#0074D9] text-white sticky top-0 z-10">
                        <th class="py-3 px-2 rounded-tl-2xl text-left">No</th>
                        <th class="py-3 px-2 text-left">Foto</th>
                        <th class="py-3 px-2 text-left">Nama</th>
                        <th class="py-3 px-2 text-left">Kode</th>
                        <th class="py-3 px-2 text-left">Email</th>
                        <th class="py-3 px-2 text-left">Status</th>
                        <th class="py-3 px-2 rounded-tr-2xl text-center">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(karyawan, i) in paginatedKaryawans" :key="karyawan.id">
                        <tr class="hover:bg-blue-50 transition border-b border-blue-100">
                            <td class="py-2 px-2 font-bold" x-text="(currentPage-1)*perPage + i + 1"></td>
                            <td class="py-2 px-2">
                                <template x-if="karyawan.foto">
                                    <img :src="'/' + karyawan.foto" alt="Foto" class="w-8 h-8 rounded-full object-cover border border-gray-300">
                                </template>
                                <template x-if="!karyawan.foto">
                                    <span class="inline-block w-8 h-8 rounded-full bg-gray-200 items-center justify-center text-gray-400">-</span>
                                </template>
                            </td>
                            <td class="py-2 px-2" x-text="karyawan.user?.name ?? '-'"></td>
                            <td class="py-2 px-2">
                                <template x-if="karyawan.status_karyawan === 'Aktif'">
                                    <span x-text="'ARG-' + karyawan.kode_karyawan"></span>
                                </template>
                                <template x-if="karyawan.status_karyawan !== 'Aktif'">
                                    -
                                </template>
                            </td>
                            <td class="py-2 px-2" x-text="karyawan.user?.email ?? '-'"></td>
                            <td class="py-2 px-2">
                                <template x-if="karyawan.status_karyawan === 'Aktif'">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-semibold shadow-sm">
                                        <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                                        Aktif
                                    </span>
                                </template>
                                <template x-if="karyawan.status_karyawan !== 'Aktif'">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 text-red-700 text-xs font-semibold shadow-sm">
                                        <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                        Nonaktif
                                    </span>
                                </template>
                            </td>
                            <td class="py-2 px-2 flex justify-center gap-2">
                                <button
                                    @click="selectedKaryawan = karyawan.id; showModal = true"
                                    class="rounded-lg transition p-1"
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

        <!-- Export Dropdown di Bawah Tabel -->
        <div class="flex justify-end mt-4">
            <div x-data="{ open: false }" class="relative">
                <button
                    @click="if (filteredKaryawans.length > 0) { open = !open }"
                    @click.away="open = false"
                    :class="[
                        'px-4 py-2 rounded-lg bg-linear-to-r from-[#F53003] to-[#0074D9] text-white font-semibold shadow transition-all flex items-center gap-2 select-none',
                        filteredKaryawans.length === 0
                            ? 'cursor-not-allowed opacity-60'
                            : 'cursor-pointer',
                        'hover:scale-105'
                    ]"
                    type="button"
                >
                    <img src="{{ asset('img/export/export.webp') }}" alt="Export" class="w-5 h-5">
                    <span class="font-bold">Export</span>
                    <svg
                        :class="open ? 'rotate-180 transition-transform duration-300' : 'transition-transform duration-300'"
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div
                    x-show="open && filteredKaryawans.length > 0"
                    x-transition
                    class="absolute right-0 mt-2 w-36 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                >
                    <ul>
                        <li>
                            <button
                                wire:click="exportExcel"
                                @click="open = false"
                                class="w-full flex items-center gap-2 text-left px-4 py-2 hover:bg-green-50 text-green-700 font-semibold rounded-t-lg transition cursor-pointer"
                            >
                                <img src="{{ asset('img/export/excel.webp') }}" alt="Excel" class="w-5 h-5"> Excel
                            </button>
                        </li>
                        <li>
                            <button
                                wire:click="exportPdf"
                                @click="open = false"
                                class="w-full flex items-center gap-2 text-left px-4 py-2 hover:bg-red-50 text-red-700 font-semibold rounded-b-lg transition cursor-pointer"
                            >
                                <img src="{{ asset('img/export/pdf.webp') }}" alt="PDF" class="w-5 h-5"> PDF
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center items-center gap-2 mt-4" x-show="totalPages > 1">
            <button
                @click="goToPage(currentPage-1)"
                :disabled="currentPage === 1"
                class="px-3 py-1 rounded bg-gray-200 text-gray-700 font-semibold disabled:opacity-50"
            >&laquo;</button>
            <template x-for="page in totalPages" :key="page">
                <button
                    @click="goToPage(page)"
                    :class="page === currentPage ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                    class="mx-1 px-3 py-1 rounded font-semibold"
                    x-text="page"
                ></button>
            </template>
            <button
                @click="goToPage(currentPage+1)"
                :disabled="currentPage === totalPages"
                class="px-3 py-1 rounded bg-gray-200 text-gray-700 font-semibold disabled:opacity-50"
            >&raquo;</button>
        </div>
    </div>

    <!-- Modal Detail Profil Karyawan -->
    <div
        x-show="showModal"
        x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
        style="display: none;"
    >
        <div class="bg-linear-to-r from-[#F53003] to-[#0074D9] rounded-xl p-6 shadow-lg w-full max-w-xs relative">
            <button @click="showModal = false" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl cursor-pointer">&times;</button>
            <template x-if="selectedKaryawan && detail[selectedKaryawan]">
                <div>
                    <div class="flex items-center gap-4 mb-4">
                        <template x-if="detail[selectedKaryawan].foto">
                            <img :src="'/' + detail[selectedKaryawan].foto" class="w-14 h-14 rounded-full object-cover border" alt="Foto">
                        </template>
                        <template x-if="!detail[selectedKaryawan].foto">
                            <span class="inline-block w-14 h-14 rounded-full bg-gray-200 items-center justify-center text-gray-400 text-2xl">-</span>
                        </template>
                        <div>
                            <div class="font-bold text-base" x-text="detail[selectedKaryawan].user?.name ?? '-'"></div>
                            <div class="text-xs text-gray-900" x-text="detail[selectedKaryawan].user?.email ?? '-'"></div>
                        </div>
                    </div>
                    <div class="mb-2 text-xs"><b>Role:</b> <span x-text="detail[selectedKaryawan].user?.role?.name ?? '-'"></span></div>
                    <div class="mb-2 text-xs"><b>Kode Karyawan:</b> <span x-text="detail[selectedKaryawan].kode_karyawan"></span></div>
                    <div class="mb-2 text-xs"><b>Nomor Telepon:</b> <span x-text="detail[selectedKaryawan].nomor_telepon"></span></div>
                    <div class="mb-2 text-xs"><b>Status:</b> <span x-text="detail[selectedKaryawan].status_karyawan"></span></div>
                    <div class="mb-2 text-xs"><b>Tanggal Masuk:</b> <span x-text="detail[selectedKaryawan].tanggal_masuk ? (new Date(detail[selectedKaryawan].tanggal_masuk)).toLocaleDateString('id-ID') : '-'"></span></div>
                    <div class="mb-2 text-xs"><b>Alamat:</b> <span x-text="detail[selectedKaryawan].alamat"></span></div>
                </div>
            </template>
        </div>
    </div>
</div>
