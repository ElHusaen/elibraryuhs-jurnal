<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. VALIDASI DENGAN KONFIRMASI PASSWORD
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // CEK EMAIL UNIK!
            'password' => 'required|min:6|confirmed', // 'confirmed' otomatis cek password_confirmation
            'prodi' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
        ]);

        // 2. GENERATE KODE PENULIS YANG AMAN
        $lastMahasiswa = Mahasiswa::latest('created_at')->first();
        if ($lastMahasiswa) {
            // Ambil angka terakhir dari format Pxxx
            $lastNumber = (int) substr($lastMahasiswa->penulis, 1);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $kodePenulis = 'P' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // 3. GUNAKAN DATABASE TRANSACTION AGAR ATOMIS
        \DB::beginTransaction();
        
        try {
            // Simpan ke tabel users
            $user = User::create([
                'nama' => $request->nama,
                'role' => 'mahasiswa',
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $kodePenulis = 'P' . str_pad(
                Mahasiswa::count() + 1,
                3,
                '0',
                STR_PAD_LEFT
            );

            // Simpan ke tabel mahasiswa
            Mahasiswa::create([
                'penulis'      => $kodePenulis,
                'nama_lengkap' => $request->nama,
                'email'        => $request->email,
                'password'     => Hash::make($request->password),
                'prodi'        => $request->prodi,
                'fakultas'     => $request->fakultas,
            ]);
            \DB::commit();

            return redirect('/login')->with('success', 'Registrasi berhasil. Silakan login.');
            
        } catch (\Exception $e) {
            \DB::rollback();
            
            //dd($e->getMessage());

            // Kirim error ke back dengan pesan jelas
            throw ValidationException::withMessages([
                'email' => 'Registrasi gagal: ' . $e->getMessage(),
            ]);
        }
    }
}