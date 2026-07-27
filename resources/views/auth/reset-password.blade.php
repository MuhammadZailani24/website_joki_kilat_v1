<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Kata Sandi Baru - Joki Kilat</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-zinc-950 text-white font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden">

    <div class="fixed top-[-10%] right-[-10%] w-96 h-96 bg-orange-500/20 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="w-full max-w-md p-6 relative z-10">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold mt-6 text-white">Kata Sandi Baru</h2>
            <p class="text-gray-400 text-sm mt-2">Silakan buat kata sandi baru untuk akun Anda.</p>
        </div>

        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl">
            
            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-500 text-red-300 text-sm rounded-xl p-4 mb-6 text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Alamat Email</label>
                    <input type="email" name="email" value="{{ $email ?? old('email') }}" class="w-full bg-zinc-900/80 border border-zinc-700 text-gray-500 rounded-xl px-4 py-3 cursor-not-allowed" readonly required>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Kata Sandi Baru</label>
                    <input type="password" name="password" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" placeholder="Minimal 8 karakter..." required autofocus>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" placeholder="Ulangi kata sandi..." required>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-yellow-500 to-orange-500 text-zinc-950 font-bold text-lg py-3 rounded-xl hover:shadow-[0_0_20px_rgba(234,179,8,0.4)] transition hover:scale-[1.02]">
                    Simpan Kata Sandi
                </button>
            </form>
        </div>
    </div>

</body>
</html>