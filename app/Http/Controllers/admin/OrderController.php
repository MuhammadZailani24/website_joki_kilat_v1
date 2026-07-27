<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http; // Modul untuk memanggil API Fonnte

class OrderController extends Controller
{
    // Menampilkan daftar pesanan
    public function index(Request $request)
    {
        $query = Order::with('user')->orderBy('created_at', 'desc');

        if ($request->has('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        $orders = $query->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Menampilkan detail 1 pesanan
    public function show($id)
    {
        $order = Order::with('user')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Mengupdate status pesanan DAN total harga
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'total_harga' => 'required|numeric'
        ]);

        $order = Order::findOrFail($id);
        
        $order->update([
            'status' => $request->status,
            'total_harga' => $request->total_harga
        ]);

        // ==========================================
        // FITUR BARU: TEMBAK NOTIF WA KETIKA STATUS BERUBAH
        // ==========================================
        if ($order->user && $order->user->whatsapp) {
            $pesan = "Halo *{$order->user->name}*! 👋\n\nStatus pesanan Joki Kilat kamu (Order ID: *#{$order->id}*) telah diperbarui menjadi: *{$order->status}*.\n\nSilakan cek detail tagihan dan pesananmu di website kami ya! ⚡";
            
            $this->kirimWhatsApp($order->user->whatsapp, $pesan);
        }

        return back()->with('success', 'Tagihan dan Status pesanan berhasil diperbarui!');
    }

    // Mengunggah file hasil pengerjaan
    public function uploadHasil(Request $request, $id)
    {
        $request->validate([
            'file_hasil' => 'required|file|max:10240', // Maks 10MB
        ]);

        $order = Order::findOrFail($id);

        if ($order->file_hasil && Storage::disk('public')->exists($order->file_hasil)) {
            Storage::disk('public')->delete($order->file_hasil);
        }

        $path = $request->file('file_hasil')->store('hasil_tugas', 'public');
        
        $order->update([
            'file_hasil' => $path,
            'status' => 'Selesai'
        ]);

        // ==========================================
        // FITUR BARU: TEMBAK NOTIF WA KETIKA TUGAS SELESAI
        // ==========================================
        if ($order->user && $order->user->whatsapp) {
            $pesan = "🎉 *HORE! TUGASMU SELESAI!* 🎉\n\nHalo *{$order->user->name}*, tugas kamu (Order ID: *#{$order->id}*) sudah selesai dikerjakan dan file hasilnya telah diunggah oleh tim kami!\n\nSilakan login ke Joki Kilat untuk mengunduh hasilnya. Jangan lupa berikan ulasan bintang 5 ya! ⭐";
            
            $this->kirimWhatsApp($order->user->whatsapp, $pesan);
        }

        return back()->with('success', 'File hasil berhasil diunggah! Status otomatis menjadi Selesai.');
    }


    // ==========================================
    // MESIN PENGIRIM WHATSAPP VIA FONNTE
    // ==========================================
    private function kirimWhatsApp($targetNomor, $isiPesan)
    {
        $token = env('FONNTE_TOKEN');
        
        // Jika token kosong atau nomor HP tidak ada, batalkan pengiriman agar web tidak error
        if (!$token || !$targetNomor) {
            return;
        }

        try {
            Http::withHeaders([
                'Authorization' => $token,
            ])->withoutVerifying()->post('https://api.fonnte.com/send', [
                'target' => $targetNomor,
                'message' => $isiPesan,
                'countryCode' => '62', // Otomatis mengubah angka depan 0 menjadi 62 standar Indonesia
            ]);
        } catch (\Exception $e) {
            // Jika API WA sedang down atau gagal, abaikan saja agar user/admin tidak melihat pesan error
        }
    }
}