<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    // ==========================================
    // 1. FITUR EDIT PROFIL (KODE AWAL ANDA)
    // ==========================================
    
    // Menampilkan halaman edit profil
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Memproses pembaruan data profil
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        // Aturan validasi dasar (Nama, Email, WA)
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'whatsapp' => 'required|string|max:20|unique:users,whatsapp,' . $user->id,
        ];

        // LOGIKA KEAMANAN BARU: 
        // Jika user mengisi form password baru ATAU password lama, paksa mereka mengisi ketiganya dengan benar
        if ($request->filled('password') || $request->filled('current_password')) {
            $rules['current_password'] = 'required|current_password'; // Memastikan sandi lama yang diketik BENAR
            $rules['password'] = 'required|string|min:8|confirmed';   // Sandi baru minimal 8 huruf & harus sama dengan konfirmasi
        }

        // Jalankan validasi dan buat pesan error berbahasa Indonesia
        $request->validate($rules, [
            'current_password.required' => 'Kata sandi saat ini wajib diisi jika Anda ingin mengubah kata sandi.',
            'current_password.current_password' => 'Kata sandi saat ini yang Anda masukkan salah.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        // Simpan data kontak
        $user->name = $request->name;
        $user->email = $request->email;
        $user->whatsapp = $request->whatsapp;

        // Jika lolos validasi password, simpan password baru (sudah dienkripsi)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect('/dashboard')->with('success', 'Data profil Anda berhasil diperbarui!');
    }


    // ==========================================
    // 2. FITUR LENGKAPI PROFIL GOOGLE (KODE BARU)
    // ==========================================

    // Menampilkan halaman form isi WA khusus user Google baru
    public function lengkapi()
    {
        // Jika user sebenarnya sudah punya WA, langsung lempar ke dashboard
        if (Auth::user()->whatsapp) {
            return redirect('/dashboard');
        }
        
        return view('auth.lengkapi_profil');
    }

    // Memproses dan menyimpan nomor WA ke database
    public function simpanWa(Request $request)
    {
        $request->validate([
            'whatsapp' => 'required|min:10|max:15'
        ], [
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.min' => 'Nomor WhatsApp terlalu pendek.',
        ]);

        $user = User::find(Auth::id());
        $user->whatsapp = $request->whatsapp;
        $user->save();

        return redirect('/dashboard')->with('success', 'Sip! Profil Anda sudah lengkap. Selamat datang di Joki Kilat! ⚡');
    }
}