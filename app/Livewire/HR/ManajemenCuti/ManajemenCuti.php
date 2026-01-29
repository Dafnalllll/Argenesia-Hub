<?php

namespace App\Livewire\HR\ManajemenCuti;

use Livewire\Component;
use App\Models\PengajuanCuti;

class ManajemenCuti extends Component
{
    public $showDetailModal = false;
    public $selectedCuti = null;
    public $search = '';
    public $filterStatus = '';

    public function render()
    {
        // Query pengajuan cuti dengan filter
        $query = PengajuanCuti::with(['karyawan.user', 'tipeCuti']);

        if ($this->search) {
            $query->whereHas('karyawan.user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        return view('livewire.hr.manajemen-cuti.manajemen-cuti', [
            'totalPengajuan' => PengajuanCuti::count(),
            'totalDisetujui' => PengajuanCuti::where('status', 'Disetujui')->count(),
            'totalDitolak'   => PengajuanCuti::where('status', 'Ditolak')->count(),
            'totalMenunggu'  => PengajuanCuti::where('status', 'Menunggu')->count(),
            'pengajuanCuti'  => $query->latest()->take(4)->get(),
            'showDetailModal' => $this->showDetailModal,
            'selectedCuti' => $this->selectedCuti,
        ]);
    }

    public function showDetail($id)
    {
        $this->selectedCuti = PengajuanCuti::find($id);
        $this->showDetailModal = true;
    }

    public function resetFilter()
    {
        $this->reset(['search', 'filterStatus']);
    }
}
