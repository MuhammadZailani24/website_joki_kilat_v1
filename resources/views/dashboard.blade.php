<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Joki Kilat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-zinc-950 text-white font-sans antialiased min-h-screen">

    <nav class="bg-white/5 backdrop-blur-md border-b border-white/10 sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500">
                ⚡ Joki Kilat
            </div>
            <div class="flex items-center gap-3 sm:gap-6">
                
                @php
                    // Mengambil notifikasi yang belum dibaca dari database
                    $unreadNotif = \App\Models\Notifikasi::where('user_id', Auth::id())->where('is_read', false)->orderBy('created_at', 'desc')->get();
                @endphp

                <div class="relative inline-block text-left mt-1">
                    <button type="button" id="btn-lonceng" class="relative p-2 text-gray-400 hover:text-yellow-400 transition focus:outline-none">
                        <svg class="w-6 h-6 {{ $unreadNotif->count() > 0 ? 'animate-pulse text-yellow-400' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        
                        @if($unreadNotif->count() > 0)
                            <span id="badge-notif" class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-zinc-950 bg-red-500 rounded-full animate-bounce">
                                {{ $unreadNotif->count() }}
                            </span>
                        @endif
                    </button>

                    <div id="panel-notif" class="hidden absolute right-0 mt-2 w-72 sm:w-80 bg-zinc-900 border border-zinc-700 rounded-xl shadow-2xl z-50 overflow-hidden">
                        <div class="px-4 py-3 border-b border-zinc-800 bg-zinc-800/50">
                            <h3 class="text-sm font-bold text-white">Notifikasi Terbaru</h3>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            @if($unreadNotif->count() > 0)
                                @foreach($unreadNotif as $notif)
                                    <a href="{{ $notif->url ?? '#' }}" class="block px-4 py-3 hover:bg-zinc-800 transition border-b border-zinc-800/50">
                                        <p class="text-xs font-bold text-yellow-400 mb-0.5">{{ $notif->judul }}</p>
                                        <p class="text-xs text-gray-300">{{ $notif->pesan }}</p>
                                        <p class="text-[10px] text-gray-500 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                                    </a>
                                @endforeach
                            @else
                                <div class="px-4 py-6 text-center text-xs text-gray-500">
                                    Belum ada notifikasi baru.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- TOMBOL PINTU RAHASIA ADMIN DIINJEKSI DI SINI -->
                <!-- ========================================== -->
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-block bg-yellow-500 text-zinc-950 px-4 py-2 rounded-lg text-sm font-black hover:bg-yellow-400 transition shadow-[0_0_15px_rgba(234,179,8,0.4)] border border-yellow-400">
                        ⚡ Panel Admin
                    </a>
                @endif
                <!-- ========================================== -->

                <a href="{{ route('profile.edit') }}" class="text-gray-300 hover:text-yellow-400 font-medium transition flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-white/5 border border-transparent hover:border-white/10">
                    <span class="text-lg">👤</span>
                    <span class="hidden sm:inline">Halo, {{ Auth::user()->name }}</span>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white px-4 py-2 rounded-lg text-sm font-semibold transition border border-red-500/50">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-10">
        
        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-300 text-sm rounded-xl p-4 mb-6 text-center shadow-[0_0_15px_rgba(34,197,94,0.2)]">
                🎉 {{ session('success') }}
            </div>
        @endif
        
        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-2xl p-8 mb-8 shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl font-bold text-zinc-950 mb-2">Selamat Datang kembali, {{ Auth::user()->name }}!</h1>
                <p class="text-zinc-900 font-medium">Pilih layanan di bawah ini untuk mulai memesan joki tugas atau pembuatan aplikasi.</p>
            </div>
            <div class="absolute -right-10 -top-10 w-64 h-64 bg-white/20 rounded-full blur-2xl"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-5 flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Order</p>
                    <p class="text-2xl font-black text-white">{{ $stat_total }}</p>
                </div>
                <div class="text-3xl opacity-50">📊</div>
            </div>
            <div class="bg-zinc-900 border border-yellow-500/30 rounded-2xl p-5 flex items-center justify-between shadow-[0_0_15px_rgba(234,179,8,0.1)]">
                <div>
                    <p class="text-yellow-400 text-xs font-bold uppercase tracking-wider mb-1">Menunggu</p>
                    <p class="text-2xl font-black text-white">{{ $stat_pending }}</p>
                </div>
                <div class="text-3xl opacity-50">⏳</div>
            </div>
            <div class="bg-zinc-900 border border-blue-500/30 rounded-2xl p-5 flex items-center justify-between shadow-[0_0_15px_rgba(59,130,246,0.1)]">
                <div>
                    <p class="text-blue-400 text-xs font-bold uppercase tracking-wider mb-1">Diproses</p>
                    <p class="text-2xl font-black text-white">{{ $stat_proses }}</p>
                </div>
                <div class="text-3xl opacity-50">⚙️</div>
            </div>
            <div class="bg-zinc-900 border border-green-500/30 rounded-2xl p-5 flex items-center justify-between shadow-[0_0_15px_rgba(34,197,94,0.1)]">
                <div>
                    <p class="text-green-400 text-xs font-bold uppercase tracking-wider mb-1">Selesai</p>
                    <p class="text-2xl font-black text-white">{{ $stat_selesai }}</p>
                </div>
                <div class="text-3xl opacity-50">✅</div>
            </div>
        </div>

        <h2 class="text-xl font-bold mb-4 text-gray-200">Pilih Layanan Tugas Akademik</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <a href="{{ route('order.create', 'sd') }}" class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 hover:-translate-y-2 hover:border-yellow-500 transition group">
                <div class="w-14 h-14 bg-blue-500/20 text-blue-400 rounded-xl flex items-center justify-center text-2xl font-bold mb-4 group-hover:bg-blue-500 group-hover:text-white transition">SD</div>
                <h3 class="text-lg font-bold text-white mb-2">Sekolah Dasar</h3>
                <p class="text-gray-400 text-sm">PR Harian, Tugas MTK, Menggambar, dsb.</p>
            </a>
            <a href="{{ route('order.create', 'smp') }}" class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 hover:-translate-y-2 hover:border-yellow-500 transition group">
                <div class="w-14 h-14 bg-green-500/20 text-green-400 rounded-xl flex items-center justify-center text-2xl font-bold mb-4 group-hover:bg-green-500 group-hover:text-white transition">SMP</div>
                <h3 class="text-lg font-bold text-white mb-2">Sekolah Menengah</h3>
                <p class="text-gray-400 text-sm">Makalah, PPT, Tugas IPA/IPS, dsb.</p>
            </a>
            <a href="{{ route('order.create', 'sma') }}" class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 hover:-translate-y-2 hover:border-yellow-500 transition group">
                <div class="w-14 h-14 bg-purple-500/20 text-purple-400 rounded-xl flex items-center justify-center text-2xl font-bold mb-4 group-hover:bg-purple-500 group-hover:text-white transition">SMA</div>
                <h3 class="text-lg font-bold text-white mb-2">SMA / SMK</h3>
                <p class="text-gray-400 text-sm">Proposal, Laporan Praktikum, Coding Dasar.</p>
            </a>
            <a href="{{ route('order.create', 'kuliah') }}" class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 hover:-translate-y-2 hover:border-yellow-500 transition group">
                <div class="w-14 h-14 bg-orange-500/20 text-orange-400 rounded-xl flex items-center justify-center text-2xl font-bold mb-4 group-hover:bg-orange-500 group-hover:text-white transition">🎓</div>
                <h3 class="text-lg font-bold text-white mb-2">Tugas Kuliah</h3>
                <p class="text-gray-400 text-sm">Skripsi, Jurnal, Makalah, Analisis Data.</p>
            </a>
        </div>

        <a href="{{ route('order.create', 'aplikasi') }}" class="block bg-gradient-to-r from-zinc-900 to-zinc-800 border border-blue-500/30 rounded-2xl p-8 mb-12 hover:border-blue-500 hover:shadow-[0_0_30px_rgba(59,130,246,0.15)] transition group relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <div class="inline-block bg-blue-500/20 text-blue-400 font-bold px-3 py-1 rounded-full text-xs mb-3 border border-blue-500/30">LAYANAN SPESIAL</div>
                    <h3 class="text-2xl font-bold text-white mb-2">Jasa Pembuatan Aplikasi IT</h3>
                    <p class="text-gray-400 max-w-2xl">Butuh website profil perusahaan, sistem informasi, atau aplikasi mobile Android? Tim *developer* kami siap mengeksekusi dengan spesifikasi yang Anda tentukan.</p>
                </div>
                <div class="bg-blue-600 text-white font-bold py-3 px-8 rounded-xl group-hover:bg-blue-500 group-hover:scale-105 transition whitespace-nowrap shadow-lg">
                    Buat Proposal Project →
                </div>
            </div>
            <div class="absolute right-0 top-0 w-64 h-full bg-blue-500/5 blur-[80px] pointer-events-none"></div>
        </a>

        <h2 class="text-xl font-bold mb-6 text-gray-200">Riwayat Pesanan Anda</h2>
        
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-6 shadow-lg overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="text-gray-400 border-b border-white/10 text-sm uppercase tracking-wider">
                        <th class="pb-4 font-medium px-4">Tanggal Pesan</th>
                        <th class="pb-4 font-medium px-4">Detail Layanan</th>
                        <th class="pb-4 font-medium px-4">Deadline</th>
                        <th class="pb-4 font-medium px-4">Status</th>
                        <th class="pb-4 font-medium px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300">
                    @forelse($pesanan as $item)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="py-5 px-4 text-sm">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="py-5 px-4">
                            <span class="block text-white font-semibold mb-1">{{ $item->kategori_layanan }}</span>
                            <span class="text-xs font-bold {{ $item->jenjang == 'APLIKASI' ? 'text-blue-400 bg-blue-500/10' : 'text-yellow-500 bg-yellow-500/10' }} px-2 py-1 rounded-md uppercase">{{ $item->jenjang }}</span>
                        </td>
                        <td class="py-5 px-4 text-sm">{{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}</td>
                        <td class="py-5 px-4">
                            @if($item->status == 'Pending')
                                <span class="bg-zinc-500/20 text-zinc-400 px-3 py-1.5 rounded-full text-xs font-bold border border-zinc-500/30">PENDING / CEK ADMIN</span>
                            @elseif($item->status == 'Menunggu Pembayaran')
                                <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1.5 rounded-full text-xs font-bold border border-yellow-500/30">BELUM BAYAR</span>
                            @elseif($item->status == 'Menunggu Verifikasi')
                                <span class="bg-blue-500/20 text-blue-400 px-3 py-1.5 rounded-full text-xs font-bold border border-blue-500/30">CEK PEMBAYARAN</span>
                            @elseif($item->status == 'Proses')
                                <span class="bg-blue-500/20 text-blue-400 px-3 py-1.5 rounded-full text-xs font-bold border border-blue-500/30">PROSES</span>
                            @else
                                <span class="bg-green-500/20 text-green-400 px-3 py-1.5 rounded-full text-xs font-bold border border-green-500/30">SELESAI</span>
                            @endif
                        </td>
                        <td class="py-5 px-4 text-center">
                            @if($item->status == 'Menunggu Pembayaran')
                                <a href="{{ route('order.payment', $item->id) }}" class="inline-block bg-yellow-500 hover:bg-yellow-400 text-zinc-950 font-bold text-xs px-4 py-2 rounded-lg shadow-[0_0_10px_rgba(234,179,8,0.4)] transition animate-pulse">
                                    Bayar Sekarang
                                </a>
                            @elseif($item->status == 'Menunggu Verifikasi')
                                <span class="text-xs text-gray-400 italic">Sedang diverifikasi...</span>
                            @else
                                <a href="{{ route('order.show', $item->id) }}" class="bg-zinc-800 hover:bg-zinc-700 text-white text-xs px-4 py-2 rounded-lg border border-zinc-600 transition">Lihat Detail</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <span class="text-4xl mb-3">📭</span>
                                <p>Belum ada riwayat pesanan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnLonceng = document.getElementById('btn-lonceng');
            const panelNotif = document.getElementById('panel-notif');
            const badgeNotif = document.getElementById('badge-notif');

            if (btnLonceng && panelNotif) {
                btnLonceng.addEventListener('click', async function() {
                    // Toggle buka/tutup dropdown
                    panelNotif.classList.toggle('hidden');

                    // Jika dropdown terbuka dan masih ada badge merah, kirim AJAX ke server
                    if (!panelNotif.classList.contains('hidden') && badgeNotif && badgeNotif.style.display !== 'none') {
                        try {
                            const response = await fetch('/notifikasi/read', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            });
                            
                            if (response.ok) {
                                // Sembunyikan badge merah setelah dibaca
                                badgeNotif.style.display = 'none';
                            }
                        } catch (error) {
                            console.error("Gagal memperbarui status notifikasi:", error);
                        }
                    }
                });

                // Klik di luar dropdown untuk menutup panel
                document.addEventListener('click', function(event) {
                    if (!btnLonceng.contains(event.target) && !panelNotif.contains(event.target)) {
                        panelNotif.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>