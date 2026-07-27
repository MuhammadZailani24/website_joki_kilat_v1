<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; 
use App\Mail\OrderNotification;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function create($jenjang)
    {
        $validJenjang = ['sd', 'smp', 'sma', 'kuliah', 'aplikasi'];
        if (!in_array(strtolower($jenjang), $validJenjang)) {
            abort(404);
        }

        if ($jenjang === 'aplikasi') {
            return view('order.app_create');
        }

        return view('order.create', compact('jenjang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenjang' => 'required|string',
            'kategori_layanan' => 'required|string|max:255',
            'judul_tugas' => 'required|string|max:255',
            'deskripsi_tugas' => 'required|string',
            'deadline' => 'required|date|after_or_equal:today', 
            
            'institusi' => 'nullable|string|max:255',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip,rar|max:5120',
            'catatan_tambahan' => 'nullable|string',
            'layanan_tambahan' => 'nullable|array',
            'fitur_aplikasi' => 'nullable|string',
            'referensi_desain' => 'nullable|string|max:255',
            'budget_project' => 'nullable|numeric',
        ]);

        $filePath = null;
        if ($request->hasFile('file_tugas')) {
            $filePath = $request->file('file_tugas')->store('tugas', 'public');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'jenjang' => $request->jenjang,
            'kategori_layanan' => $request->kategori_layanan,
            'institusi' => $request->institusi ?? 'Umum', 
            'judul_tugas' => $request->judul_tugas,
            'deskripsi_tugas' => $request->deskripsi_tugas,
            'file_tugas' => $filePath,
            'catatan_tambahan' => $request->catatan_tambahan,
            'layanan_tambahan' => $request->layanan_tambahan,
            'fitur_aplikasi' => $request->fitur_aplikasi,
            'referensi_desain' => $request->referensi_desain,
            'budget_project' => $request->budget_project,
            'deadline' => $request->deadline,
            'status' => 'Pending', 
        ]);

        // Notif Email ke Pelanggan
        try {
            Mail::to(Auth::user()->email)->send(new OrderNotification($order, 'baru'));
        } catch (\Exception $e) {}

        // Notif Email ke Admin (Pesanan Baru)
        try {
            Mail::to('admin@jokikilat.com')->send(new OrderNotification($order, 'admin_pesanan_baru'));
        } catch (\Exception $e) {}

        $pesanSukses = $request->jenjang === 'aplikasi' 
            ? 'Proposal Pembuatan Aplikasi berhasil dikirim! Cek email Anda untuk detail pesanan.' 
            : 'Pesanan berhasil dibuat! Cek email Anda untuk rincian tugas.';

        return redirect('/dashboard')->with('success', $pesanSukses);
    }

    public function show($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('order.show', compact('order'));
    }

    // FUNGSI PEMBAYARAN MANUAL
    public function payment($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($order->status !== 'Menunggu Pembayaran') {
            return redirect('/dashboard')->withErrors('Pesanan ini belum siap untuk dibayar atau sudah lunas.');
        }

        return view('order.payment', compact('order'));
    }

    public function processPayment(Request $request, $id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:3072', 
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('pembayaran', 'public');
            
            $order->update([
                'bukti_pembayaran' => $buktiPath,
                'status' => 'Menunggu Verifikasi' 
            ]);

            // Notif Email ke Pelanggan
            try {
                Mail::to(Auth::user()->email)->send(new OrderNotification($order, 'bayar'));
            } catch (\Exception $e) {}

            // Notif Email ke Admin
            try {
                Mail::to('admin@jokikilat.com')->send(new OrderNotification($order, 'admin_bukti_bayar'));
            } catch (\Exception $e) {}
        }

        return redirect('/dashboard')->with('success', 'Bukti pembayaran berhasil diunggah! Menunggu konfirmasi Admin.');
    }

    public function ajukanRevisi(Request $request, $id)
    {
        $request->validate([
            'catatan_revisi' => 'required|string'
        ]);

        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $order->update([
            'status' => 'Revisi',
            'catatan_revisi' => $request->catatan_revisi
        ]);

        try {
            Mail::to('admin@jokikilat.com')->send(new OrderNotification($order, 'admin_revisi'));
        } catch (\Exception $e) {}

        return back()->with('success', 'Pengajuan revisi berhasil dikirim ke Admin! Tim kami akan segera memperbaikinya.');
    }

    // FUNGSI CETAK INVOICE PDF DENGAN LOGO BASE64
    public function downloadInvoice($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Konversi logo ke Base64 agar 100% terbaca oleh DomPDF
        $logoPath = public_path('images/logo.png');
        $logoBase64 = null;
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }

        $pdf = Pdf::loadView('order.invoice', compact('order', 'logoBase64'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Invoice-JokiKilat-#' . $order->id . '.pdf');
    }
}