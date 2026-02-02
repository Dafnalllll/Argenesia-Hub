<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\AktivitasAdmin;
use App\Models\PengajuanCuti;

class ManajemenUser extends Component
{
    public $search = '';
    public $filterRole = '';
    public $filterStatus = '';
    public $deleteId = null;
    public $showDeleteModal = false;

    public function resetFilters()
    {
        $this->search = '';
        $this->filterRole = '';
        $this->filterStatus = '';
    }

    public function getUsersProperty()
    {
        return User::query()
            ->with(['role', 'karyawan'])
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

    public function changeStatus($id, $status, $type = 'user')
    {
        if (!in_array($status, ['Aktif', 'Nonaktif'])) {
            session()->flash('error', 'Status tidak valid.');
            return;
        }

        if ($type === 'user') {
            $user = User::with('karyawan')->find($id);
            if (!$user) {
                session()->flash('error', 'User tidak ditemukan.');
                return;
            }

            if (in_array($user->role->name ?? '', ['Admin', 'HR'])) {
                session()->flash('error', 'Status User Ini Tidak Bisa Diubah.');
                return;
            }

            $user->status = $status;
            $user->save();

            // Update karyawan jika ada
            if ($user->karyawan) {
                if ($status === 'Aktif') {
                    $user->karyawan->status_karyawan = 'Aktif';
                    if (!$user->karyawan->tanggal_masuk || $user->karyawan->status_karyawan === 'Nonaktif') {
                        $user->karyawan->tanggal_masuk = now();
                    }
                    if (!$user->karyawan->kode_karyawan || $user->karyawan->kode_karyawan === $user->id) {
                        $user->karyawan->kode_karyawan = str_pad($user->id, 4, '0', STR_PAD_LEFT);
                    }
                } else {
                    $user->karyawan->status_karyawan = 'Nonaktif';
                }
                $user->karyawan->save();
            }

            // Catat aktivitas admin
            AktivitasAdmin::create([
                'tanggal' => now(),
                'aktivitas' => 'Ubah Status User',
                'keterangan' => 'Admin mengubah status user ID ' . $id . ' menjadi ' . $status,
            ]);

            session()->flash('success', 'Status User Berhasil Diubah.');
            return ['status' => $user->status];
        } else if ($type === 'karyawan') {
            $karyawan = \App\Models\Karyawan::find($id);

            if ($karyawan) {
                if ($status === 'Aktif' && !$karyawan->kode_karyawan) {
                    $karyawan->kode_karyawan = 'ARG-' . str_pad($karyawan->id, 4, '0', STR_PAD_LEFT);
                    $karyawan->tanggal_masuk = now();
                }
                $karyawan->status_karyawan = $status;
                $karyawan->save();
            }
        } else if ($type === 'cuti') {
            $cuti = PengajuanCuti::findOrFail($id);

            if ($cuti) {
                $cuti->status = $status;
                $cuti->save();
                session()->flash('success', 'Status cuti berhasil diubah menjadi ' . $status);
                return ['status' => $cuti->status];
            }
        }
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }


    public function deleteUserById($id)
    {
        User::find($id)?->delete();

        // Catat aktivitas admin
        AktivitasAdmin::create([
            'tanggal' => now(),
            'aktivitas' => 'Hapus User',
            'keterangan' => 'Admin menghapus user ID ' . $id,
        ]);

        session()->flash('success', 'User Berhasil Dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.manajemen-user.manajemen-user', [
            'users' => $this->users,
        ]);
    }
}
