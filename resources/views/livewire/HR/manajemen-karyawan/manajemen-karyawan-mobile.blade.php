<div class="md:hidden p-4 mt-14 ">
    <!-- Title & Icon Mobile (opsional) -->
    <div class="flex items-center gap-3 mb-6 justify-center">
        <img
            src="{{ asset('img/sidebar/karyawan.webp') }}"
            alt="Admin"
            class="w-8 h-8"
        />
        <span class="text-lg font-bold text-gray-800 tracking-wide text-center">
            Manajemen Karyawan
        </span>
    </div>

    <!-- Search + Tabel Mobile dalam satu div -->
    <div class="bg-white/30 rounded-xl shadow p-2">
        <!-- Search Mobile -->
        <div class="flex flex-col mb-4 gap-4">
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

        <!-- Tabel Mobile -->
        <div class="overflow-x-auto w-75">
            <table class="min-w-125 w-full text-xs text-gray-700 rounded-2xl shadow-lg border-separate border-spacing-0">
                <thead>
                    <tr class="bg-linear-to-r from-[#F53003] to-[#0074D9] text-white sticky top-0 z-10">
                        <th class="py-3 px-3 rounded-tl-2xl text-left">No</th>
                        <th class="py-3 px-3 text-left">Foto</th>
                        <th class="py-3 px-3 text-left">Nama</th>
                        <th class="py-3 px-3 text-left whitespace-nowrap">Kode Karyawan</th>
                        <th class="py-3 px-3 text-left">Email</th>
                        <th class="py-3 px-3 text-left">Status</th>
                        <th class="py-3 px-3 rounded-tr-2xl text-center">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(karyawan, i) in paginatedKaryawans" :key="karyawan.id">
                        <tr class="hover:bg-blue-50 transition border-b border-blue-100">
                            <td class="py-2 px-3 font-bold" x-text="(currentPage-1)*perPage + i + 1"></td>
                            <td class="py-2 px-3">
                                <template x-if="karyawan.foto">
                                    <img :src="'/' + karyawan.foto" alt="Foto" class="w-8 h-8 rounded-full object-cover border border-gray-300">
                                </template>
                                <template x-if="!karyawan.foto">
                                    <span class="inline-block w-8 h-8 rounded-full bg-gray-200 items-center justify-center text-gray-400">-</span>
                                </template>
                            </td>
                            <td class="py-2 px-3" x-text="karyawan.user?.name ?? '-'"></td>
                            <td class="py-2 px-3">
                                <template x-if="karyawan.status_karyawan === 'Aktif'">
                                    <span x-text="'ARG-' + karyawan.kode_karyawan"></span>
                                </template>
                                <template x-if="karyawan.status_karyawan !== 'Aktif'">
                                    -
                                </template>
                            </td>
                            <td class="py-2 px-3" x-text="karyawan.user?.email ?? '-'"></td>
                            <td class="py-2 px-3">
                                <template x-if="karyawan.status_karyawan === 'Aktif'">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold shadow-sm">
                                        <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                                        Aktif
                                    </span>
                                </template>
                                <template x-if="karyawan.status_karyawan !== 'Aktif'">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold shadow-sm">
                                        <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                        Nonaktif
                                    </span>
                                </template>
                            </td>
                            <td class="py-2 px-3 flex justify-center gap-2">
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
                            <td colspan="7" class="py-4 text-center text-gray-700">Tidak ada karyawan ditemukan.</td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Mobile -->
    <div class="flex justify-center items-center mt-4" x-show="totalPages > 1">
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
