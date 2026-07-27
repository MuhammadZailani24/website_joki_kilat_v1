<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Joki Kilat</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-zinc-950 text-white font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden py-10">
    
    <!-- Efek Cahaya Belakang -->
    <div class="absolute top-[-20%] right-[-10%] w-[500px] h-[500px] bg-orange-500/20 rounded-full blur-[120px] pointer-events-none fixed"></div>
    <div class="absolute bottom-[-20%] left-[-10%] w-[400px] h-[400px] bg-yellow-500/10 rounded-full blur-[100px] pointer-events-none fixed"></div>

    <div class="w-full max-w-md px-6 relative z-10">
        <div class="bg-zinc-900/80 backdrop-blur-xl border border-zinc-800 rounded-3xl p-8 shadow-2xl">
            
            <div class="text-center mb-8">
                <h1 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500 mb-2">Buat Akun Baru 🚀</h1>
                <p class="text-sm text-gray-400">Bergabung dengan Joki Kilat sekarang.</p>
            </div>

            <!-- Pesan Error -->
            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded-xl text-sm mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-zinc-950 border border-zinc-700 text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-yellow-500 transition shadow-inner">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-zinc-950 border border-zinc-700 text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-yellow-500 transition shadow-inner">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" required placeholder="Contoh: 08123456789" class="w-full bg-zinc-950 border border-zinc-700 text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-yellow-500 transition shadow-inner">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Password</label>
                        <input type="password" name="password" required class="w-full bg-zinc-950 border border-zinc-700 text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-yellow-500 transition shadow-inner">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required class="w-full bg-zinc-950 border border-zinc-700 text-white rounded-xl px-4 py-2.5 focus:outline-none focus:border-yellow-500 transition shadow-inner">
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-400 hover:to-orange-400 text-zinc-950 font-black py-3.5 rounded-xl transition shadow-[0_0_20px_rgba(234,179,8,0.3)] hover:scale-[1.02]">
                    DAFTAR SEKARANG
                </button>
            </form>

            <!-- TOMBOL REGISTER GOOGLE -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-zinc-800"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-zinc-900 text-gray-500 font-bold text-xs uppercase tracking-widest">Atau daftar dengan</span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-3 bg-zinc-950 hover:bg-zinc-800 border border-zinc-700 text-white font-bold py-3.5 px-4 rounded-xl transition shadow-lg group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Lanjutkan dengan Google
                    </a>
                </div>
            </div>

            <p class="mt-8 text-center text-sm text-gray-400">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-yellow-500 font-bold hover:underline">Masuk di sini</a>
            </p>
        </div>
    </div>
</body>
</html>