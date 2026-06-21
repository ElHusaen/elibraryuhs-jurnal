<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Halaman Login
    public function login()
    {
        return view('auth.login');
    }

    // Halaman Register
    public function register()
    {
        return view('auth.register');
    }

    // Proses Register
    public function registerProses(Request $request)
    {
        // VALIDASI
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3|confirmed',
            'kode_akses' => 'nullable|string',
        ]);

        // Tentukan role
        $role = 'mahasiswa';
        $kodeAdmin = 'admin123'; // Ganti dengan kode rahasia Anda

        if ($request->filled('kode_akses') && $request->kode_akses === $kodeAdmin) {
            $role = 'admin';
        }

        // SIMPAN USER
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil, silakan login');
    }

    // Proses Login
    public function loginProses(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        return redirect()->back()
            ->with('error', 'Email atau Password salah');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout');
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard',
            'menuDashboard' => 'active',
            'user' => User::all()
        ];

        return view('admin.dashboard', $data);
    }
}