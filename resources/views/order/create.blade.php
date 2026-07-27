<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pesanan - Joki Kilat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @vite(['resources/css/app.css'])
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    
    <style>
        /* Animasi AI Berpikir */
        .ai-pulse { box-shadow: 0 0 0 0 rgba(168, 85, 247, 0.7); animation: pulse-purple 1.5s infinite cubic-bezier(0.66, 0, 0, 1); }
        @keyframes pulse-purple { to { box-shadow: 0 0 0 15px rgba(168, 85, 247, 0); } }
    </style>
</head>
<body class="bg-zinc-950 text-white font-sans antialiased relative overflow-x-hidden">

    <div class="fixed top-[-10%] left-[-10%] w-96 h-96 bg-yellow-500/10 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-96 h-96 bg-orange-500/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 relative z-10">
        
        <div class="w-full max-w-2xl bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 sm:p-10 shadow-[0_0_40px_rgba(0,0,0,0.5)]">
            
            <div class="mb-8 border-b border-white/10 pb-6 flex justify-between items-start">
                <div>
                    <a href="{{ route('dashboard') }}" class="text-sm text-yellow-400 hover:underline flex items-center gap-1 mb-4 w-max">
                        ← Kembali ke Dashboard
                    </a>
                    <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500">
                        ⚡ Form Order Joki
                    </h2>
                    <p class="text-gray-400 mt-1 text-sm">Lengkapi spesifikasi tugas Anda agar tim kami bisa mengerjakannya dengan akurat.</p>
                </div>
            </div>

            <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="form-order">
                @csrf
                <input type="hidden" name="jenjang" id="input-jenjang" value="{{ strtoupper($jenjang) }}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Jenjang Pendidikan</label>
                        <div class="w-full bg-zinc-900 border border-zinc-800 text-yellow-400 rounded-xl px-4 py-3 font-bold uppercase tracking-wider">
                            {{ $jenjang }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Institusi / Sekolah</label>
                        <input type="text" name="institusi" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" placeholder="Contoh: SMAN 1 / UNISKA" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Mata Pelajaran / Layanan</label>
                        <input type="text" name="kategori_layanan" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" placeholder="Contoh: Matematika Diskrit" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Judul Tugas</label>
                        <input type="text" name="judul_tugas" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" placeholder="Contoh: Makalah Sistem Operasi" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Deskripsi & Instruksi Tugas</label>
                    <textarea name="deskripsi_tugas" id="deskripsi_tugas" rows="4" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition resize-none" placeholder="Jelaskan detail tugas Anda di sini..." required></textarea>
                </div>

                <div class="bg-zinc-900/40 p-5 rounded-xl border border-zinc-800">
                    <label class="block text-sm font-semibold text-gray-200 mb-3">Layanan Tambahan (Opsional)</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="layanan-tambahan-group">
                        <label class="flex items-center space-x-3 text-sm text-gray-300 cursor-pointer">
                            <input type="checkbox" name="layanan_tambahan[]" value="Prioritas Pengerjaan" class="w-5 h-5 rounded border-zinc-600 text-yellow-500 focus:ring-yellow-500 bg-zinc-800">
                            <span>Prioritas Pengerjaan</span>
                        </label>
                        <label class="flex items-center space-x-3 text-sm text-gray-300 cursor-pointer">
                            <input type="checkbox" name="layanan_tambahan[]" value="Pengerjaan Express" class="w-5 h-5 rounded border-zinc-600 text-yellow-500 focus:ring-yellow-500 bg-zinc-800">
                            <span>Pengerjaan Express</span>
                        </label>
                        <label class="flex items-center space-x-3 text-sm text-gray-300 cursor-pointer">
                            <input type="checkbox" name="layanan_tambahan[]" value="Revisi Tambahan" class="w-5 h-5 rounded border-zinc-600 text-yellow-500 focus:ring-yellow-500 bg-zinc-800">
                            <span>Revisi Tambahan</span>
                        </label>
                        <label class="flex items-center space-x-3 text-sm text-gray-300 cursor-pointer">
                            <input type="checkbox" name="layanan_tambahan[]" value="Garansi Revisi" class="w-5 h-5 rounded border-zinc-600 text-yellow-500 focus:ring-yellow-500 bg-zinc-800">
                            <span>Garansi Revisi</span>
                        </label>
                    </div>
                </div>

                <div class="bg-purple-900/10 border border-purple-500/30 rounded-xl p-5 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-purple-500/20 rounded-full blur-[40px] pointer-events-none"></div>
                    
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 relative z-10">
                        <div>
                            <h3 class="text-purple-400 font-bold flex items-center gap-2">
                                🤖 Joki AI Engine
                            </h3>
                            <p class="text-xs text-gray-400 mt-1">Gunakan AI untuk memprediksi biaya dan waktu ideal pengerjaan tugas Anda.</p>
                        </div>
                        <button type="button" id="btn-ai-estimasi" class="bg-purple-600 hover:bg-purple-500 text-white text-sm font-bold px-5 py-2.5 rounded-lg transition shadow-[0_0_15px_rgba(168,85,247,0.4)] flex-shrink-0 flex items-center gap-2">
                            ✨ Hitung Estimasi
                        </button>
                    </div>

                    <div id="ai-result-box" class="hidden mt-4 pt-4 border-t border-purple-500/20">
                        <div id="ai-loading" class="text-center py-2 hidden">
                            <div class="inline-block w-5 h-5 border-2 border-purple-400 border-t-transparent rounded-full animate-spin"></div>
                            <p class="text-xs text-purple-300 mt-2">AI sedang menganalisis tingkat kesulitan tugas...</p>
                        </div>
                        
                        <div id="ai-content" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-zinc-900/80 p-4 rounded-lg border border-purple-500/30">
                                <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">💰 Estimasi Biaya</p>
                                <p id="ai-harga" class="text-xl font-black text-white">Rp 0</p>
                            </div>
                            <div class="bg-zinc-900/80 p-4 rounded-lg border border-purple-500/30">
                                <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">⏱️ Rekomendasi Deadline</p>
                                <p id="ai-waktu" class="text-xl font-black text-white">0 Hari</p>
                            </div>
                            
                            <div class="sm:col-span-2 mt-1 p-3 bg-yellow-500/10 border border-yellow-500/30 rounded-lg">
                                <p class="text-[11px] text-yellow-400 text-center italic leading-relaxed">
                                    ⚠️ <strong>PENTING:</strong> Angka di atas hanyalah estimasi awal dari sistem AI. Harga dan tenggat waktu final akan ditentukan secara manual oleh Admin setelah Anda mengirimkan form pesanan ini.
                                </p>
                            </div>

                            <div class="sm:col-span-2">
                                <button type="button" id="btn-terapkan-ai" class="w-full bg-zinc-800 hover:bg-zinc-700 text-purple-400 text-xs font-bold py-2.5 rounded-lg transition border border-zinc-700">
                                    Terapkan Rekomendasi Deadline ke Form 👇
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Batas Waktu (Deadline)</label>
                        <input type="text" id="deadline" name="deadline" class="w-full bg-zinc-900/50 border border-zinc-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition cursor-pointer" placeholder="Pilih Tanggal..." required readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">File Pendukung (Opsional)</label>
                        <input type="file" name="file_tugas" class="w-full bg-zinc-900/50 border border-zinc-700 text-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition text-sm file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-yellow-500 file:text-zinc-950 hover:file:bg-yellow-400 cursor-pointer">
                    </div>
                </div>

                <div class="bg-yellow-500/5 p-5 rounded-xl border border-dashed border-yellow-500/50">
                    <label class="block text-sm font-semibold text-yellow-400 mb-2">🎁 Punya Kode Promo / Voucher?</label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="text" id="input-voucher" class="flex-1 bg-zinc-900/80 border border-zinc-700 text-white rounded-xl px-4 py-3 uppercase focus:outline-none focus:border-yellow-500 transition tracking-widest" placeholder="Ketik Kode Di Sini...">
                        <button type="button" id="btn-cek-voucher" class="bg-zinc-800 hover:bg-zinc-700 text-white px-6 py-3 rounded-xl border border-zinc-700 transition font-bold whitespace-nowrap">
                            Cek Kode
                        </button>
                    </div>
                    <p id="pesan-voucher" class="text-sm mt-3 hidden"></p>
                    <input type="hidden" name="kode_voucher" id="kode_voucher_tersembunyi">
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-yellow-500 to-orange-500 text-zinc-950 font-bold text-lg py-3.5 rounded-xl hover:shadow-[0_0_25px_rgba(234,179,8,0.5)] hover:scale-[1.01] transition-all duration-300 mt-6">
                    Kirim Pesanan Joki
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const fpDeadline = flatpickr("#deadline", {
            minDate: "today",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
            allowInput: false,
            disableMobile: "true"
        });

        const btnAi = document.getElementById('btn-ai-estimasi');
        const aiResultBox = document.getElementById('ai-result-box');
        const aiLoading = document.getElementById('ai-loading');
        const aiContent = document.getElementById('ai-content');
        const textHarga = document.getElementById('ai-harga');
        const textWaktu = document.getElementById('ai-waktu');
        const btnTerapkan = document.getElementById('btn-terapkan-ai');
        
        let recommendedDate = null;

        btnAi.addEventListener('click', function() {
            const jenjang = document.getElementById('input-jenjang').value;
            const deskripsi = document.getElementById('deskripsi_tugas').value;
            const addons = document.querySelectorAll('input[name="layanan_tambahan[]"]:checked');
            
            if(!deskripsi) {
                alert("Mohon isi 'Deskripsi & Instruksi Tugas' terlebih dahulu agar AI bisa menganalisis tingkat kesulitan.");
                return;
            }

            btnAi.classList.add('ai-pulse');
            aiResultBox.classList.remove('hidden');
            aiLoading.classList.remove('hidden');
            aiContent.classList.add('hidden');

            setTimeout(() => {
                let basePrice = 0;
                let daysNeeded = 0;

                if(jenjang === 'SD') { basePrice = 50000; daysNeeded = 2; }
                else if(jenjang === 'SMP') { basePrice = 80000; daysNeeded = 3; }
                else if(jenjang === 'SMA') { basePrice = 120000; daysNeeded = 4; }
                else if(jenjang === 'KULIAH') { basePrice = 200000; daysNeeded = 7; }
                else if(jenjang === 'APLIKASI') { basePrice = 750000; daysNeeded = 14; }
                else { basePrice = 50000; daysNeeded = 3; }

                const wordCount = deskripsi.trim().split(/\s+/).length;
                basePrice += (wordCount * 1000); 

                addons.forEach(cb => {
                    if(cb.value === 'Prioritas Pengerjaan') basePrice += 50000;
                    if(cb.value === 'Revisi Tambahan') basePrice += 25000;
                    if(cb.value === 'Garansi Revisi') basePrice += 35000;
                    if(cb.value === 'Pengerjaan Express') { 
                        basePrice += 100000; 
                        daysNeeded = Math.max(1, Math.floor(daysNeeded / 2));
                    }
                });

                const rangeMin = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(basePrice);
                const rangeMax = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(basePrice + 50000);
                
                const today = new Date();
                today.setDate(today.getDate() + daysNeeded);
                recommendedDate = today;

                textHarga.innerText = `${rangeMin} - ${rangeMax}`;
                textWaktu.innerText = `${daysNeeded} Hari Kerja`;
                
                aiLoading.classList.add('hidden');
                aiContent.classList.remove('hidden');
                btnAi.classList.remove('ai-pulse');

            }, 1500);
        });

        btnTerapkan.addEventListener('click', function() {
            if(recommendedDate) {
                fpDeadline.setDate(recommendedDate);
                alert("✅ Tanggal deadline berhasil diperbarui mengikuti rekomendasi AI!");
            }
        });

        const btnCekVoucher = document.getElementById('btn-cek-voucher');
        const inputVoucher = document.getElementById('input-voucher');
        const pesanVoucher = document.getElementById('pesan-voucher');
        const kodeTersembunyi = document.getElementById('kode_voucher_tersembunyi');

        btnCekVoucher.addEventListener('click', async function() {
            const kode = inputVoucher.value.trim();
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            if(!kode) {
                pesanVoucher.className = "text-sm mt-3 text-red-400 block";
                pesanVoucher.innerHTML = "❌ Kode voucher tidak boleh kosong!";
                return;
            }

            btnCekVoucher.innerHTML = "Mengecek...";
            btnCekVoucher.disabled = true;

            try {
                const response = await fetch('/cek-voucher', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ kode: kode })
                });

                const data = await response.json();

                if(data.status === 'success') {
                    pesanVoucher.className = "text-sm mt-3 text-green-400 font-bold block";
                    const diskonRp = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data.potongan);
                    pesanVoucher.innerHTML = `✅ ${data.message} (Diskon: ${diskonRp})`;
                    kodeTersembunyi.value = kode;
                    inputVoucher.readOnly = true;
                    inputVoucher.classList.add('opacity-50');
                    btnCekVoucher.innerHTML = "Terpakai";
                } else {
                    pesanVoucher.className = "text-sm mt-3 text-red-400 block";
                    pesanVoucher.innerHTML = `❌ ${data.message}`;
                    kodeTersembunyi.value = '';
                    btnCekVoucher.innerHTML = "Cek Kode";
                    btnCekVoucher.disabled = false;
                }
            } catch (error) {
                pesanVoucher.className = "text-sm mt-3 text-red-400 block";
                pesanVoucher.innerHTML = "❌ Terjadi kesalahan jaringan. Coba lagi.";
                btnCekVoucher.innerHTML = "Cek Kode";
                btnCekVoucher.disabled = false;
            }
        });
    </script>
</body>
</html>