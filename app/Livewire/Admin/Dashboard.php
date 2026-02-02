<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\TipeCuti;
use App\Models\PengajuanCuti;
use App\Models\AktivitasAdmin;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $totalUser;
    public $totalKaryawan;
    public $totalTipeCuti;
    public $totalPengajuanCuti;
    public $pengajuanCutiTerbaru;
    public $showDeleteModal = false;
    public $deleteId = null;

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
        $tipeCutis = TipeCuti::all();

        return view('livewire.admin.dashboard.dashboard', [
            'totalUser' => $this->totalUser,
            'totalKaryawan' => $this->totalKaryawan,
            'totalTipeCuti' => $this->totalTipeCuti,
            'totalPengajuanCuti' => $this->totalPengajuanCuti,
            'pengajuanCutiTerbaru' => $this->pengajuanCutiTerbaru,
            'tipeCutis' => $tipeCutis,
        ]);
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function deletePengajuan()
    {
        if ($this->deleteId) {
            $tipeCuti = TipeCuti::find($this->deleteId);
            if ($tipeCuti) {
                $nama = $tipeCuti->nama_cuti;
                $tipeCuti->delete();

                // Catat aktivitas hapus
                AktivitasAdmin::create([
                    'user_id' => Auth::id(),
                    'tanggal' => now(),
                    'aktivitas' => 'Hapus Tipe Cuti',
                    'keterangan' => 'Menghapus tipe cuti: ' . $nama,
                ]);

                session()->flash('success', 'Tipe cuti berhasil dihapus!');
            }
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;

        // Refresh data
        $this->mount();
    }
}
