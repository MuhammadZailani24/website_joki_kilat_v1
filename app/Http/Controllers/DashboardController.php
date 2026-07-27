<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; 

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua data pesanan milik user yang sedang login
        $pesanan = Order::where('user_id', Auth::id())->latest()->get();

        // Hitung Statistik Pesanan
        $stat_total = $pesanan->count();
        $stat_pending = $pesanan->whereIn('status', ['Pending', 'Menunggu Pembayaran', 'Menunggu Verifikasi'])->count();
        $stat_proses = $pesanan->where('status', 'Proses')->count();
        $stat_selesai = $pesanan->where('status', 'Selesai')->count();

        return view('dashboard', compact('pesanan', 'stat_total', 'stat_pending', 'stat_proses', 'stat_selesai'));
    }
}