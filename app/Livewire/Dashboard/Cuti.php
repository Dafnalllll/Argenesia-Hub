<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Auth;

class Cuti extends Component
{
    public function render()
    {
        $userId = Auth::id();

        // Sisa cuti (contoh: total tahunan - yang sudah diambil)
        $sisaCuti = 5; // Ganti dengan logika sesuai aturan cuti di perusahaan

        // Total pengajuan cuti user
        $totalPengajuan = PengajuanCuti::where('user_id', $userId)->count();

        // Cuti diproses (status Menunggu)
        $cutiDiproses = PengajuanCuti::where('user_id', $userId)
            ->where('status', 'Menunggu')
            ->count();

        // Pengajuan cuti terakhir
        $pengajuanTerakhir = PengajuanCuti::where('user_id', $userId)
            ->latest('created_at')
            ->first();

        // Riwayat pengajuan cuti terbaru (limit 5)
        $riwayatPengajuan = PengajuanCuti::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->with('tipeCuti')
            ->limit(5)
            ->get();

        return view('livewire.karyawan.dashboard.cuti.cuti', [
            'sisaCuti' => $sisaCuti,
            'totalPengajuan' => $totalPengajuan,
            'cutiDiproses' => $cutiDiproses,
            'pengajuanTerakhir' => $pengajuanTerakhir,
            'riwayatPengajuan' => $riwayatPengajuan,
        ]);
    }
}
