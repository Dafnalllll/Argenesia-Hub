<div wire:poll.5s class="bg-white/40 backdrop-blur-md rounded-2xl shadow-lg p-6 overflow-x-auto mb-8">
    <h3 class="text-lg font-bold mb-4 text-black text-center md:text-left">Riwayat Aktivitas Terbaru</h3>
    <table class="min-w-full text-sm border border-gray-300 rounded-lg overflow-hidden">
        <thead class="bg-[#F53003]">
            <tr class="text-left text-gray-700">
                <th class="py-2 px-3 border-b border-gray-300">Tanggal</th>
                <th class="py-2 px-3 border-b border-gray-300">Aktivitas</th>
                <th class="py-2 px-3 border-b border-gray-300">Keterangan</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($aktivitas as $item)
                <tr>
                    <td class="py-2 px-3">{{ $item->tanggal }}</td>
                    <td class="py-2 px-3">
                        @if(strtolower($item->aktivitas) == 'login')
                            <span class="px-2 py-1 rounded bg-blue-100 text-blue-700 font-semibold">Login</span>
                        @elseif(strtolower($item->aktivitas) == 'logout')
                            <span class="px-2 py-1 rounded bg-red-100 text-red-700 font-semibold">Logout</span>
                        @elseif(strtolower($item->aktivitas) == 'update profil')
                            <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700 font-semibold whitespace-nowrap">Update Profil</span>
                        @else
                            <span class="px-2 py-1 rounded bg-gray-100 text-gray-700 font-semibold whitespace-nowrap">{{ $item->aktivitas }}</span>
                        @endif
                    </td>
                    <td class="py-2 px-3">
                        {{ $item->keterangan }}
                        <span class="text-xs text-gray-700">({{ \Carbon\Carbon::parse($item->tanggal)->diffForHumans() }})</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="py-2 px-3 text-center text-gray-700">Belum ada aktivitas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
