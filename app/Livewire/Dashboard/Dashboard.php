<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        $totalPengajuan = PengajuanCuti::where('user_id', $user->id)->count();

        $pengajuanTerbaru = PengajuanCuti::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->with('tipeCuti')
            ->limit(5)
            ->get();

        $jumlahCutiDisetujui = PengajuanCuti::where('user_id', $user->id)
            ->where('status', 'Disetujui')
            ->count();

        // Saldo cuti hanya berlaku jika status_karyawan 'Aktif'
        $saldoCuti = ($karyawan && $karyawan->status_karyawan === 'Aktif') ? $karyawan->saldo_cuti : 0;

        // Sisa cuti juga hanya berlaku jika aktif
        $sisaCuti = ($karyawan && $karyawan->status_karyawan === 'Aktif')
            ? ($saldoCuti - $jumlahCutiDisetujui)
            : 0;

        return view('livewire.karyawan.dashboard.dashboard', [
            'totalPengajuan' => $totalPengajuan,
            'pengajuanTerbaru' => $pengajuanTerbaru,
            'jumlahCutiDisetujui' => $jumlahCutiDisetujui,
            'sisaCuti' => $sisaCuti,
        ]);
    }
}
