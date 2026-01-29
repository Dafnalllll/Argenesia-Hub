<?php

namespace App\Livewire\HR\Dashboard;

use Livewire\Component;
use App\Models\User;
use App\Models\PengajuanCuti;

class Dashboard extends Component
{
    public function render()
    {
        // Total karyawan (misal role_id 2 untuk karyawan, sesuaikan dengan strukturmu)
        $totalKaryawan = User::whereHas('role', function ($q) {
            $q->where('name', 'karyawan');
        })->count();

        // Statistik pengajuan cuti
        $totalPengajuan = PengajuanCuti::count();
        $totalDiterima = PengajuanCuti::where('status', 'Disetujui')->count();
        $totalDitolak = PengajuanCuti::where('status', 'Ditolak')->count();

        // Jumlah karyawan yang ambil cuti di bulan ini
        $karyawanCutiBulanIni = PengajuanCuti::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->distinct('karyawan_id')
            ->count('karyawan_id');

        // 5 pengajuan cuti terbaru
        $pengajuanTerbaru = PengajuanCuti::with(['karyawan.user', 'tipeCuti'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.hr.dashboard.dashboard', [
            'totalKaryawan' => $totalKaryawan,
            'totalPengajuan' => $totalPengajuan,
            'totalDiterima' => $totalDiterima,
            'totalDitolak' => $totalDitolak,
            'karyawanCutiBulanIni' => $karyawanCutiBulanIni,
            'pengajuanTerbaru' => $pengajuanTerbaru,
        ]);
    }
}
