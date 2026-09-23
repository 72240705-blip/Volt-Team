<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan peran (role)
            $user = Auth::user();
            if ($user->peran === 'Pengemudi') {
                return redirect()->intended('/pengemudi/home');
            } elseif ($user->peran === 'Operator') {
                return redirect()->intended('/operator/dashboard');
            } else {
                return redirect()->intended('/admin/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        // 2. Simpan Data ke Database rpl2026
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'nomor_telepon' => $request->no_telepon,
            'password' => Hash::make($request->password), // Enkripsi kata sandi
            'peran' => 'Pengemudi', // Default peran sebagai Pengemudi
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}