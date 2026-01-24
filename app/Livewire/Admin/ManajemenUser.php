<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class ManajemenUser extends Component
{
    public $search = '';
    public $filterRole = '';
    public $filterStatus = '';

    public function resetFilter()
    {
        $this->search = '';
        $this->filterRole = '';
        $this->filterStatus = '';
    }

    public function getUsersProperty()
    {
        return User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->when($this->filterRole, function ($query) {
                $query->whereHas('role', function ($q) {
                    $q->where('name', $this->filterRole);
                });
            })
            ->when($this->filterStatus, function ($query) {
                if ($this->filterStatus === 'aktif') {
                    $query->where('status', 'Aktif');
                } elseif ($this->filterStatus === 'nonaktif') {
                    $query->where('status', 'Nonaktif');
                }
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.manajemen-user.manajemen-user', [
            'users' => $this->users,
        ]);
    }
}
