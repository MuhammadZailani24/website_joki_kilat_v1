<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Joki Kilat</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-zinc-950 text-white font-sans antialiased relative overflow-x-hidden p-6 md:p-12">

    <div class="fixed top-[-10%] right-[-10%] w-96 h-96 bg-yellow-500/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-2xl mx-auto relative z-10">
        <a href="{{ route('dashboard') }}" class="text-sm text-yellow-400 hover:underline flex items-center gap-1 mb-6 w-max">
            ← Kembali ke Dashboard
        </a>

        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 sm:p-10 shadow-[0_0_40px_rgba(0,0,0,0.5)]">
            
            <div class="mb-8 border-b border-white/10 pb-6">
                <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500">
                    Pengaturan Profil
                </h2>
                <p class="text-gray-400 mt-1 text-sm">Perbarui informasi kontak dan kata sandi akun Anda.</p>
            </div>

            @if($errors->any())
                <div class="bg-red-500/20 border border-red-500 text-red-300 text-sm rounded-xl p-4 mb-6 shadow-[0_0_15px_rgba(239,68,68,0.2)]">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Nomor WhatsApp Aktif</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-zinc-900/50 border border-zinc-700 text-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" required>
                    <p class="text-xs text-gray-500 mt-1">Digunakan untuk login ke dalam sistem.</p>
                </div>

                <div class="mt-8 border-t border-white/10 pt-6">
                    <h3 class="text-lg font-bold text-gray-200 mb-4">Ubah Kata Sandi (Opsional)</h3>
                    <p class="text-sm text-gray-400 mb-6">Biarkan seluruh kolom di bawah ini kosong jika Anda tidak ingin mengubah kata sandi.</p>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" placeholder="Masukkan sandi lama Anda untuk verifikasi...">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">Kata Sandi Baru</label>
                                <input type="password" name="password" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" placeholder="Minimal 8 karakter...">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" placeholder="Ulangi sandi baru...">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-yellow-500 to-orange-500 text-zinc-950 font-bold text-lg py-3.5 rounded-xl hover:shadow-[0_0_25px_rgba(234,179,8,0.5)] hover:scale-[1.01] transition-all duration-300 mt-6">
                    Simpan Perubahan Profil
                </button>
            </form>
        </div>
    </div>

</body>
</html>