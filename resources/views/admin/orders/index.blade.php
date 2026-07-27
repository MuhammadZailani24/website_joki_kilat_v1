<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Order - Admin Joki Kilat</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-zinc-950 text-white font-sans antialiased flex h-screen overflow-hidden">

    <div id="mobileOverlay" class="fixed inset-0 bg-black/80 z-40 hidden lg:hidden backdrop-blur-sm transition-opacity" onclick="toggleSidebar()"></div>

    <aside id="adminSidebar" class="w-64 bg-zinc-900 border-r border-zinc-800 flex flex-col h-full flex-shrink-0 fixed inset-y-0 left-0 transform -translate-x-full lg:relative lg:translate-x-0 transition-transform duration-300 ease-in-out z-50">
        <div class="h-16 flex items-center justify-between px-6 border-b border-zinc-800 bg-zinc-950/50">
            <div class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500 tracking-wider">⚡ ADMIN PANEL</div>
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-500/10 text-yellow-400 font-bold border border-yellow-500/20' : 'text-gray-400 hover:text-white hover:bg-zinc-800' }} transition"><span class="text-lg">📊</span> Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-purple-500/10 text-purple-400 font-bold border border-purple-500/20' : 'text-gray-400 hover:text-white hover:bg-zinc-800' }} transition"><span class="text-lg">👥</span> Manajemen User</a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.orders.*') ? 'bg-red-500/10 text-red-400 font-bold border border-red-500/20' : 'text-gray-400 hover:text-white hover:bg-zinc-800' }} transition relative"><span class="text-lg">🛒</span> Manajemen Order</a>
            <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.payments.*') ? 'bg-green-500/10 text-green-400 font-bold border border-green-500/20' : 'text-gray-400 hover:text-white hover:bg-zinc-800' }} transition"><span class="text-lg">💳</span> Keuangan & QRIS</a>
            <a href="{{ route('admin.layanans.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.layanans.*') ? 'bg-blue-500/10 text-blue-400 font-bold border border-blue-500/20' : 'text-gray-400 hover:text-white hover:bg-zinc-800' }} transition"><span class="text-lg">⚙️</span> Layanan & Harga</a>
            <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.reviews.*') ? 'bg-pink-500/10 text-pink-400 font-bold border border-pink-500/20' : 'text-gray-400 hover:text-white hover:bg-zinc-800' }} transition"><span class="text-lg">⭐</span> Manajemen Testimoni</a>
            <a href="{{ route('admin.banners.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.banners.*') ? 'bg-cyan-500/10 text-cyan-400 font-bold border border-cyan-500/20' : 'text-gray-400 hover:text-white hover:bg-zinc-800' }} transition"><span class="text-lg">🖼️</span> Pengaturan Banner</a>
            <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.reports.*') ? 'bg-orange-500/10 text-orange-400 font-bold border border-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-zinc-800' }} transition"><span class="text-lg">📈</span> Laporan Sistem</a>
        </nav>
        <div class="p-4 border-t border-zinc-800 bg-zinc-950/30">
            <div class="flex items-center gap-3 mb-4 px-2">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-yellow-500 to-orange-500 flex items-center justify-center font-bold text-zinc-950 uppercase shrink-0">{{ substr(Auth::user()->name ?? 'AD', 0, 2) }}</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-white leading-tight truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-green-400">Super Admin</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('dashboard') }}" class="flex-1 flex items-center justify-center gap-2 bg-zinc-800 hover:bg-zinc-700 text-white text-xs font-bold py-2 rounded-lg transition border border-zinc-700">Web ↗</a>
                <form action="{{ route('logout') }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white text-xs font-bold py-2 rounded-lg transition border border-red-500/30">Keluar</button>
                </form>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full relative overflow-y-auto overflow-x-hidden w-full">
        <header class="h-16 flex items-center justify-between px-4 lg:px-8 border-b border-zinc-800 bg-zinc-950/80 backdrop-blur-md sticky top-0 z-10 w-full">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-400 hover:text-white hover:bg-zinc-800 rounded-lg transition focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-lg font-bold text-white truncate">Daftar Pesanan Joki</h1>
            </div>
            <div class="text-xs md:text-sm text-gray-400 hidden sm:block">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
        </header>

        <div class="p-4 lg:p-8 z-10 w-full">
            <!-- TAB FILTER STATUS (Ditambah Filter Revisi) -->
            <div class="flex flex-wrap gap-2 mb-6">
                <a href="{{ route('admin.orders.index') }}" class="px-3 py-1.5 md:px-4 md:py-2 text-[10px] md:text-xs font-bold rounded-lg border {{ !request('status') ? 'bg-yellow-500/20 border-yellow-500 text-yellow-400' : 'bg-zinc-900 border-zinc-700 text-gray-400 hover:bg-zinc-800' }}">Semua</a>
                <a href="{{ route('admin.orders.index', ['status' => 'Pending']) }}" class="px-3 py-1.5 md:px-4 md:py-2 text-[10px] md:text-xs font-bold rounded-lg border {{ request('status') == 'Pending' ? 'bg-gray-500/20 border-gray-500 text-gray-400' : 'bg-zinc-900 border-zinc-700 text-gray-400 hover:bg-zinc-800' }}">Pending</a>
                <a href="{{ route('admin.orders.index', ['status' => 'Menunggu Pembayaran']) }}" class="px-3 py-1.5 md:px-4 md:py-2 text-[10px] md:text-xs font-bold rounded-lg border {{ request('status') == 'Menunggu Pembayaran' ? 'bg-orange-500/20 border-orange-500 text-orange-400' : 'bg-zinc-900 border-zinc-700 text-gray-400 hover:bg-zinc-800' }}">Blm Bayar</a>
                <a href="{{ route('admin.orders.index', ['status' => 'Menunggu Verifikasi']) }}" class="px-3 py-1.5 md:px-4 md:py-2 text-[10px] md:text-xs font-bold rounded-lg border {{ request('status') == 'Menunggu Verifikasi' ? 'bg-blue-500/20 border-blue-500 text-blue-400' : 'bg-zinc-900 border-zinc-700 text-gray-400 hover:bg-zinc-800' }}">Cek Bayar</a>
                <a href="{{ route('admin.orders.index', ['status' => 'Proses']) }}" class="px-3 py-1.5 md:px-4 md:py-2 text-[10px] md:text-xs font-bold rounded-lg border {{ request('status') == 'Proses' ? 'bg-indigo-500/20 border-indigo-500 text-indigo-400' : 'bg-zinc-900 border-zinc-700 text-gray-400 hover:bg-zinc-800' }}">Diproses</a>
                <a href="{{ route('admin.orders.index', ['status' => 'Revisi']) }}" class="px-3 py-1.5 md:px-4 md:py-2 text-[10px] md:text-xs font-bold rounded-lg border {{ request('status') == 'Revisi' ? 'bg-red-500/20 border-red-500 text-red-400' : 'bg-zinc-900 border-zinc-700 text-gray-400 hover:bg-zinc-800' }}">Revisi</a>
                <a href="{{ route('admin.orders.index', ['status' => 'Selesai']) }}" class="px-3 py-1.5 md:px-4 md:py-2 text-[10px] md:text-xs font-bold rounded-lg border {{ request('status') == 'Selesai' ? 'bg-green-500/20 border-green-500 text-green-400' : 'bg-zinc-900 border-zinc-700 text-gray-400 hover:bg-zinc-800' }}">Selesai</a>
            </div>

            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl shadow-xl overflow-hidden w-full">
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse min-w-[900px]">
                        <thead>
                            <tr class="bg-zinc-950/50 text-gray-400 text-xs uppercase tracking-wider border-b border-zinc-800">
                                <th class="py-4 px-5 font-bold">ID / Tanggal</th>
                                <th class="py-4 px-5 font-bold">Pemesan</th>
                                <th class="py-4 px-5 font-bold">Detail Layanan</th>
                                <th class="py-4 px-5 font-bold">Deadline</th>
                                <th class="py-4 px-5 font-bold">Harga</th>
                                <th class="py-4 px-5 font-bold">Status</th>
                                <th class="py-4 px-5 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-300">
                            @forelse($orders as $item)
                                @php
                                    // Logika perhitungan Deadline Mepet (Sisa <= 2 Hari)
                                    $deadlineDate = \Carbon\Carbon::parse($item->deadline)->endOfDay();
                                    $isMepet = $deadlineDate->isPast() || now()->diffInDays($deadlineDate, false) <= 2;
                                    // Hanya kedip-kedip jika pesanan belum selesai
                                    $shouldBlinkDeadline = $isMepet && $item->status != 'Selesai';
                                @endphp
                                
                                <tr class="border-b border-zinc-800/50 hover:bg-zinc-800/30 transition">
                                    <td class="py-4 px-5">
                                        <p class="font-bold text-yellow-400">#{{ $item->id }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->created_at->format('d M Y H:i') }}</p>
                                    </td>
                                    <td class="py-4 px-5">
                                        <p class="font-bold text-white">{{ $item->user->name ?? 'User Dihapus' }}</p>
                                        <p class="text-xs text-gray-400">{{ $item->institusi }}</p>
                                    </td>
                                    <td class="py-4 px-5">
                                        <p class="font-semibold text-white">{{ $item->kategori_layanan }}</p>
                                        <span class="text-[10px] font-bold {{ $item->jenjang == 'APLIKASI' ? 'text-blue-400 bg-blue-500/10' : 'text-yellow-500 bg-yellow-500/10' }} px-2 py-0.5 rounded uppercase">{{ $item->jenjang }}</span>
                                    </td>
                                    
                                    <!-- KODE DEADLINE MEPET (KEDIP-KEDIP) -->
                                    <td class="py-4 px-5">
                                        @if($shouldBlinkDeadline)
                                            <div class="text-red-400 font-black animate-pulse flex flex-col items-start gap-1">
                                                <span>{{ $deadlineDate->format('d M Y') }}</span>
                                                <span class="bg-red-500/20 text-red-500 px-2 py-0.5 rounded-md text-[9px] uppercase tracking-widest border border-red-500/40">⚠️ Mepet!</span>
                                            </div>
                                        @else
                                            <span class="text-gray-300">{{ $deadlineDate->format('d M Y') }}</span>
                                        @endif
                                    </td>
                                    
                                    <td class="py-4 px-5 font-bold text-green-400">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                    
                                    <!-- KODE STATUS REVISI MENYALA (KEDIP-KEDIP) -->
                                    <td class="py-4 px-5">
                                        @if($item->status == 'Pending') 
                                            <span class="bg-gray-500/20 text-gray-400 px-3 py-1 rounded-full text-[10px] font-bold border border-gray-500/30">PENDING</span>
                                        @elseif($item->status == 'Menunggu Pembayaran') 
                                            <span class="bg-orange-500/20 text-orange-400 px-3 py-1 rounded-full text-[10px] font-bold border border-orange-500/30">BLM BAYAR</span>
                                        @elseif($item->status == 'Menunggu Verifikasi') 
                                            <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-[10px] font-bold border border-blue-500/30 animate-pulse">CEK BAYAR</span>
                                        @elseif($item->status == 'Proses') 
                                            <span class="bg-indigo-500/20 text-indigo-400 px-3 py-1 rounded-full text-[10px] font-bold border border-indigo-500/30">DIPROSES</span>
                                        @elseif($item->status == 'Revisi') 
                                            <!-- INI DIA ANIMASINYA -->
                                            <span class="bg-red-600 text-white px-3 py-1 rounded-full text-[10px] font-black border border-red-400 shadow-[0_0_15px_rgba(220,38,38,0.8)] animate-pulse inline-block">🚨 REVISI</span>
                                        @else 
                                            <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-[10px] font-bold border border-green-500/30">SELESAI</span>
                                        @endif
                                    </td>
                                    
                                    <td class="py-4 px-5 text-center">
                                        <a href="{{ route('admin.orders.show', $item->id) }}" class="inline-block bg-zinc-800 hover:bg-zinc-700 text-white text-[10px] md:text-xs px-3 py-1.5 rounded-lg border border-zinc-600 transition shadow-md">Detail ↗</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="py-12 text-center text-gray-500"><div class="text-4xl mb-3">📭</div><p>Belum ada data pesanan.</p></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('-translate-x-full');
            document.getElementById('mobileOverlay').classList.toggle('hidden');
        }
    </script>
</body>
</html>