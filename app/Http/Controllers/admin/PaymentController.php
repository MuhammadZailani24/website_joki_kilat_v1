<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    // Menampilkan riwayat pembayaran & transaksi
    public function index()
    {
        // Hanya mengambil order yang minimal sudah upload bukti bayar atau sudah lunas/proses
        $payments = Order::with('user')
            ->whereIn('status', ['Menunggu Verifikasi', 'Proses', 'Revisi', 'Selesai'])
            ->orderBy('updated_at', 'desc')
            ->get();
            
        return view('admin.payments.index', compact('payments'));
    }

    // Menampilkan & Cetak Invoice
    public function invoice($id)
    {
        $order = Order::with('user')->findOrFail($id);
        return view('admin.payments.invoice', compact('order'));
    }
}