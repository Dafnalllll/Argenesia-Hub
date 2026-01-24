<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Karyawan;
use App\Models\Aktivitas; // Tambahkan di atas
use Illuminate\Support\Facades\Auth;

class Profil extends Component
{
    use WithFileUploads;

    public $editMode = false;
    public $alamat;
    public $nomor_telepon;
    public $foto;
    public $foto_baru;

    public $kode_karyawan;
    public $status_karyawan;
    public $tanggal_masuk;
    public $email;
    public $username;

    public function mount()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        // Jika belum ada data karyawan, buat otomatis dengan default
        if (!$karyawan) {
            $karyawan = Karyawan::create([
                'user_id' => $user->id,
                'kode_karyawan' => 'ARG-',
                'status_karyawan' => 'Nonaktif',
            ]);
        }

        $this->alamat = $karyawan->alamat ?? '';
        $this->nomor_telepon = $karyawan->nomor_telepon ?? '';
        $this->foto = $karyawan->foto ?? null;
        $this->kode_karyawan = $karyawan->kode_karyawan ?? 'ARG-';
        $this->status_karyawan = $karyawan->status_karyawan ?? 'Nonaktif';
        $this->tanggal_masuk = $karyawan->tanggal_masuk ?? null;
        $this->email = $user->email;
        $this->username = $user->name;
    }

    public function enableEdit()
    {
        $this->editMode = true;
    }

    public function cancelEdit()
    {
        $this->editMode = false;
        $this->mount();
    }

    public function updateProfil()
    {
        $this->validate([
            'foto_baru' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:5120',
        ]);

        $user = Auth::user();
        $karyawan = $user->karyawan;

        $karyawan->alamat = $this->alamat;
        $karyawan->nomor_telepon = $this->nomor_telepon;

        if ($this->foto_baru) {
            $path = $this->foto_baru->store('foto-profil', 'public');
            $karyawan->foto = 'storage/' . $path;
            $this->foto = $karyawan->foto;
        }

        $karyawan->save();

        // Tambahkan ini:
        Aktivitas::create([
            'tanggal' => now()->toDateString(),
            'aktivitas' => 'Update Profil',
            'keterangan' => 'User mengubah profil pada ' . now()->format('H:i:s'),
        ]);

        $this->editMode = false;
        session()->flash('message', 'Profil berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.karyawan.dashboard.profil', [
            'alamat' => $this->alamat,
            'nomor_telepon' => $this->nomor_telepon,
            'editMode' => $this->editMode,
            'foto' => $this->foto,
            'kode_karyawan' => $this->kode_karyawan,
            'status_karyawan' => $this->status_karyawan,
            'tanggal_masuk' => $this->tanggal_masuk,
            'email' => $this->email,
            'username' => $this->username,
        ]);
    }
}
