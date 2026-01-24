<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\AktivitasAdmin;

class AktivitasAdminTable extends Component
{
    public function render()
    {
        $aktivitasAdmin = AktivitasAdmin::orderBy('tanggal', 'desc')->get();

        return view('livewire.admin.aktivitas-admin-table', [
            'aktivitasAdmin' => $aktivitasAdmin,
        ]);
    }
}
