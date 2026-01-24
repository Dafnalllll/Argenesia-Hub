@section('title', 'Manajemen Karyawan || Argenesia Hub')

<div class="p-6">
    <h1 class="text-2xl font-bold mb-6 text-white tracking-wide">Manajemen Karyawan</h1>
    <div class="bg-white/40 backdrop-blur-md border border-white/30 rounded-2xl shadow-2xl p-6">
        <div class="overflow-x-auto">
            <table class="min-w-275 w-full text-sm text-gray-700 rounded-2xl shadow-lg border-separate border-spacing-0">
                <thead>
                    <tr class="bg-linear-to-r from-[#F53003] to-[#0074D9] text-white sticky top-0 z-10">
                        <th class="py-4 px-6 rounded-tl-2xl text-left">No</th>
                        <th class="py-4 px-6 text-left">Foto</th>
                        <th class="py-4 px-6 text-left">Nama</th>
                        <th class="py-4 px-6 text-left whitespace-nowrap">Kode Karyawan</th>
                        <th class="py-4 px-6 text-left">Email</th>
                        <th class="py-4 px-6 text-left whitespace-nowrap">Nomor Telepon</th>
                        <th class="py-4 px-6 text-left">Status</th>
                        <th class="py-4 px-6 text-left whitespace-nowrap">Tanggal Masuk</th>
                        <th class="py-4 px-6 text-left">Alamat</th>
                        <th class="py-4 px-6 rounded-tr-2xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawans as $i => $karyawan)
                        <tr class="hover:bg-blue-50 transition border-b border-blue-100">
                            <td class="py-3 px-6 font-bold">{{ $i+1 }}</td>
                            <td class="py-3 px-6">
                                @if($karyawan->foto)
                                    <img src="{{ asset('storage/'.$karyawan->foto) }}" alt="Foto" class="w-10 h-10 rounded-full object-cover border border-gray-300">
                                @else
                                    <span class="inline-block w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-6">{{ $karyawan->user->name ?? '-' }}</td>
                            <td class="py-3 px-6">{{ $karyawan->kode_karyawan }}</td>
                            <td class="py-3 px-6">{{ $karyawan->user->email ?? '-' }}</td>
                            <td class="py-3 px-6">{{ $karyawan->nomor_telepon }}</td>
                            <td class="py-3 px-6">
                                @if($karyawan->status_karyawan === 'Aktif')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold shadow-sm">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold shadow-sm">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-6">
                                {{ $karyawan->tanggal_masuk ? \Carbon\Carbon::parse($karyawan->tanggal_masuk)->format('d M Y') : '-' }}
                            </td>
                            <td class="py-3 px-6">{{ $karyawan->alamat }}</td>
                            <td class="py-3 px-6 flex justify-center gap-2">
                                <a href="#" title="Edit"
                                    class="rounded-lg transition p-1">
                                    <img src="{{ asset('img/action/edit.webp') }}" alt="Edit" class="w-5 h-5 object-contain hover:scale-105 transition-transform"/>
                                </a>
                                <a href="#" title="Hapus"
                                    class="rounded-lg transition p-1">
                                    <img src="{{ asset('img/action/delete.webp') }}" alt="Hapus" class="w-5 h-5 object-contain hover:scale-105 transition-transform"/>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="py-6 text-center text-gray-800">Tidak ada karyawan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
