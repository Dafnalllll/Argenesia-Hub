<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\Aktivitas;
use App\Models\AktivitasAdmin;
use App\Models\AktivitasHR;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $showPassword = false;


    public function login()
    {
        // Validasi & proses login
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tambahkan delay agar loading spinner terlihat lebih lama
        usleep(1200000); // 1.2 detik (1.2 * 1.000.000 microseconds)

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $user = Auth::user();

            // Tambahkan ini:
            Aktivitas::create([
                'user_id' => $user->id,
                'tanggal' => now(),
                'aktivitas' => 'Login',
                'keterangan' => 'User login',
            ]);

            // Redirect sesuai role
            $role = strtolower($user->role->name);
            if ($role === 'admin') {
                // Catat aktivitas admin
                AktivitasAdmin::create([
                    'tanggal' => now(),
                    'aktivitas' => 'Login',
                    'keterangan' => 'Admin login',
                ]);
                return redirect()->route('dashboard.admin');
            } elseif ($role === 'hr') {
                // Catat aktivitas HR
                AktivitasHR::create([
                    'tanggal' => now(),
                    'aktivitas' => 'Login',
                    'keterangan' => 'HR login',
                ]);
                return redirect()->route('dashboard.hr'); // Pastikan route ini ada
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            $this->addError('email', 'Email atau password salah.');
        }
    }


    public function render()
    {
        return view('livewire.auth.login');
    }
}
