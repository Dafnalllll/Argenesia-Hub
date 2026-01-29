<?php
namespace App\Livewire\HR;

use Livewire\Component;
use App\Models\AktivitasHR;

class AktivitasHRTable extends Component
{
    protected $listeners = ['aktivitasHRUpdated' => '$refresh'];
    public function render()
    {
        $aktivitasHR = AktivitasHR::orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        return view('livewire.hr.aktivitas-hr-table', [
            'aktivitasHR' => $aktivitasHR,
        ]);
    }
}
