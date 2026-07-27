<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $jenis_notif; // Untuk membedakan email "Pesanan Baru" atau "Bukti Bayar"

    public function __construct(Order $order, $jenis_notif = 'baru')
    {
        $this->order = $order;
        $this->jenis_notif = $jenis_notif;
    }

    public function envelope(): Envelope
    {
        // Judul email akan berubah tergantung aktivitas user
        $judul = $this->jenis_notif == 'baru' 
            ? '⚡ Pesanan Joki Kilat Berhasil Dibuat!' 
            : '✅ Bukti Pembayaran Sedang Diverifikasi';

        return new Envelope(
            subject: $judul,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order_notification', // Kita akan buat file tampilannya setelah ini
        );
    }
}