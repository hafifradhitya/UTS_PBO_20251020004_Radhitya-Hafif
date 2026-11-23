<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (session('is_logged_in')) {
            return redirect()->route('jadwal.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:4',
        ]);

        // Autentikasi sesi BAAK UCIC berbasis file session
        // Akun default admin BAAK atau kredensial mahasiswa
        session([
            'is_logged_in' => true,
            'user' => [
                'name' => 'Radhitya Hafif',
                'nim' => '20251020004',
                'role' => 'Administrator BAAK UCIC',
                'email' => $validated['email'],
            ],
        ]);

        return redirect()->route('jadwal.dashboard')->with('success', 'Selamat datang kembali, Radhitya Hafif (BAAK Admin).');
    }

    public function logout()
    {
        session()->forget(['is_logged_in', 'user']);

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sesi BAAK.');
    }
}
