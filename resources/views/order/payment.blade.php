<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Joki Kilat</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-zinc-950 text-white font-sans antialiased min-h-screen p-4 md:p-8 flex justify-center items-center relative overflow-x-hidden">
    
    <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-yellow-500/10 rounded-full blur-[100px] pointer-events-none z-0"></div>

    <div class="w-full max-w-4xl grid md:grid-cols-2 gap-6 relative z-10">
        
        <!-- BAGIAN KIRI: DETAIL TAGIHAN & COUNTDOWN -->
        <div class="bg-zinc-900/80 backdrop-blur-xl border border-zinc-800 rounded-3xl p-6 md:p-8 shadow-2xl flex flex-col justify-center">
            <div class="mb-8">
                <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-400 hover:text-white mb-6 inline-block">← Kembali ke Dashboard</a>
                <h1 class="text-3xl font-black text-white mb-2">Selesaikan Pembayaran</h1>
                <p class="text-sm text-gray-400">Order ID: <span class="font-bold text-yellow-500">#{{ $order->id }}</span></p>
            </div>

            <!-- ANIMASI COUNTDOWN -->
            <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-5 mb-8 text-center animate-pulse shadow-[0_0_20px_rgba(239,68,68,0.1)]">
                <p class="text-xs font-bold text-red-400 uppercase tracking-widest mb-2">Batas Waktu Pembayaran</p>
                <div class="flex justify-center gap-4 text-white font-black text-3xl font-mono" id="countdown-timer">
                    23:59:59
                </div>
            </div>

            <div class="space-y-4 text-sm border-t border-zinc-800/50 pt-6">
                <div class="flex justify-between text-gray-400"><span>Layanan</span><span class="text-white font-bold">{{ $order->kategori_layanan }}</span></div>
                <div class="flex justify-between text-gray-400"><span>Jenjang</span><span class="text-white font-bold">{{ $order->jenjang }}</span></div>
                <div class="flex justify-between text-gray-400 mt-4 pt-4 border-t border-zinc-800/50"><span class="text-lg">Total Tagihan</span><span class="text-2xl text-green-400 font-black">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span></div>
            </div>
        </div>

        <!-- BAGIAN KANAN: QRIS & UPLOAD BUKTI -->
        <div class="bg-zinc-900/80 backdrop-blur-xl border border-zinc-800 rounded-3xl p-6 md:p-8 shadow-2xl text-center">
            
            <!-- PERBAIKAN BINGKAI QRIS (ZOOM & CROP OTOMATIS) -->
            <div class="bg-white p-2 md:p-3 rounded-2xl inline-block mb-4 border-4 border-yellow-500 shadow-[0_0_30px_rgba(234,179,8,0.3)]">
                <!-- Kotak pelindung untuk menyembunyikan sisi luar gambar yang dipotong -->
                <div class="w-48 h-48 md:w-56 md:h-56 overflow-hidden rounded-xl relative flex items-center justify-center bg-white">
                    <!-- 
                        Class "scale-[1.4]" akan menge-zoom gambar sebesar 40% ke tengah.
                        Jika barcode masih kurang besar, ubah angkanya jadi scale-[1.5] atau scale-[1.6]
                    -->
                    <img src="{{ asset('images/qris.jpg') }}" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg'" alt="QRIS Joki Kilat" class="w-full h-full object-cover object-center scale-[1.4] origin-center">
                </div>
            </div>
            
            <h3 class="font-bold text-lg text-white mb-2">Scan QRIS Joki Kilat</h3>
            <p class="text-[11px] text-gray-400 mb-6 max-w-xs mx-auto">Pastikan nominal transfer sesuai dengan Total Tagihan. Jika sudah, silakan upload bukti struk di bawah ini.</p>

            <form action="{{ route('order.payment.process', $order->id) }}" method="POST" enctype="multipart/form-data" class="bg-zinc-950/50 p-4 rounded-2xl border border-zinc-800 text-left relative z-20">
                @csrf
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 text-center">Sudah Transfer? Upload Bukti (Max 3MB)</label>
                <input type="file" name="bukti_pembayaran" required accept="image/*" class="w-full bg-zinc-900 border border-zinc-700 text-white rounded-xl px-3 py-2 mb-4 focus:outline-none focus:border-yellow-500 transition text-sm file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-yellow-500 file:text-zinc-950 hover:file:bg-yellow-400 cursor-pointer">
                
                <button type="submit" class="w-full bg-gradient-to-r from-yellow-500 to-orange-500 text-zinc-950 font-black py-3 rounded-xl hover:shadow-[0_0_20px_rgba(234,179,8,0.4)] transition hover:scale-[1.02] text-sm">
                    KIRIM BUKTI PEMBAYARAN
                </button>
            </form>
        </div>

    </div>

    <script>
        let orderDate = new Date("{{ $order->created_at }}").getTime();
        let countDownDate = orderDate + (24 * 60 * 60 * 1000); 

        let x = setInterval(function() {
            let now = new Date().getTime();
            let distance = countDownDate - now;

            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            document.getElementById("countdown-timer").innerHTML = hours + ":" + minutes + ":" + seconds;

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown-timer").innerHTML = "KEDALUWARSA";
                document.getElementById("countdown-timer").classList.replace('text-white', 'text-red-500');
            }
        }, 1000);
    </script>
</body>
</html>