<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function fetchMessages($order_id)
    {
        $order = Order::where('id', $order_id)->where('user_id', Auth::id())->firstOrFail();
        $messages = Message::with('user')->where('order_id', $order->id)->orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }

    public function sendMessage(Request $request, $order_id)
    {
        $order = Order::where('id', $order_id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'pesan' => 'nullable|string',
            'lampiran' => 'nullable|file|max:5120',
        ]);

        if (!$request->pesan && !$request->hasFile('lampiran')) {
            return response()->json(['error' => 'Pesan tidak boleh kosong'], 400);
        }

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('chat_files', 'public');
        }

        // 1. Simpan Pesan dari User
        $message = Message::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'pesan' => $request->pesan,
            'lampiran' => $lampiranPath,
        ]);

        // ==========================================
        // FITUR BARU: AI AUTO-REPLY TAHAN BANTING
        // ==========================================
        
        $admin = User::where('role', 'admin')->first();
        $botId = $admin ? $admin->id : Auth::id(); 

        if ($request->pesan) {
            try {
                $apiKey = trim(env('GEMINI_API_KEY'));
                $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

                $prompt = "Kamu adalah asisten customer service dari aplikasi 'Joki Kilat'. 
                           Tugasmu merespons pesan pelanggan berikut dengan ramah dan sangat singkat (maksimal 2 kalimat). 
                           Jangan memberi janji soal harga. Pesan Pelanggan: " . $request->pesan;

                // REVISI: Tambahkan fitur retry(3 kali coba, jeda 2 detik) dan naikkan timeout ke 30 detik
                $response = Http::withoutVerifying()
                    ->retry(3, 2000, function ($exception, $request) {
                        // Hanya retry jika error timeout atau server error (500/503)
                        return $exception instanceof \Illuminate\Http\Client\ConnectionException ||
                               ($exception instanceof \Illuminate\Http\Client\RequestException && $exception->response->serverError());
                    })
                    ->timeout(30) 
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post($url, [
                        'contents' => [['parts' => [['text' => $prompt]]]]
                    ]);

                if ($response->successful()) {
                    $aiReply = $response->json()['candidates'][0]['content']['parts'][0]['text'];

                    Message::create([
                        'order_id' => $order->id,
                        'user_id' => $botId,
                        'pesan' => "🤖 [AI Asisten] " . trim($aiReply),
                    ]);
                } else {
                    Log::error('Gemini API Error: ' . $response->body());
                    // Fallback jika API Gagal
                    Message::create([
                        'order_id' => $order->id,
                        'user_id' => $botId,
                        'pesan' => "🤖 [AI Asisten] Maaf, server AI kami sedang sangat sibuk. Mohon tinggalkan pesan Anda, Admin manusia kami akan segera membalas!",
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Chatbot Error: ' . $e->getMessage());
                // Fallback jika Timeout/Putus Koneksi
                Message::create([
                    'order_id' => $order->id,
                    'user_id' => $botId,
                    'pesan' => "🤖 [AI Asisten] Sistem merespons terlalu lama. Tim Admin kami telah menerima notifikasi dan akan membalas pesan Anda sebentar lagi.",
                ]);
            }
        } elseif ($request->hasFile('lampiran') && !$request->pesan) {
             Message::create([
                'order_id' => $order->id,
                'user_id' => $botId,
                'pesan' => "🤖 [AI Asisten] File lampiran Anda telah diterima. Tim admin manusia kami akan segera mengeceknya!",
            ]);
        }

        return response()->json($message->load('user'));
    }
}