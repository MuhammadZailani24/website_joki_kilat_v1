<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }} - Joki Kilat</title>
    <style>
        body { font-family: sans-serif; color: #333333; font-size: 12px; line-height: 1.4; margin: 0; padding: 20px; background-color: #ffffff; }
        .container { width: 100%; max-width: 700px; margin: 0 auto; padding: 20px; border: 1px solid #dddddd; border-radius: 6px; }
        
        /* Header */
        .header { width: 100%; border-bottom: 2px solid #f59e0b; padding-bottom: 15px; margin-bottom: 20px; }
        .header td { vertical-align: middle; }
        .brand-title { margin: 0; font-size: 18px; font-weight: bold; color: #111111; text-transform: uppercase; }
        .brand-sub { margin: 2px 0 0; font-size: 10px; color: #666666; }
        .invoice-title { text-align: right; }
        .invoice-title h2 { margin: 0; font-size: 20px; color: #d97706; text-transform: uppercase; }
        .invoice-title p { margin: 2px 0 0; font-size: 11px; color: #666666; }

        /* Info Section */
        .info-table { width: 100%; margin-bottom: 20px; font-size: 11px; }
        .info-table td { width: 50%; vertical-align: top; }
        .section-title { font-weight: bold; color: #333333; margin-bottom: 5px; text-transform: uppercase; border-bottom: 1px solid #eeeeee; padding-bottom: 3px; }

        /* Items Table */
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #dddddd; padding: 8px; text-align: left; }
        .table th { background-color: #f3f4f6; font-size: 11px; text-transform: uppercase; color: #333333; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* Status Badge */
        .badge { padding: 3px 8px; font-weight: bold; font-size: 10px; color: #ffffff; background-color: #2563eb; border-radius: 3px; text-transform: uppercase; }

        /* Signature & Stamp */
        .signature-container { width: 100%; margin-top: 20px; }
        .signature-box { width: 210px; margin-left: auto; text-align: center; }
        .stamp { border: 2px solid #dc2626; color: #dc2626; padding: 6px; font-weight: bold; font-size: 10px; text-transform: uppercase; background-color: #fef2f2; margin-bottom: 8px; }
        .stamp-sub { font-size: 8px; margin-top: 2px; color: #991b1b; }

        /* Footer */
        .footer { margin-top: 30px; text-align: center; font-size: 9px; color: #9ca3af; border-top: 1px solid #eeeeee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        
        <!-- HEADER DENGAN LOGO -->
        <table class="header">
            <tr>
                <td style="width: 60px; padding-right: 10px;">
                    @if(isset($logoBase64) && $logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo" style="width: 50px; height: 50px; object-fit: contain; border-radius: 50%;">
                    @endif
                </td>
                <td>
                    <h2 class="brand-title">JOKI KILAT</h2>
                    <p class="brand-sub">Solusi Cepat Tugas Kuliah, Sekolah, & Pembuatan Aplikasi</p>
                </td>
                <td class="invoice-title">
                    <h2>INVOICE</h2>
                    <p>Order ID: #{{ $order->id }}</p>
                </td>
            </tr>
        </table>

        <!-- INFORMASI PELANGGAN & TRANSAKSI -->
        <table class="info-table">
            <tr>
                <td style="padding-right: 15px;">
                    <div class="section-title">Diterbitkan Kepada:</div>
                    <strong>Nama:</strong> {{ $order->user->name ?? 'Pelanggan' }}<br>
                    <strong>Institusi:</strong> {{ $order->institusi ?? '-' }}<br>
                    <strong>Email:</strong> {{ $order->user->email ?? '-' }}<br>
                    <strong>WhatsApp:</strong> {{ $order->user->whatsapp ?? '-' }}
                </td>
                <td style="padding-left: 15px;">
                    <div class="section-title">Detail Transaksi:</div>
                    <strong>Tanggal Order:</strong> {{ $order->created_at ? $order->created_at->format('d/m/Y') : '-' }}<br>
                    <strong>Batas Waktu:</strong> {{ $order->deadline ? date('d/m/Y', strtotime($order->deadline)) : '-' }}<br>
                    <strong>Status:</strong> <span class="badge">{{ $order->status }}</span>
                </td>
            </tr>
        </table>

        <!-- TABEL RINCIAN -->
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 55%;">Deskripsi Layanan</th>
                    <th class="text-center" style="width: 15%;">Jenjang</th>
                    <th class="text-right" style="width: 30%;">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $order->kategori_layanan }}</strong><br>
                        <small style="color: #666666;">Topik/Judul: {{ $order->judul_tugas }}</small>
                        @if($order->catatan_tambahan)
                            <br><small style="color: #888888;">Catatan: {{ $order->catatan_tambahan }}</small>
                        @endif
                    </td>
                    <td class="text-center" style="text-transform: uppercase; font-weight: bold;">{{ $order->jenjang }}</td>
                    <td class="text-right" style="font-weight: bold;">
                        {{ $order->total_harga ? 'Rp ' . number_format($order->total_harga, 0, ',', '.') : 'Menunggu Admin' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right"><strong>TOTAL TAGIHAN:</strong></td>
                    <td class="text-right" style="font-weight: bold; font-size: 13px; color: #d97706;">
                        {{ $order->total_harga ? 'Rp ' . number_format($order->total_harga, 0, ',', '.') : '-' }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- TANDA TANGAN & STEMPEL -->
        <table class="signature-container">
            <tr>
                <td></td>
                <td style="width: 210px;">
                    <div class="signature-box">
                        <div style="font-size: 10px; color: #666666; margin-bottom: 3px;">Banjarmasin, {{ date('d/m/Y') }}</div>
                        <div style="font-size: 10px; font-weight: bold; margin-bottom: 8px;">Disahkan Oleh:</div>
                        
                        <!-- STEMPEL RESMI -->
                        <div class="stamp">
                            LUNAS / VERIFIED
                            <div class="stamp-sub">JOKI KILAT ADMIN</div>
                        </div>

                        <div style="font-weight: bold; font-size: 11px; text-transform: uppercase; margin-top: 5px;">JOKI KILAT ADMIN</div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- FOOTER -->
        <div class="footer">
            Dokumen ini sah dan digenerate secara otomatis oleh sistem resmi Joki Kilat.
        </div>

    </div>
</body>
</html>