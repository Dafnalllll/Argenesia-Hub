<div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-4 md:p-6 animate-fade-in-up">
    <h2 class="text-lg md:text-xl font-bold mb-4 text-gray-800 text-center md:text-left">Aktivitas HR</h2>
    <div class="overflow-x-auto">
        <table class="min-w-max w-full text-xs md:text-sm text-gray-700">
            <thead>
                <tr class="bg-[#F53003] text-white">
                    <th class="py-2 px-2 md:py-3 md:px-4 rounded-tl-2xl">Tanggal</th>
                    <th class="py-2 px-2 md:py-3 md:px-4">Aktivitas</th>
                    <th class="py-2 px-2 md:py-3 md:px-4 rounded-tr-2xl">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($aktivitasHR as $aktivitas)
                    <tr class="hover:bg-pink-100 transition text-center animate-fade-in-up">
                        <td class="py-1 px-2 md:py-2 md:px-3 whitespace-nowrap">{{ $aktivitas->tanggal }}</td>
                        <td class="py-1 px-2 md:py-2 md:px-4">
                            @if(strtolower($aktivitas->aktivitas) === 'login')
                                <span class="px-2 py-1 rounded bg-green-100 text-green-700 font-semibold">Login</span>
                            @elseif(strtolower($aktivitas->aktivitas) === 'logout')
                                <span class="px-2 py-1 rounded bg-red-100 text-red-700 font-semibold">Logout</span>
                            @else
                                <span class="px-2 py-1 rounded bg-gray-100 text-gray-700 font-semibold">{{ $aktivitas->aktivitas }}</span>
                            @endif
                        </td>
                        <td class="py-1 px-2 md:py-2 md:px-4">
                            {{ $aktivitas->keterangan }}
                            <span class="block md:inline text-xs text-gray-700">({{ \Carbon\Carbon::parse($aktivitas->tanggal)->diffForHumans() }})</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-2 px-2 md:px-4 text-center text-gray-700">Tidak ada aktivitas HR.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
