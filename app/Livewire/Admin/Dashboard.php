<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class Dashboard extends Component
{
    public $totalUser;

    public function mount()
    {
        $this->totalUser = User::count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.dashboard');
    }
}
