<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Order #{{ $order->id }} - Admin</title>
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
                <a href="{{ route('admin.orders.index') }}" class="flex-1 flex items-center justify-center gap-2 bg-zinc-800 hover:bg-zinc-700 text-white text-xs font-bold py-2 rounded-lg transition border border-zinc-700">← Kembali</a>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full relative overflow-y-auto overflow-x-hidden w-full">
        <header class="h-16 flex items-center justify-between px-4 lg:px-8 border-b border-zinc-800 bg-zinc-950/80 backdrop-blur-md sticky top-0 z-10 w-full">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-400 hover:text-white hover:bg-zinc-800 rounded-lg transition focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-lg font-bold text-white truncate">Detail Order</h1>
            </div>
        </header>

        <div class="p-4 lg:p-8 w-full">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white">Pesanan <span class="text-yellow-400">#{{ $order->id }}</span></h1>
                    <p class="text-sm text-gray-400 mt-1">Oleh <strong>{{ $order->user->name ?? 'User Dihapus' }}</strong></p>
                </div>
                @if(session('success')) <div class="bg-green-500/20 border border-green-500 text-green-300 text-sm font-bold rounded-xl px-4 py-2 shadow-lg w-full md:w-auto">✅ {{ session('success') }}</div> @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- BAGIAN KIRI: DETAIL TUGAS & PEMBAYARAN -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-4 lg:p-6 shadow-xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-zinc-950/50 p-4 rounded-xl border border-zinc-800">
                                <p class="text-[10px] text-gray-500 uppercase tracking-wider font-bold mb-1">Layanan</p>
                                <p class="text-lg font-bold text-white">{{ $order->kategori_layanan }}</p>
                                <span class="text-[10px] font-bold text-yellow-500 bg-yellow-500/10 px-2 py-0.5 rounded uppercase mt-1 inline-block">{{ $order->jenjang }}</span>
                            </div>
                            <div class="bg-zinc-950/50 p-4 rounded-xl border border-zinc-800">
                                <p class="text-[10px] text-gray-500 uppercase tracking-wider font-bold mb-1">Deadline</p>
                                <p class="text-lg font-bold text-white">{{ \Carbon\Carbon::parse($order->deadline)->format('d F Y') }}</p>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-400 mb-1 font-bold">Judul Tugas:</p>
                        <p class="text-md text-white mb-4">{{ $order->judul_tugas ?? '-' }}</p>
                        
                        <p class="text-sm text-gray-400 mb-1 font-bold">Deskripsi:</p>
                        <div class="bg-zinc-950/50 p-4 rounded-xl border border-zinc-800 text-sm text-gray-300 whitespace-pre-wrap mb-4">{{ $order->deskripsi_tugas }}</div>
                        
                        @if($order->layanan_tambahan)
                            <p class="text-sm text-gray-400 mb-1 font-bold">Ekstra:</p>
                            <p class="text-sm text-yellow-400 font-semibold mb-4">{{ is_array($order->layanan_tambahan) ? implode(', ', $order->layanan_tambahan) : str_replace(['"', '[', ']'], '', $order->layanan_tambahan) }}</p>
                        @endif
                        
                        @if($order->file_tugas)
                            <div class="mt-4 border-t border-zinc-800 pt-4">
                                <a href="{{ asset('storage/' . $order->file_tugas) }}" target="_blank" class="inline-flex items-center gap-2 bg-blue-500/10 text-blue-400 border border-blue-500/30 px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-500 hover:text-white transition">📥 Download Pendukung</a>
                            </div>
                        @endif

                        <!-- KODE BARU: MENAMPILKAN CATATAN REVISI DARI PELANGGAN -->
                        @if($order->catatan_revisi)
                            <div class="mt-6 mb-4 bg-red-500/10 border border-red-500/30 p-4 rounded-xl relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-20 h-20 bg-red-500/20 rounded-full blur-[30px] pointer-events-none"></div>
                                <p class="text-sm text-red-400 mb-2 font-black uppercase tracking-wider relative z-10">⚠️ Catatan Revisi Pelanggan:</p>
                                <p class="text-sm text-white font-medium whitespace-pre-wrap relative z-10">{{ $order->catatan_revisi }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-4 lg:p-6 shadow-xl">
                        <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">💳 Pembayaran</h3>
                        <div class="flex flex-col md:flex-row md:items-center justify-between bg-zinc-950/50 p-4 rounded-xl border border-zinc-800 gap-4">
                            <div>
                                <p class="text-sm text-gray-400">Total Tagihan (Aktif):</p>
                                <p class="text-2xl font-black text-green-400">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                @if($order->bukti_pembayaran) <a href="{{ asset('storage/' . $order->bukti_pembayaran) }}" target="_blank" class="block w-full text-center md:inline-block bg-zinc-800 hover:bg-zinc-700 text-white text-xs px-4 py-2 rounded-lg border border-zinc-600 transition shadow-md">Lihat Bukti Transfer ↗</a>
                                @else <span class="block w-full text-center text-xs text-red-400 bg-red-500/10 px-3 py-2 rounded-xl border border-red-500/20">Belum Ada Bukti</span> @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN KANAN: UPDATE HARGA, STATUS & UPLOAD HASIL -->
                <div class="space-y-6">
                    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-4 lg:p-6 shadow-xl relative overflow-hidden">
                        
                        <!-- Glow Effect -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500/10 rounded-full blur-[50px] pointer-events-none"></div>

                        <h3 class="text-lg font-bold text-white mb-4 relative z-10">🛠️ Update Tagihan & Status</h3>
                        
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="relative z-10">
                            @csrf @method('PUT')
                            
                            <!-- INPUT PENETAPAN HARGA -->
                            <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Total Tagihan (Rp)</label>
                            <input type="number" name="total_harga" value="{{ $order->total_harga }}" class="w-full bg-zinc-950 border border-zinc-700 text-green-400 rounded-xl px-4 py-3 mb-4 focus:outline-none focus:border-yellow-500 font-bold" required>

                            <!-- INPUT PILIH STATUS -->
                            <label class="block text-[10px] md:text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Status Pesanan</label>
                            <select name="status" class="w-full bg-zinc-950 border border-zinc-700 text-white rounded-xl px-4 py-3 mb-6 focus:outline-none focus:border-yellow-500 font-bold">
                                <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="Menunggu Pembayaran" {{ $order->status == 'Menunggu Pembayaran' ? 'selected' : '' }}>💳 Menunggu Pembayaran</option>
                                <option value="Menunggu Verifikasi" {{ $order->status == 'Menunggu Verifikasi' ? 'selected' : '' }}>🔍 Menunggu Verifikasi</option>
                                <option value="Proses" {{ $order->status == 'Proses' ? 'selected' : '' }}>⚙️ Sedang Diproses</option>
                                <option value="Revisi" {{ $order->status == 'Revisi' ? 'selected' : '' }}>🔄 Revisi</option>
                                <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>✅ Selesai</option>
                            </select>
                            
                            <button type="submit" class="w-full bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-400 hover:to-orange-400 text-zinc-950 font-black py-3 rounded-xl transition shadow-[0_0_15px_rgba(234,179,8,0.4)]">Simpan Perubahan</button>
                        </form>
                    </div>

                    <div class="bg-green-900/10 border border-green-500/30 rounded-2xl p-4 lg:p-6 shadow-xl relative overflow-hidden">
                        <h3 class="text-lg font-bold text-green-400 mb-2 relative z-10">📤 Upload Hasil</h3>
                        <form action="{{ route('admin.orders.upload-hasil', $order->id) }}" method="POST" enctype="multipart/form-data" class="relative z-10">
                            @csrf
                            <input type="file" name="file_hasil" required class="w-full bg-zinc-950 border border-zinc-800 text-gray-300 rounded-xl px-3 py-2 mb-4 focus:outline-none focus:border-green-500 transition text-sm file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-zinc-800 file:text-white hover:file:bg-zinc-700 cursor-pointer">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white font-bold py-2.5 rounded-xl transition shadow-[0_0_15px_rgba(34,197,94,0.4)]">Upload & Selesaikan</button>
                        </form>
                        @if($order->file_hasil)
                            <div class="mt-4 pt-4 border-t border-green-500/20 relative z-10">
                                <a href="{{ asset('storage/' . $order->file_hasil) }}" target="_blank" class="text-sm font-bold text-green-400 hover:underline flex items-center gap-2">📄 Lihat File Selesai ↗</a>
                            </div>
                        @endif
                    </div>
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