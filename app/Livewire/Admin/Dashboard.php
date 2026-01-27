<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\TipeCuti;
use App\Models\PengajuanCuti;

class Dashboard extends Component
{
    public $totalUser;
    public $totalKaryawan;
    public $totalTipeCuti;
    public $totalPengajuanCuti;
    public $pengajuanCutiTerbaru;

    public function mount()
    {
        $this->totalUser = User::count();
        $this->totalKaryawan = Karyawan::where('status_karyawan', 'Aktif')->count();
        $this->totalTipeCuti = TipeCuti::count();
        $this->totalPengajuanCuti = PengajuanCuti::count();
        $this->pengajuanCutiTerbaru = PengajuanCuti::with(['karyawan.user', 'tipeCuti'])
            ->latest()
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.dashboard');
    }
}
