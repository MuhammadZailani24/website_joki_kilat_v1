<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Sistem - Admin Joki Kilat</title>
    @vite(['resources/css/app.css'])
    <style>
        /* CSS PRINTER ANTI-BOCOR - MEMAKSA BROWSER MENGHAPUS FLEXBOX */
        @media print {
            @page { margin: 1cm; size: auto; }
            body { 
                display: block !important; /* Matikan Flexbox Body */
                background-color: white !important; 
                -webkit-print-color-adjust: exact !important; 
                print-color-adjust: exact !important;
                color: black !important; 
                margin: 0 !important;
                padding: 0 !important;
            }
            /* Menghilangkan Sidebar, Overlay, Header, dan Tombol secara paksa */
            #adminSidebar, #mobileOverlay, header, button, .print-hide { 
                display: none !important; 
                width: 0 !important; 
                height: 0 !important; 
                opacity: 0 !important; 
                visibility: hidden !important; 
            }
            /* Menjadikan Main Konten selebar layar kertas */
            main { 
                display: block !important; 
                position: relative !important; 
                width: 100% !important; 
                overflow: visible !important; 
                background: white !important;
            }
            .print-area { 
                width: 100% !important; 
                padding: 0 !important; 
                margin: 0 !important; 
                box-shadow: none !important; 
                border: none !important; 
            }
            table { border-collapse: collapse !important; width: 100% !important; margin-top: 15px !important; }
            th, td { border: 1px solid #000 !important; color: black !important; padding: 8px !important; }
            th { background-color: #f3f4f6 !important; font-weight: bold !important; }
            * { color: black !important; background: transparent !important; }
        }
    </style>
</head>
<body class="bg-zinc-950 text-white font-sans antialiased flex h-screen overflow-hidden relative">

    <div id="mobileOverlay" class="fixed inset-0 bg-black/80 z-40 hidden lg:hidden backdrop-blur-sm transition-opacity print-hide" onclick="toggleSidebar()"></div>

    <aside id="adminSidebar" class="print-hide w-64 bg-zinc-900 border-r border-zinc-800 flex flex-col h-full flex-shrink-0 fixed inset-y-0 left-0 transform -translate-x-full lg:relative lg:translate-x-0 transition-transform duration-300 ease-in-out z-50">
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

    <main class="flex-1 flex flex-col h-full relative overflow-y-auto overflow-x-hidden w-full print:bg-white print:overflow-visible">
        
        <header class="print-hide h-16 flex items-center justify-between px-4 lg:px-8 border-b border-zinc-800 bg-zinc-950/80 backdrop-blur-md sticky top-0 z-10 w-full">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-400 hover:text-white hover:bg-zinc-800 rounded-lg transition focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-lg font-bold text-white truncate">Laporan Keuangan</h1>
            </div>
        </header>

        <div class="p-4 lg:p-8 w-full print-area">
            
            <div class="hidden print:block text-center border-b-[3px] border-black pb-4 mb-6 pt-4">
                <h1 class="text-3xl font-black uppercase tracking-widest text-black">JOKI KILAT</h1>
                <p class="text-sm text-black mt-1">Layanan Jasa Pengerjaan Tugas & Sistem Profesional</p>
                <p class="text-xs text-black">Dokumen Resmi: Laporan Pendapatan (Periode Bulan {{ $bulan }} / Tahun {{ $tahun }})</p>
            </div>

            <div class="flex flex-col md:flex-row justify-between md:items-center mb-8 gap-4 print-hide">
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-white mb-1">Laporan Pendapatan (Bulan {{ $bulan }}/{{ $tahun }})</h1>
                    <p class="text-xs md:text-sm text-gray-400">Rekapitulasi keuangan dari order Selesai.</p>
                </div>
                <button onclick="window.print()" class="bg-orange-600 hover:bg-orange-500 px-6 py-2.5 rounded-lg font-bold shadow-lg transition text-white w-full md:w-auto">🖨️ Cetak Laporan</button>
            </div>

            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-4 md:p-8 shadow-xl print-area">
                <p class="text-gray-400 uppercase font-bold text-xs md:text-sm tracking-widest mb-2 print:text-black">Total Pendapatan Bersih Bulan Ini:</p>
                <p class="text-3xl md:text-5xl font-black text-green-400 mb-6 md:mb-8 border-b border-zinc-800 pb-6 md:pb-8 print:text-black print:border-black print:text-4xl print:mb-4">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</p>

                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse min-w-[500px]">
                        <thead>
                            <tr class="text-gray-400 uppercase text-[10px] md:text-xs border-b border-zinc-700 bg-zinc-950/50 print:bg-gray-100 print:text-black print:border-black">
                                <th class="py-3 md:py-4 px-4 font-bold">Tgl Selesai</th>
                                <th class="py-3 md:py-4 px-4 font-bold">ID</th>
                                <th class="py-3 md:py-4 px-4 font-bold">Layanan</th>
                                <th class="py-3 md:py-4 px-4 font-bold text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs md:text-sm text-gray-300 print:text-black">
                            @forelse($reports as $r)
                            <tr class="border-b border-zinc-800/50 hover:bg-zinc-800/30 transition print:bg-transparent print:border-black">
                                <td class="py-3 md:py-4 px-4">{{ $r->updated_at->format('d/m/Y H:i') }}</td>
                                <td class="py-3 md:py-4 px-4 font-bold text-yellow-400 print:text-black">#{{ $r->id }}</td>
                                <td class="py-3 md:py-4 px-4">{{ $r->kategori_layanan }} ({{ $r->jenjang }})</td>
                                <td class="py-3 md:py-4 px-4 text-green-400 font-bold text-right print:text-black">Rp {{ number_format($r->total_harga, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="py-8 text-center text-gray-500 print:text-black print:border-black">Tidak ada transaksi bulan ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="hidden print:flex justify-end mt-16">
                    <div class="text-center w-56">
                        <p class="text-sm text-black mb-24">Banjarmasin, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                        <p class="text-sm text-black font-bold uppercase underline">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-black mt-1">Administrator Joki Kilat</p>
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