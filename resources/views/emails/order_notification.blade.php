<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi Joki Kilat</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #18181b; color: #ffffff; padding: 20px; margin: 0;">
    
    <div style="max-w: 600px; margin: 0 auto; background-color: #27272a; padding: 30px; border-radius: 15px; border-top: 5px solid #eab308;">
        
        <h2 style="color: #eab308; margin-top: 0;">⚡ Joki Kilat</h2>
        <h3 style="color: #ffffff;">Halo, {{ $order->user->name }}!</h3>

        @if($jenis_notif == 'baru')
            <p style="color: #a1a1aa; line-height: 1.6;">Terima kasih telah membuat pesanan di <strong>Joki Kilat</strong>. Berikut adalah detail spesifikasi tugas Anda yang saat ini sedang menunggu pengecekan Admin:</p>
        @else
            <p style="color: #a1a1aa; line-height: 1.6;">Terima kasih! Bukti transfer untuk pesanan di bawah ini telah kami terima dan saat ini sedang <strong>menunggu verifikasi Admin</strong>:</p>
        @endif

        <div style="background-color: #18181b; padding: 20px; border-radius: 10px; margin: 25px 0; border: 1px solid #3f3f46;">
            <p style="margin: 5px 0; color:#d4d4d8;"><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p style="margin: 5px 0; color:#d4d4d8;"><strong>Layanan:</strong> {{ $order->kategori_layanan }} ({{ strtoupper($order->jenjang) }})</p>
            <p style="margin: 5px 0; color:#d4d4d8;"><strong>Batas Waktu:</strong> {{ \Carbon\Carbon::parse($order->deadline)->format('d F Y') }}</p>
            
            @if($order->total_harga)
                <p style="margin: 5px 0; color:#eab308;"><strong>Total Tagihan:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
            @endif
            
            <p style="margin: 5px 0; color:#d4d4d8;"><strong>Status Saat Ini:</strong> <span style="color: #eab308; font-weight: bold; text-transform: uppercase;">{{ $order->status }}</span></p>
        </div>

        <p style="color: #a1a1aa; line-height: 1.6;">Anda dapat memantau perkembangan pesanan ini secara <i>real-time</i> melalui Dashboard akun Anda.</p>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/dashboard') }}" style="display: inline-block; background-color: #eab308; color: #18181b; padding: 12px 30px; text-decoration: none; font-weight: bold; border-radius: 8px;">Masuk ke Dashboard</a>
        </div>

        <hr style="border: 0; border-top: 1px solid #3f3f46; margin: 30px 0;">
        <p style="font-size: 12px; color: #71717a; text-align: center;">&copy; {{ date('Y') }} Joki Kilat. Email otomatis, mohon tidak membalas email ini.</p>
    </div>

</body>
</html>