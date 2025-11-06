<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AuthLoginLivewire extends Component
{
    public $email;
    public $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Periksa apakah pengguna berhasil login
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            // Jika login gagal
            $this->dispatch('showError', message: 'Email atau kata sandi salah.');
            return;
        }

        // Reset data
        $this->reset(['email', 'password']);

        // Redirect ke halaman home
        return redirect()->route('app.home');
    }

    public function render()
    {
        return view('livewire.auth-login-livewire');
    }
}
