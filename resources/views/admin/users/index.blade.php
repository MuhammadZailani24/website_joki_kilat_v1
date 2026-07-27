<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - Admin Joki Kilat</title>
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
                <h1 class="text-lg font-bold text-white truncate">Manajemen Pengguna</h1>
            </div>
        </header>

        <div class="p-4 lg:p-8 w-full">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white mb-1">Daftar Pengguna Sistem</h1>
                    <p class="text-sm text-gray-400">Kelola akun pelanggan, berikan akses admin, atau hapus pengguna.</p>
                </div>
                @if(session('success')) 
                    <div class="bg-green-500/20 border border-green-500 text-green-300 text-sm font-bold rounded-xl px-4 py-2 shadow-lg w-full md:w-auto">✅ {{ session('success') }}</div> 
                @endif
            </div>

            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl shadow-xl overflow-hidden w-full">
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse min-w-[900px]">
                        <thead>
                            <tr class="bg-zinc-950/50 text-gray-400 text-xs uppercase tracking-wider border-b border-zinc-800">
                                <th class="py-4 px-5 font-bold">Tgl. Daftar</th>
                                <th class="py-4 px-5 font-bold">Nama Lengkap</th>
                                <th class="py-4 px-5 font-bold">Kontak (Email / WA)</th>
                                <th class="py-4 px-5 font-bold">Hak Akses</th>
                                <th class="py-4 px-5 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-300">
                            @forelse($users as $user)
                                <tr class="border-b border-zinc-800/50 hover:bg-zinc-800/30 transition">
                                    <td class="py-4 px-5 text-gray-400 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="py-4 px-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center font-bold text-white uppercase">{{ substr($user->name, 0, 1) }}</div>
                                            <p class="font-bold text-white">{{ $user->name }}</p>
                                        </div>
                                    </td>
                                    <td class="py-4 px-5">
                                        <p class="text-white">{{ $user->email }}</p>
                                        <p class="text-xs text-green-400 mt-1 font-semibold">WA: {{ $user->whatsapp ?? '-' }}</p>
                                    </td>
                                    <td class="py-4 px-5">
                                        @if($user->role === 'admin')
                                            <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-[10px] font-bold border border-yellow-500/30">ADMIN</span>
                                        @else
                                            <span class="bg-zinc-700/50 text-gray-400 px-3 py-1 rounded-full text-[10px] font-bold border border-zinc-600">USER</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-5 text-center">
                                        <div class="flex justify-center gap-2">
                                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="role" value="{{ $user->role === 'admin' ? 'user' : 'admin' }}">
                                                <button type="submit" class="bg-blue-500/10 hover:bg-blue-500 text-blue-400 hover:text-white text-[10px] md:text-xs px-3 py-1.5 rounded-lg border border-blue-500/30 transition font-bold">
                                                    {{ $user->role === 'admin' ? 'Cabut Admin' : 'Jadikan Admin' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini permanen? Semua data ordernya juga akan hilang!')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white text-[10px] md:text-xs px-3 py-1.5 rounded-lg border border-red-500/30 transition font-bold" {{ Auth::id() === $user->id ? 'disabled' : '' }}>Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-12 text-center text-gray-500">Belum ada pengguna terdaftar.</td></tr>
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