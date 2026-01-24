<div class="bg-white/30 backdrop-blur-md border border-white/30 rounded-2xl shadow-xl p-6 animate-fade-in-up">
    <h2 class="text-xl font-bold mb-4 text-gray-800">Aktivitas Admin</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700">
            <thead>
                <tr class="bg-[#F53003] text-white">
                    <th class="py-3 px-4 rounded-tl-2xl">Tanggal</th>
                    <th class="py-3 px-4">Aktivitas</th>
                    <th class="py-3 px-4 rounded-tr-2xl">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($aktivitasAdmin as $aktivitas)
                    <tr class="hover:bg-pink-100 transition animate-fade-in-up">
                        <td class="py-2 px-4">{{ $aktivitas->tanggal }}</td>
                        <td class="py-2 px-4">{{ $aktivitas->aktivitas }}</td>
                        <td class="py-2 px-4">{{ $aktivitas->keterangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-2 px-4 text-center text-gray-500">Tidak ada aktivitas admin.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
