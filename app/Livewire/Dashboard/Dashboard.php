<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render()
    {
        $totalPengajuan = PengajuanCuti::where('user_id', Auth::id())->count();

        // Ambil 5 pengajuan cuti terbaru user
        $pengajuanTerbaru = PengajuanCuti::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->with('tipeCuti') // pastikan relasi tipeCuti ada di model
            ->limit(5)
            ->get();

        return view('livewire.karyawan.dashboard.dashboard', [
            'totalPengajuan' => $totalPengajuan,
            'pengajuanTerbaru' => $pengajuanTerbaru,
        ]);
    }
}
