<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Aplikasi - Joki Kilat</title>
    @vite(['resources/css/app.css'])
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
</head>
<body class="bg-zinc-950 text-white font-sans antialiased relative overflow-x-hidden">

    <div class="fixed top-[-10%] left-[-10%] w-96 h-96 bg-blue-500/10 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-500/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 relative z-10">
        
        <div class="w-full max-w-3xl bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 sm:p-10 shadow-[0_0_40px_rgba(0,0,0,0.5)]">
            
            <div class="mb-8 border-b border-white/10 pb-6">
                <a href="{{ route('dashboard') }}" class="text-sm text-blue-400 hover:underline flex items-center gap-1 mb-4 w-max">
                    ← Kembali ke Dashboard
                </a>
                <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
                    💻 Layanan Pembuatan Aplikasi
                </h2>
                <p class="text-gray-400 mt-1 text-sm">Konsultasikan kebutuhan aplikasi Web, Desktop, atau Mobile Anda di sini.</p>
            </div>

            <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="jenjang" value="APLIKASI">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Jenis Layanan</label>
                        <select name="kategori_layanan" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                            <option value="Aplikasi Web">Aplikasi Web (Sistem Informasi, Profile, dll)</option>
                            <option value="Mobile App">Mobile App (Android/Flutter)</option>
                            <option value="Aplikasi Desktop">Aplikasi Desktop</option>
                            <option value="Sistem Akademik">Sistem Akademik / Skripsi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Nama Aplikasi</label>
                        <input type="text" name="judul_tugas" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Contoh: Sistem Kasir Minimarket" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Deskripsi Singkat Aplikasi</label>
                    <textarea name="deskripsi_tugas" rows="3" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none" placeholder="Jelaskan secara garis besar aplikasi ini untuk apa..." required></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Fitur Utama yang Diinginkan</label>
                    <textarea name="fitur_aplikasi" rows="4" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition resize-none" placeholder="1. Login Multi-user&#10;2. Print Struk PDF&#10;3. Grafik Penjualan..." required></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Referensi Desain (Link)</label>
                        <input type="text" name="referensi_desain" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="URL referensi (opsional)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Upload Contoh/Sketsa (Opsional)</label>
                        <input type="file" name="file_tugas" class="w-full bg-zinc-900/50 border border-zinc-700 text-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-500 file:text-white hover:file:bg-blue-600 cursor-pointer">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Estimasi Deadline</label>
                        <input type="text" id="deadline" name="deadline" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition cursor-pointer" placeholder="Pilih Tanggal..." required readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Estimasi Budget (Rp)</label>
                        <input type="number" name="budget_project" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Contoh: 1500000">
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold text-lg py-3.5 rounded-xl hover:shadow-[0_0_25px_rgba(59,130,246,0.5)] hover:scale-[1.01] transition-all duration-300 mt-6">
                    Kirim Proposal Project
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#deadline", {
            minDate: "today", 
            dateFormat: "Y-m-d", 
            altInput: true, 
            altFormat: "d F Y", 
            allowInput: false,
            disableMobile: "true" 
        });
    </script>
</body>
</html>