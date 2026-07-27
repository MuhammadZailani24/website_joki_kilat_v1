<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }} - Joki Kilat</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            body { background-color: white !important; color: black !important; }
            .no-print { display: none !important; }
            .print-border { border-color: #000 !important; }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800 p-8 flex justify-center" onload="window.print()">

    <div class="bg-white max-w-3xl w-full p-10 rounded-lg shadow-xl print:shadow-none print:p-0">
        
        <div class="flex justify-between items-start border-b-2 border-gray-200 pb-6 mb-6 print-border">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">INVOICE</h1>
                <p class="text-sm font-bold text-gray-500 mt-1">#INV-JK-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="text-right">
                <div class="text-2xl font-extrabold text-orange-500 mb-1">⚡ Joki Kilat</div>
                <p class="text-xs text-gray-500">Jl. Pangeran Antasari, Banjarmasin</p>
                <p class="text-xs text-gray-500">WA: 0856-5194-3602 | webjokikilat.com</p>
            </div>
        </div>

        <div class="flex justify-between items-start mb-8">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Ditagihkan Kepada:</p>
                <p class="font-bold text-gray-800 text-lg">{{ $order->user->name ?? 'User' }}</p>
                <p class="text-sm text-gray-600">{{ $order->institusi }}</p>
                <p class="text-sm text-gray-600">{{ $order->user->email ?? '' }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-600 mb-1"><span class="font-bold text-gray-800">Tanggal Order:</span> {{ $order->created_at->format('d M Y') }}</p>
                <p class="text-sm text-gray-600 mb-1"><span class="font-bold text-gray-800">Target Selesai:</span> {{ \Carbon\Carbon::parse($order->deadline)->format('d M Y') }}</p>
                <p class="text-sm text-gray-600"><span class="font-bold text-gray-800">Status Pembayaran:</span> <span class="text-green-600 font-bold uppercase">Lunas</span></p>
            </div>
        </div>

        <table class="w-full text-left border-collapse mb-8">
            <thead>
                <tr class="bg-gray-100 border-b-2 border-gray-300 print-border">
                    <th class="py-3 px-4 font-bold text-sm text-gray-700">Deskripsi Layanan</th>
                    <th class="py-3 px-4 font-bold text-sm text-gray-700 text-right">Jenjang</th>
                    <th class="py-3 px-4 font-bold text-sm text-gray-700 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-200 print-border">
                    <td class="py-4 px-4">
                        <p class="font-bold text-gray-800">{{ $order->kategori_layanan }}</p>
                        <p class="text-xs text-gray-500 mt-1">Judul: {{ $order->judul_tugas ?? '-' }}</p>
                        @if($order->layanan_tambahan)
                            <p class="text-xs text-gray-500 mt-1">Ekstra: {{ is_array($order->layanan_tambahan) ? implode(', ', $order->layanan_tambahan) : str_replace(['"', '[', ']'], '', $order->layanan_tambahan) }}</p>
                        @endif
                    </td>
                    <td class="py-4 px-4 text-right text-sm font-bold text-gray-700">{{ $order->jenjang }}</td>
                    <td class="py-4 px-4 text-right text-sm font-bold text-gray-800">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="flex justify-end mb-12">
            <div class="w-1/2">
                <div class="flex justify-between py-2 text-sm font-bold text-gray-600">
                    <span>Diskon Voucher:</span>
                    <span>Rp 0</span>
                </div>
                <div class="flex justify-between py-3 border-t-2 border-gray-800 print-border text-lg font-black text-gray-900 mt-2">
                    <span>TOTAL TAGIHAN:</span>
                    <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 print-border pt-6 text-center">
            <p class="text-xs text-gray-500 font-bold mb-1">Terima kasih telah menggunakan jasa Joki Kilat!</p>
            <p class="text-[10px] text-gray-400">Dokumen ini adalah bukti pembayaran digital yang sah dan tidak memerlukan tanda tangan basah.</p>
        </div>

        <div class="mt-8 text-center no-print">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">🖨️ Print Invoice / Simpan PDF</button>
            <button onclick="window.close()" class="bg-gray-500 hover:bg-gray-400 text-white font-bold py-2 px-6 rounded-lg shadow-md transition ml-2">Tutup Tab</button>
        </div>

    </div>

</body>
</html>