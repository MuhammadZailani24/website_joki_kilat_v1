<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Joki Kilat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css'])
    <style>
        .rating-input { flex-direction: row-reverse; display: flex; justify-content: flex-end; }
        .rating-input input { display: none; }
        .rating-input label { cursor: pointer; font-size: 2rem; color: #3f3f46; transition: 0.2s; }
        .rating-input label:hover, .rating-input label:hover ~ label, .rating-input input:checked ~ label { color: #eab308; }
        #chat-box::-webkit-scrollbar { width: 6px; }
        #chat-box::-webkit-scrollbar-thumb { background-color: #52525b; border-radius: 10px; }
        .typing-dot { animation: typing 1.4s infinite ease-in-out both; }
        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }
        @keyframes typing {
            0%, 80%, 100% { transform: scale(0); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body class="bg-zinc-950 text-white font-sans antialiased relative overflow-x-hidden p-6 md:p-12">

    <div class="fixed top-[-10%] left-[-10%] w-96 h-96 bg-yellow-500/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-6xl mx-auto relative z-10">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <a href="{{ route('dashboard') }}" class="text-sm text-yellow-400 hover:underline flex items-center gap-1 w-max">
                ← Kembali ke Dashboard
            </a>
            
            <div class="flex flex-wrap items-center gap-2">
                @if(in_array($order->status, ['Menunggu Verifikasi', 'Proses', 'Selesai']))
                    <a href="https://wa.me/6285172999562?text=Halo%20Admin%20Joki%20Kilat,%20saya%20ingin%20mengkonfirmasi%20pesanan%20saya%20dengan%20Nomor%20Order:%20%23{{ $order->id }}" target="_blank" class="flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white text-xs font-bold px-4 py-2.5 rounded-xl border border-green-500 transition shadow-md">
                        💬 Konfirmasi via WA
                    </a>
                @endif
                
                <a href="{{ route('order.invoice', $order->id) }}" target="_blank" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded-xl transition text-sm flex items-center gap-2">
                  📄 Cetak Invoice PDF
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 lg:items-start">
            
            <div class="lg:col-span-2 flex flex-col gap-6">
                <!-- NOTIFIKASI SUKSES -->
                @if(session('success'))
                    <div class="bg-green-500/20 border border-green-500/50 text-green-300 px-6 py-4 rounded-3xl font-bold shadow-[0_0_20px_rgba(34,197,94,0.1)] mb-[-10px]">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-[0_0_40px_rgba(0,0,0,0.5)]">
                    <div class="flex justify-between items-start mb-6 border-b border-white/10 pb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-1">Order #{{ $order->id }}</h2>
                            <p class="text-sm text-gray-400">Dibuat: {{ $order->created_at->format('d F Y') }}</p>
                        </div>
                        <div>
                            @if($order->status == 'Pending')
                                <span class="bg-zinc-500/20 text-zinc-400 px-4 py-2 rounded-full text-sm font-bold border border-zinc-500/30">PENDING</span>
                            @elseif($order->status == 'Menunggu Pembayaran' || $order->status == 'Menunggu Verifikasi')
                                <span class="bg-yellow-500/20 text-yellow-400 px-4 py-2 rounded-full text-sm font-bold border border-yellow-500/30">PEMBAYARAN</span>
                            @elseif($order->status == 'Proses')
                                <span class="bg-blue-500/20 text-blue-400 px-4 py-2 rounded-full text-sm font-bold border border-blue-500/30">DIPROSES</span>
                            @elseif($order->status == 'Revisi')
                                <span class="bg-purple-500/20 text-purple-400 px-4 py-2 rounded-full text-sm font-bold border border-purple-500/30">DIREVISI</span>
                            @else
                                <span class="bg-green-500/20 text-green-400 px-4 py-2 rounded-full text-sm font-bold border border-green-500/30">SELESAI</span>
                            @endif
                        </div>
                    </div>

                    @if($order->status == 'Selesai' && $order->file_hasil)
                        <div class="bg-green-500/10 border border-green-500/30 p-6 rounded-2xl mb-8 text-center">
                            <div class="text-4xl mb-3">🎉</div>
                            <h3 class="text-xl font-bold text-green-400 mb-2">Tugas Anda Selesai!</h3>
                            <a href="{{ asset('storage/' . $order->file_hasil) }}" target="_blank" class="inline-block bg-green-500 text-zinc-950 font-bold px-6 py-3 rounded-xl mt-3 hover:bg-green-400 transition shadow-[0_0_15px_rgba(34,197,94,0.3)]">
                                📥 Download Hasil Tugas
                            </a>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-zinc-900/50 p-5 rounded-xl border border-white/5">
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Jenjang</p>
                            <p class="font-bold text-lg uppercase text-yellow-400">{{ $order->jenjang }}</p>
                        </div>
                        <div class="bg-zinc-900/50 p-5 rounded-xl border border-white/5">
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Batas Waktu</p>
                            <p class="font-bold text-lg text-white">{{ \Carbon\Carbon::parse($order->deadline)->format('d F Y') }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <p class="text-sm text-gray-400 mb-1">Mata Pelajaran:</p>
                        <p class="text-lg font-semibold text-white">{{ $order->kategori_layanan }}</p>
                        @if($order->judul_tugas)
                            <p class="text-md text-gray-300 mt-1">Judul: {{ $order->judul_tugas }}</p>
                        @endif
                    </div>

                    <div class="mb-2">
                        <p class="text-sm text-gray-400 mb-2">Deskripsi Tugas:</p>
                        <div class="bg-zinc-900 border border-zinc-800 p-5 rounded-xl text-gray-300 whitespace-pre-wrap leading-relaxed text-sm">
                            {{ $order->deskripsi_tugas }}
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- KODE BARU: FITUR PENGAJUAN REVISI -->
                <!-- ========================================== -->
                @if($order->status == 'Selesai')
                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-[0_0_40px_rgba(0,0,0,0.5)] relative overflow-hidden">
                        <div class="absolute top-[-10%] right-[-5%] w-32 h-32 bg-yellow-500/10 rounded-full blur-[40px] pointer-events-none z-0"></div>
                        <div class="relative z-10">
                            <h3 class="text-xl font-black text-white mb-2">Pekerjaan Belum Sesuai? 🔄</h3>
                            <p class="text-sm text-gray-400 mb-6">Anda memiliki hak garansi revisi. Silakan jelaskan bagian mana yang dirasa kurang pas atau perlu diperbaiki oleh tim eksekutor kami.</p>
                            
                            <form action="{{ route('order.revisi', $order->id) }}" method="POST">
                                @csrf
                                <textarea name="catatan_revisi" rows="4" required class="w-full bg-zinc-900 border border-zinc-700 text-white rounded-xl px-4 py-3 mb-4 focus:outline-none focus:border-yellow-500 transition text-sm placeholder-gray-600 shadow-inner" placeholder="Contoh: Tolong perbaiki format daftar pustaka di halaman 5, dan warna sampul tolong diubah..."></textarea>
                                
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-zinc-950 font-black py-3 px-6 rounded-xl transition shadow-[0_0_15px_rgba(234,179,8,0.3)] w-full md:w-auto">
                                    AJUKAN REVISI SEKARANG
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
                <!-- ========================================== -->

                @if($order->status == 'Selesai')
                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-[0_0_40px_rgba(0,0,0,0.5)]">
                        @if(!$order->review)
                            <h3 class="text-xl font-bold text-yellow-400 mb-4">Beri Ulasan Layanan Kami</h3>
                            
                            <form action="{{ route('review.store', $order->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="rating-input mb-4">
                                    <input type="radio" id="star5" name="rating" value="5" required><label for="star5">★</label>
                                    <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                                    <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                                    <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                                    <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                                </div>
                                <textarea name="komentar" rows="2" class="w-full bg-zinc-900 border border-zinc-700 text-white rounded-xl px-4 py-3 mb-4 focus:outline-none focus:border-yellow-500" placeholder="Tulis komentar..." required></textarea>
                                
                                <div class="mb-5">
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Upload Screenshot (Opsional)</label>
                                    <input type="file" name="screenshot" accept="image/*" class="w-full bg-zinc-900 border border-zinc-700 text-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:border-yellow-500 transition text-sm file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-zinc-700 file:text-white hover:file:bg-zinc-600 cursor-pointer">
                                </div>

                                <button type="submit" class="w-full bg-yellow-500 text-zinc-950 font-bold py-3 rounded-xl hover:bg-yellow-400 transition shadow-[0_0_15px_rgba(234,179,8,0.3)]">Kirim Ulasan</button>
                            </form>
                        @else
                            <h3 class="text-lg font-bold text-white mb-4">Ulasan Anda</h3>
                            <div class="text-2xl text-yellow-500 mb-2">
                                @for($i = 0; $i < $order->review->rating; $i++)
                                    ★
                                @endfor
                                @for($i = 0; $i < (5 - $order->review->rating); $i++)
                                    <span class="text-zinc-700">★</span>
                                @endfor
                            </div>
                            <p class="text-gray-300 italic mb-4">"{{ $order->review->komentar }}"</p>
                            
                            @if($order->review->screenshot)
                                <div class="mt-4 border-t border-white/10 pt-4">
                                    <p class="text-xs text-gray-500 mb-2">Lampiran Screenshot:</p>
                                    <img src="{{ asset('storage/' . $order->review->screenshot) }}" alt="Screenshot Ulasan" class="rounded-xl border border-zinc-700 max-h-48 object-cover shadow-lg">
                                </div>
                            @endif
                        @endif
                    </div>
                @endif
            </div>

            <div class="lg:col-span-1 flex flex-col bg-zinc-900/80 border border-zinc-700 rounded-3xl overflow-hidden shadow-2xl h-[600px]">
                <div class="bg-zinc-800/80 p-5 border-b border-zinc-700 flex justify-between items-center shrink-0">
                    <div>
                        <h3 class="font-bold text-white text-lg">Live Chat</h3>
                        <p class="text-xs text-green-400 flex items-center gap-1.5 mt-1">
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span> CS & AI Online
                        </p>
                    </div>
                </div>

                <div id="chat-box" class="flex-1 overflow-y-auto p-5 space-y-4 bg-zinc-950/50">
                    <div class="text-center text-xs text-gray-500 mt-4">Memuat pesan...</div>
                </div>

                <div class="bg-zinc-800 p-4 border-t border-zinc-700 shrink-0">
                    <form id="chat-form" enctype="multipart/form-data" class="flex items-center gap-2 w-full">
                        <input type="text" id="pesan" name="pesan" class="flex-1 min-w-0 bg-zinc-900 border border-zinc-700 text-white rounded-full px-4 py-2.5 text-sm focus:outline-none focus:border-yellow-500 transition" placeholder="Ketik pesan..." autocomplete="off">
                        <label class="shrink-0 cursor-pointer bg-zinc-700 hover:bg-zinc-600 text-white w-10 h-10 rounded-full transition flex items-center justify-center">
                            📎
                            <input type="file" id="lampiran" name="lampiran" class="hidden">
                        </label>
                        <button type="submit" id="btn-kirim" class="shrink-0 bg-yellow-500 hover:bg-yellow-400 text-zinc-950 w-10 h-10 rounded-full font-bold transition flex items-center justify-center">
                            ➤
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        const orderId = parseInt("{{ $order->id }}");
        const currentUserId = parseInt("{{ Auth::id() }}");
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const btnKirim = document.getElementById('btn-kirim');
        let isScrolledToBottom = true;
        let isSending = false;

        chatBox.addEventListener('scroll', () => {
            isScrolledToBottom = chatBox.scrollHeight - chatBox.clientHeight <= chatBox.scrollTop + 10;
        });

        async function fetchMessages() {
            if (isSending) return;
            try {
                const response = await fetch(`/order/${orderId}/chat`);
                const messages = await response.json();
                chatBox.innerHTML = ''; 
                
                if (messages.length === 0) {
                    chatBox.innerHTML = '<div class="text-center text-xs text-gray-500 mt-4">Belum ada percakapan. Mulai sapa CS kami!</div>';
                    return;
                }

                messages.forEach(msg => {
                    const isBot = msg.pesan && msg.pesan.startsWith('🤖');
                    const isMe = (msg.user_id === currentUserId) && !isBot;
                    const alignment = isMe ? 'justify-end' : 'justify-start';
                    const bgColor = isMe ? 'bg-yellow-500 text-zinc-950 rounded-br-none' : 'bg-zinc-800 text-gray-200 border border-zinc-700 rounded-bl-none';
                    let senderName = 'Admin';
                    if (isMe) senderName = 'Anda';
                    if (isBot) senderName = 'AI Asisten';

                    let attachmentHtml = '';
                    if (msg.lampiran) {
                        attachmentHtml = `<a href="/storage/${msg.lampiran}" target="_blank" class="block mt-2 text-xs underline font-bold ${isMe ? 'text-zinc-800' : 'text-yellow-400'}">📄 Buka Lampiran</a>`;
                    }
                    let textPesan = msg.pesan ? msg.pesan.replace(/\n/g, '<br>') : '';

                    const messageHtml = `
                        <div class="flex ${alignment} mb-2">
                            <div class="max-w-[85%]">
                                <p class="text-[10px] text-gray-500 mb-1 ${isMe ? 'text-right' : 'text-left'}">${senderName}</p>
                                <div class="${bgColor} px-4 py-2.5 rounded-2xl text-sm shadow-md leading-relaxed">
                                    ${textPesan ? `<span>${textPesan}</span>` : ''}
                                    ${attachmentHtml}
                                </div>
                            </div>
                        </div>
                    `;
                    chatBox.innerHTML += messageHtml;
                });

                if (isScrolledToBottom) {
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            } catch (error) {
                console.error("Gagal mengambil pesan", error);
            }
        }

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const pesanInput = document.getElementById('pesan');
            const lampiranInput = document.getElementById('lampiran');
            const pesan = pesanInput.value;
            const lampiran = lampiranInput.files[0];
            
            if (!pesan && !lampiran) return;

            isSending = true;
            btnKirim.disabled = true;
            btnKirim.classList.add('opacity-50', 'cursor-not-allowed');

            if (pesan) {
                chatBox.innerHTML += `
                    <div class="flex justify-end mb-2">
                        <div class="max-w-[85%]">
                            <p class="text-[10px] text-gray-400 mb-1 text-right">Anda (Mengirim...)</p>
                            <div class="bg-yellow-600 text-zinc-950 px-4 py-2.5 rounded-2xl text-sm shadow-md rounded-br-none">
                                <span>${pesan.replace(/\n/g, '<br>')}</span>
                            </div>
                        </div>
                    </div>
                `;
            }

            chatBox.innerHTML += `
                <div id="ai-typing" class="flex justify-start mb-2">
                    <div class="max-w-[85%]">
                        <p class="text-[10px] text-gray-500 mb-1 text-left">AI Asisten</p>
                        <div class="bg-zinc-800 text-gray-400 border border-zinc-700 px-4 py-3 rounded-2xl text-sm shadow-md rounded-bl-none flex items-center gap-1.5">
                            <div class="w-1.5 h-1.5 bg-gray-400 rounded-full typing-dot"></div>
                            <div class="w-1.5 h-1.5 bg-gray-400 rounded-full typing-dot"></div>
                            <div class="w-1.5 h-1.5 bg-gray-400 rounded-full typing-dot"></div>
                        </div>
                    </div>
                </div>
            `;
            chatBox.scrollTop = chatBox.scrollHeight;

            const formData = new FormData();
            if (pesan) formData.append('pesan', pesan);
            if (lampiran) formData.append('lampiran', lampiran);
            pesanInput.value = '';
            lampiranInput.value = '';
            
            try {
                await fetch(`/order/${orderId}/chat`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: formData
                });
            } catch (error) {
                console.error("Gagal mengirim pesan.");
            } finally {
                isSending = false;
                isScrolledToBottom = true;
                btnKirim.disabled = false;
                btnKirim.classList.remove('opacity-50', 'cursor-not-allowed');
                fetchMessages(); 
            }
        });

        fetchMessages();
        setInterval(fetchMessages, 3000);
    </script>
</body>
</html>