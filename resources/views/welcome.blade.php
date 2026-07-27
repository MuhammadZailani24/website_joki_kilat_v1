<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- PANGGIL META SEO DI SINI -->
    @include('meta')
    
    <!-- PANGGIL CSS & JS TAILWIND -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* CSS Khusus Animasi FAQ Buka-Tutup */
        details > summary { list-style: none; }
        details > summary::-webkit-details-marker { display: none; }
        details[open] summary ~ * { animation: sweep .5s ease-in-out; }
        @keyframes sweep { 0% {opacity: 0; margin-top: -10px} 100% {opacity: 1; margin-top: 0px} }
    </style>
</head>
<body class="bg-zinc-950 text-white font-sans antialiased selection:bg-yellow-500 selection:text-zinc-900">

    <div class="fixed top-0 left-1/4 w-96 h-96 bg-yellow-500/10 rounded-full blur-[120px] pointer-events-none z-0"></div>
    <div class="fixed bottom-0 right-1/4 w-96 h-96 bg-orange-500/10 rounded-full blur-[120px] pointer-events-none z-0"></div>

    <nav class="fixed w-full z-50 bg-zinc-950/80 backdrop-blur-md border-b border-white/10 transition-all duration-300">
        <div class="container mx-auto px-4 md:px-6 py-4 flex justify-between items-center">
            
            <a href="#" class="text-xl md:text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500 flex items-center gap-2 whitespace-nowrap">
                ⚡ Joki Kilat
            </a>
            
            <div class="hidden md:flex items-center space-x-8 text-sm font-medium text-gray-300">
                <a href="#layanan" class="hover:text-yellow-400 transition">Layanan</a>
                <a href="#cara-kerja" class="hover:text-yellow-400 transition">Cara Kerja</a>
                <a href="#testimoni" class="hover:text-yellow-400 transition">Testimoni</a>
                <a href="#faq" class="hover:text-yellow-400 transition">FAQ</a>
            </div>

            <div class="flex items-center gap-2 md:gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-yellow-500 to-orange-500 text-zinc-950 px-4 py-2 md:px-6 md:py-2.5 text-sm md:text-base rounded-full font-bold hover:shadow-[0_0_15px_rgba(234,179,8,0.5)] transition hover:scale-105 inline-block whitespace-nowrap">
                        Dashboard →
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-white/10 border border-white/20 text-white px-4 py-2 md:px-6 md:py-2.5 text-sm md:text-base rounded-full font-bold hover:bg-white/20 transition backdrop-blur-sm whitespace-nowrap">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-yellow-500 to-orange-500 text-zinc-950 px-4 py-2 md:px-6 md:py-2.5 text-sm md:text-base rounded-full font-bold hover:shadow-[0_0_15px_rgba(234,179,8,0.5)] transition hover:scale-105 inline-block whitespace-nowrap">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="relative z-10 pt-32 pb-20 px-6 text-center container mx-auto flex flex-col items-center justify-center min-h-[90vh]">
        @if(isset($activeBanner) && $activeBanner)
            <div class="w-full max-w-4xl mx-auto mb-10 rounded-3xl overflow-hidden border border-yellow-500/30 relative group shadow-[0_0_30px_rgba(234,179,8,0.2)]">
                <img src="{{ asset('storage/' . $activeBanner->gambar) }}" alt="{{ $activeBanner->judul }}" class="w-full h-auto max-h-[300px] object-cover opacity-80 group-hover:opacity-100 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-transparent flex flex-col justify-end p-6 md:p-8 text-left">
                    <div class="inline-block bg-yellow-500 text-zinc-950 font-black px-3 py-1 rounded-full text-xs mb-3 w-fit uppercase tracking-wider">🔥 Info Spesial</div>
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $activeBanner->judul }}</h2>
                    @if($activeBanner->deskripsi)
                        <p class="text-sm md:text-base text-gray-300 max-w-2xl">{{ $activeBanner->deskripsi }}</p>
                    @endif
                </div>
            </div>
        @else
            <div class="inline-block bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 font-semibold px-4 py-1.5 rounded-full text-sm mb-6 mt-12">
                🎉 Platform Joki Tugas #1 di Indonesia
            </div>
        @endif

        <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tight leading-tight max-w-4xl mx-auto text-white mt-4">
            Selesaikan Tugasmu dengan <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500">Cepat, Tepat & Aman!</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-400 mb-10 max-w-2xl mx-auto leading-relaxed">
            Mulai dari PR Sekolah, Makalah Kuliah, hingga pembuatan Aplikasi IT Profesional. Tim ahli kami siap membantu mengeksekusi masalah akademik Anda.
        </p>
        
        <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mb-10">
            <a href="{{ route('register') }}" class="w-full sm:w-auto bg-gradient-to-r from-yellow-500 to-orange-500 text-zinc-950 px-8 py-4 rounded-full font-bold text-lg hover:shadow-[0_0_25px_rgba(234,179,8,0.6)] hover:scale-105 transition-all">
                Mulai Pesan Sekarang
            </a>
            <a href="https://wa.me/6285172999562" target="_blank" class="w-full sm:w-auto bg-zinc-900 border border-zinc-700 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-zinc-800 transition flex items-center justify-center gap-2 group">
                <span class="group-hover:scale-110 transition">💬</span> Tanya Admin
            </a>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 bg-zinc-900/50 border border-zinc-800/50 py-3 px-6 rounded-full backdrop-blur-sm">
            <div class="flex -space-x-3">
                <div class="w-10 h-10 rounded-full border-2 border-zinc-950 bg-blue-500 flex items-center justify-center text-xs font-bold text-white shadow-lg">B</div>
                <div class="w-10 h-10 rounded-full border-2 border-zinc-950 bg-pink-500 flex items-center justify-center text-xs font-bold text-white shadow-lg">R</div>
                <div class="w-10 h-10 rounded-full border-2 border-zinc-950 bg-green-500 flex items-center justify-center text-xs font-bold text-white shadow-lg">D</div>
                <div class="w-10 h-10 rounded-full border-2 border-zinc-950 bg-purple-500 flex items-center justify-center text-xs font-bold text-white shadow-lg">F</div>
                <div class="w-10 h-10 rounded-full border-2 border-zinc-950 bg-orange-500 flex items-center justify-center text-xs font-bold text-zinc-950 shadow-lg">+</div>
            </div>
            <div class="text-center sm:text-left">
                <div class="flex items-center justify-center sm:justify-start gap-1 text-yellow-400 text-sm mb-0.5">
                    ⭐⭐⭐⭐⭐ <span class="text-gray-400 text-xs ml-1">(4.9/5 Rating)</span>
                </div>
                <p class="text-sm text-gray-300 font-medium"><span class="text-white font-bold">5.000+</span> Pengguna Terdaftar & Terbantu</p>
            </div>
        </div>
    </section>

    <!-- LAYANAN SECTION -->
    <section id="layanan" class="py-20 relative z-10 bg-zinc-900/30 border-y border-white/5">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Layanan Unggulan Kami</h2>
                <p class="text-gray-400 max-w-xl mx-auto">Kami mencakup semua jenjang pendidikan dan kebutuhan teknologi.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-zinc-900/80 backdrop-blur border border-zinc-800 rounded-3xl p-8 hover:-translate-y-2 hover:border-yellow-500/50 transition duration-300">
                    <div class="w-14 h-14 bg-blue-500/20 text-blue-400 rounded-2xl flex items-center justify-center text-3xl mb-6">📚</div>
                    <h3 class="text-xl font-bold text-white mb-3">Tugas Sekolah (SD-SMA)</h3>
                    <p class="text-gray-400 leading-relaxed">Pengerjaan PR harian, makalah, PPT, hingga rangkuman materi dari berbagai mata pelajaran dengan standar kurikulum.</p>
                </div>
                <div class="bg-zinc-900/80 backdrop-blur border border-zinc-800 rounded-3xl p-8 hover:-translate-y-2 hover:border-yellow-500/50 transition duration-300">
                    <div class="w-14 h-14 bg-yellow-500/20 text-yellow-400 rounded-2xl flex items-center justify-center text-3xl mb-6">🎓</div>
                    <h3 class="text-xl font-bold text-white mb-3">Tugas Mahasiswa</h3>
                    <p class="text-gray-400 leading-relaxed">Bantuan penulisan jurnal, proposal skripsi, analisis data SPSS, hingga tugas spesifik jurusan seperti akuntansi.</p>
                </div>
                <div class="bg-zinc-900/80 backdrop-blur border border-zinc-800 rounded-3xl p-8 hover:-translate-y-2 hover:border-blue-500/50 transition duration-300">
                    <div class="w-14 h-14 bg-purple-500/20 text-purple-400 rounded-2xl flex items-center justify-center text-3xl mb-6">💻</div>
                    <h3 class="text-xl font-bold text-white mb-3">Pembuatan Aplikasi IT</h3>
                    <p class="text-gray-400 leading-relaxed">Layanan khusus pembuatan website (Laravel/PHP), sistem informasi, hingga aplikasi mobile untuk tugas akhir atau UMKM.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONI SECTION -->
    @if(isset($reviews) && $reviews->count() > 0)
    <section id="testimoni" class="py-20 relative z-10">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Apa Kata Mereka?</h2>
                <p class="text-gray-400 max-w-xl mx-auto">Testimoni nyata dari pelanggan yang telah terbantu oleh layanan Joki Kilat.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($reviews as $review)
                <div class="bg-zinc-900 border border-zinc-800 p-8 rounded-3xl hover:border-yellow-500/50 transition duration-300 flex flex-col h-full shadow-lg">
                    <div class="flex text-yellow-400 text-sm mb-4">@for($i = 0; $i < $review->rating; $i++) ⭐ @endfor</div>
                    <p class="text-gray-300 italic mb-8 flex-1">"{{ $review->komentar }}"</p>
                    <div class="flex items-center gap-4 mt-auto pt-4 border-t border-zinc-800/50">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-yellow-500 to-orange-500 flex items-center justify-center font-bold text-zinc-950 uppercase text-lg">{{ substr($review->user->name ?? 'U', 0, 1) }}</div>
                        <div>
                            <p class="font-bold text-white text-sm">{{ $review->user->name ?? 'Pengguna' }}</p>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Pelanggan Setia</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- FAQ SECTION -->
    <section id="faq" class="py-20 relative z-10 bg-zinc-900/30 border-t border-white/5">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-gray-400">Masih ragu? Temukan jawaban dari pertanyaan yang sering ditanyakan pelanggan kami.</p>
            </div>
            
            <div class="space-y-4">
                <details class="bg-zinc-900 border border-zinc-800 rounded-2xl group cursor-pointer overflow-hidden transition-all duration-300 hover:border-yellow-500/30" open>
                    <summary class="p-6 font-bold text-white flex justify-between items-center outline-none">
                        Apakah data pribadi dan tugas saya aman dirahasiakan?
                        <span class="text-yellow-500 font-bold text-xl transition-transform duration-300 group-open:rotate-45">+</span>
                    </summary>
                    <div class="p-6 pt-0 text-gray-400 text-sm leading-relaxed border-t border-zinc-800/50 mt-2">
                        Sangat aman! Kami menjamin privasi 100%. Data sekolah, universitas, maupun identitas Anda tidak akan pernah kami sebarluaskan atau jadikan portofolio publik tanpa izin. File hasil tugas akan dihapus dari server kami dalam 30 hari setelah pesanan selesai.
                    </div>
                </details>

                <details class="bg-zinc-900 border border-zinc-800 rounded-2xl group cursor-pointer overflow-hidden transition-all duration-300 hover:border-yellow-500/30">
                    <summary class="p-6 font-bold text-white flex justify-between items-center outline-none">
                        Berapa lama estimasi pengerjaan tugasnya?
                        <span class="text-yellow-500 font-bold text-xl transition-transform duration-300 group-open:rotate-45">+</span>
                    </summary>
                    <div class="p-6 pt-0 text-gray-400 text-sm leading-relaxed border-t border-zinc-800/50 mt-2">
                        Waktu pengerjaan bervariasi tergantung tingkat kesulitan dan jenjang pendidikan. Untuk PR harian atau makalah SD/SMP biasanya memakan waktu 12-24 jam. Namun, kami juga menyediakan layanan <strong class="text-white">Prioritas Express</strong> untuk tugas yang harus selesai dalam waktu semalam (Deadline Mepet).
                    </div>
                </details>

                <details class="bg-zinc-900 border border-zinc-800 rounded-2xl group cursor-pointer overflow-hidden transition-all duration-300 hover:border-yellow-500/30">
                    <summary class="p-6 font-bold text-white flex justify-between items-center outline-none">
                        Bagaimana jika hasil tugas tidak sesuai atau butuh perbaikan?
                        <span class="text-yellow-500 font-bold text-xl transition-transform duration-300 group-open:rotate-45">+</span>
                    </summary>
                    <div class="p-6 pt-0 text-gray-400 text-sm leading-relaxed border-t border-zinc-800/50 mt-2">
                        Tenang saja, kami memberikan <strong class="text-white">Garansi Revisi Gratis</strong> (S&K Berlaku) jika hasil pengerjaan ada yang melenceng dari deskripsi tugas awal yang Anda berikan. Anda cukup memberitahu Admin, dan tim kami akan segera memperbaikinya.
                    </div>
                </details>

                <details class="bg-zinc-900 border border-zinc-800 rounded-2xl group cursor-pointer overflow-hidden transition-all duration-300 hover:border-yellow-500/30">
                    <summary class="p-6 font-bold text-white flex justify-between items-center outline-none">
                        Metode pembayaran apa saja yang tersedia di Joki Kilat?
                        <span class="text-yellow-500 font-bold text-xl transition-transform duration-300 group-open:rotate-45">+</span>
                    </summary>
                    <div class="p-6 pt-0 text-gray-400 text-sm leading-relaxed border-t border-zinc-800/50 mt-2">
                        Kami menggunakan metode pembayaran modern yaitu <strong class="text-white">QRIS</strong>. Anda bisa membayar menggunakan aplikasi E-Wallet apapun (GoPay, DANA, OVO, ShopeePay) maupun Mobile Banking (BCA, Mandiri, BNI, BRI, dll) cukup dengan scan barcode QRIS yang kami berikan saat checkout.
                    </div>
                </details>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-zinc-950 border-t border-white/5 pt-16 pb-8 relative z-10">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-2">
                    <div class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500 mb-4">⚡ Joki Kilat</div>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-sm mb-6">Platform jasa joki tugas akademik dan pembuatan aplikasi web/mobile profesional terpercaya di Indonesia.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Layanan Cepat</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#layanan" class="hover:text-yellow-400 transition">Tugas Sekolah</a></li>
                        <li><a href="#layanan" class="hover:text-yellow-400 transition">Pembuatan Aplikasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Bantuan & Legal</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#faq" class="hover:text-yellow-400 transition">FAQ</a></li>
                        <li><a href="https://wa.me/6285172999562" class="hover:text-yellow-400 transition">Hubungi CS</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center border-t border-white/5 pt-8 text-sm text-gray-600">
                &copy; {{ date('Y') }} Joki Kilat. All rights reserved. <br>
            </div>
        </div>
    </footer>
</body>
</html>