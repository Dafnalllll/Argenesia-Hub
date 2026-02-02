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

        // Jumlah cuti yang Disetujui
        $jumlahCutiDisetujui = PengajuanCuti::where('user_id', $userId)
            ->where('status', 'Disetujui')
            ->count();

        // Sisa cuti (misal saldo default 12 - jumlah cuti disetujui)
        $saldoCuti = 12; // Atau ambil dari field saldo_cuti jika sudah ada di tabel karyawans
        $sisaCuti = $saldoCuti - $jumlahCutiDisetujui;

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
            'jumlahCutiDisetujui' => $jumlahCutiDisetujui, // <-- Tambahkan ini
            'sisaCuti' => $sisaCuti,
            'totalPengajuan' => $totalPengajuan,
            'cutiDiproses' => $cutiDiproses,
            'pengajuanTerakhir' => $pengajuanTerakhir,
            'riwayatPengajuan' => $riwayatPengajuan,
        ]);
    }
}
