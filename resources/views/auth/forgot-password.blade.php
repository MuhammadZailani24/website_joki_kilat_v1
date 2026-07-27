<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - Joki Kilat</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-zinc-950 text-white font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden">

    <div class="fixed top-[-10%] left-[-10%] w-96 h-96 bg-yellow-500/20 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="w-full max-w-md p-6 relative z-10">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500">
                ⚡ Joki Kilat
            </a>
            <h2 class="text-2xl font-bold mt-6 text-white">Lupa Kata Sandi?</h2>
            <p class="text-gray-400 text-sm mt-2">Masukkan email yang terdaftar, kami akan mengirimkan tautan untuk membuat kata sandi baru.</p>
        </div>

        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl">
            
            @if (session('status'))
                <div class="bg-green-500/20 border border-green-500 text-green-300 text-sm rounded-xl p-4 mb-6 text-center">
                    ✅ {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-500 text-red-300 text-sm rounded-xl p-4 mb-6 text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Alamat Email</label>
                    <input type="email" name="email" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" placeholder="contoh@gmail.com" required>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-yellow-500 to-orange-500 text-zinc-950 font-bold text-lg py-3 rounded-xl hover:shadow-[0_0_20px_rgba(234,179,8,0.4)] transition hover:scale-[1.02]">
                    Kirim Tautan Reset
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-yellow-500 hover:text-yellow-400 transition font-medium">← Kembali ke Halaman Login</a>
            </div>
        </div>
    </div>

</body>
</html>