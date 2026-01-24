@extends('components.layouts.app')

@section('title', 'Riwayat Cuti || Argenesia Hub')

@section('content')
<div class="w-full max-w-6xl mx-auto bg-white/70 backdrop-blur-2xl rounded-3xl shadow-2xl p-8 mt-12 border border-white/40 overflow-x-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div class="flex gap-3">
            <!-- Filter Status -->
            <select wire:model="filterStatus" class="px-4 py-2 rounded-lg border border-[#0074D9]/30 bg-white/90 text-[#0074D9] font-semibold focus:border-[#F53003] transition">
                <option value="">Semua Status</option>
                <option value="disetujui">Disetujui</option>
                <option value="menunggu">Menunggu</option>
                <option value="ditolak">Ditolak</option>
            </select>
            <!-- Filter Kategori -->
            <select wire:model="filterKategori" class="px-4 py-2 rounded-lg border border-[#0074D9]/30 bg-white/90 text-[#F53003] font-semibold focus:border-[#0074D9] transition">
                <option value="">Semua Kategori</option>
                <option value="tahunan">Tahunan</option>
                <option value="sakit">Sakit</option>
                <option value="izin">Izin</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>
        <button wire:click="exportExcel"
            class="flex items-center gap-2 px-6 py-2 bg-gradient-to-r from-[#0074D9] to-[#F53003] text-white rounded-lg shadow-lg hover:scale-105 hover:shadow-2xl transition-all font-bold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 9l5 5 5-5"/>
            </svg>
            Export Excel
        </button>
    </div>
    <div class="overflow-x-auto rounded-2xl shadow">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gradient-to-r from-[#0074D9]/80 to-[#F53003]/80 text-white uppercase">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Tanggal Pengajuan</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Tanggal Mulai</th>
                    <th class="px-4 py-3">Tanggal Selesai</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatCuti as $i => $cuti)
                <tr class="odd:bg-white even:bg-[#f8fafc] hover:bg-[#e0f7fa]/60 transition">
                    <td class="px-4 py-3">{{ $i + 1 }}</td>
                    <td class="px-4 py-3">{{ $cuti->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3 capitalize">{{ $cuti->kategori }}</td>
                    <td class="px-4 py-3">{{ $cuti->tanggal_mulai }}</td>
                    <td class="px-4 py-3">{{ $cuti->tanggal_selesai }}</td>
                    <td class="px-4 py-3">
                        @if($cuti->status == 'disetujui')
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold">Disetujui</span>
                        @elseif($cuti->status == 'ditolak')
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 font-bold">Ditolak</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-bold">Menunggu</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ $cuti->keterangan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-400">Tidak ada data cuti.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
