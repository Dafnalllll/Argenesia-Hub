<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Aktivitas;

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
                'tanggal' => now()->toDateString(),
                'aktivitas' => 'Login',
                'keterangan' => 'User login pada ' . now()->format('H:i:s'),
            ]);

            // Redirect sesuai role
            $role = strtolower($user->role->name);
            if ($role === 'admin') {
                return redirect()->route('dashboard.admin');
            } elseif ($role === 'hr') {
                return redirect()->route('dashboard.hr'); // Pastikan route ini ada
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            $this->addError('email', 'Email atau password salah.');
        }
    }

    public function logout()
    {
        Aktivitas::create([
            'tanggal' => now()->toDateString(),
            'aktivitas' => 'Logout',
            'keterangan' => 'User logout pada ' . now()->format('H:i:s'),
        ]);

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->dispatchBrowserEvent('redirectToLogin');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
