<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Joki Kilat</title>
    @vite(['resources/css/app.css'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-yellow-500 to-orange-500 flex items-center justify-center font-bold text-zinc-950 uppercase shrink-0">
                    {{ substr(Auth::user()->name ?? 'AD', 0, 2) }}
                </div>
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
        <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-yellow-500/5 rounded-full blur-[100px] pointer-events-none"></div>

        <header class="h-16 flex items-center justify-between px-4 lg:px-8 border-b border-zinc-800 bg-zinc-950/80 backdrop-blur-md sticky top-0 z-10 w-full">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-400 hover:text-white hover:bg-zinc-800 rounded-lg transition focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-lg font-bold text-white truncate">Ringkasan Sistem</h1>
            </div>
            <div class="text-xs md:text-sm text-gray-400 hidden sm:block">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
        </header>

        <div class="p-4 lg:p-8 space-y-8 z-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Total Pendapatan</p>
                        <p class="text-2xl lg:text-3xl font-black text-green-400">Rp {{ number_format($pendapatan, 0, ',', '.') }}</p>
                    </div>
                    <div class="absolute right-0 bottom-0 text-5xl lg:text-6xl opacity-5 group-hover:scale-110 transition-transform -rotate-12 translate-x-2 translate-y-2">💰</div>
                </div>

                <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Order Aktif (Proses)</p>
                        <p class="text-2xl lg:text-3xl font-black text-yellow-400">{{ $order_aktif }}</p>
                    </div>
                    <div class="absolute right-0 bottom-0 text-5xl lg:text-6xl opacity-5 group-hover:scale-110 transition-transform -rotate-12 translate-x-2 translate-y-2">⏳</div>
                </div>

                <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Order Selesai</p>
                        <p class="text-2xl lg:text-3xl font-black text-white">{{ $order_selesai }}</p>
                    </div>
                    <div class="absolute right-0 bottom-0 text-5xl lg:text-6xl opacity-5 group-hover:scale-110 transition-transform -rotate-12 translate-x-2 translate-y-2">✅</div>
                </div>

                <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Total Pengguna</p>
                        <p class="text-2xl lg:text-3xl font-black text-white">{{ $total_user }}</p>
                    </div>
                    <div class="absolute right-0 bottom-0 text-5xl lg:text-6xl opacity-5 group-hover:scale-110 transition-transform -rotate-12 translate-x-2 translate-y-2">👥</div>
                </div>
            </div>

            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-4 lg:p-6 shadow-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-base lg:text-lg font-bold text-white">Grafik Pesanan Masuk (7 Hari)</h2>
                </div>
                <div class="h-64 lg:h-72 w-full relative">
                    <canvas id="orderChart"></canvas>
                </div>
            </div>
        </div>
    </main>

    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('-translate-x-full');
            document.getElementById('mobileOverlay').classList.toggle('hidden');
        }

        const ctx = document.getElementById('orderChart').getContext('2d');
        const totalOrderData = parseInt('{{ $total_order }}');
        
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(234, 179, 8, 0.5)'); 
        gradient.addColorStop(1, 'rgba(234, 179, 8, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: [1, 3, 2, 5, 4, 8, totalOrderData], 
                    borderColor: '#eab308',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#18181b',
                    pointBorderColor: '#eab308',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { backgroundColor: '#27272a', titleColor: '#eab308', bodyColor: '#fff', borderColor: '#3f3f46', borderWidth: 1, padding: 10, displayColors: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false }, ticks: { color: '#a1a1aa', stepSize: 2 } },
                    x: { grid: { display: false, drawBorder: false }, ticks: { color: '#a1a1aa' } }
                }
            }
        });
    </script>
</body>
</html>