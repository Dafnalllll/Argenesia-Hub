<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\AktivitasAdmin;

class AktivitasAdminTable extends Component
{
    protected $listeners = ['aktivitasAdminUpdated' => '$refresh'];

    public function render()
    {
        $aktivitasAdmin = AktivitasAdmin::orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        return view('livewire.admin.aktivitas-admin-table', [
            'aktivitasAdmin' => $aktivitasAdmin,
        ]);
    }
}
