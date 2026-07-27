<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    // Mengarahkan pengguna ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Menangani kembalian dari Google setelah sukses login
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cari apakah user dengan google_id ini sudah ada
            $user = User::where('google_id', $googleUser->id)->first();
            
            if (!$user) {
                // Jika tidak ada, cek apakah emailnya sudah terdaftar secara manual sebelumnya
                $user = User::where('email', $googleUser->email)->first();
                
                if ($user) {
                    // Update akun manual tersebut dengan google_id
                    $user->update(['google_id' => $googleUser->id]);
                } else {
                    // Buat akun baru secara otomatis
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'password' => Hash::make(Str::random(24)), // Generate password acak
                    ]);
                }
            }

            Auth::login($user);

            // ==========================================
            // LOGIKA BARU: CEK NOMOR WA SETELAH LOGIN GOOGLE
            // ==========================================
            // Jika kolom whatsapp kosong, paksa user melengkapi profil dulu
            if (empty($user->whatsapp)) {
                return redirect()->route('profil.lengkapi');
            }

            return redirect()->intended('/dashboard')->with('success', 'Berhasil masuk menggunakan Google!');
            
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Autentikasi Google dibatalkan atau gagal.');
        }
    }
}