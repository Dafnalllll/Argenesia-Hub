<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class Register extends Component
{

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $showPassword = false;
    public $showPasswordConfirm = false;


    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        usleep(1200000); // Delay 1.2 detik

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role_id' => 3, // Assign 'Employee' role by default
            'status' => 'Nonaktif',
        ]);

        Auth::login($user);

        return redirect()->intended('/login');
    }
    public function render()
    {
        return view('livewire.auth.register');
    }
}
