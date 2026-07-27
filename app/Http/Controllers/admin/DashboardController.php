<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil statistik utama [cite: 239-245]
        $total_user = User::where('role', 'user')->count();
        $total_order = Order::count();
        $order_aktif = Order::whereIn('status', ['Pending', 'Menunggu Pembayaran', 'Menunggu Verifikasi', 'Proses', 'Revisi'])->count();
        $order_selesai = Order::where('status', 'Selesai')->count();
        $pendapatan = Order::where('status', 'Selesai')->sum('total_harga') ?? 0;

        return view('admin.dashboard', compact(
            'total_user', 
            'total_order', 
            'order_aktif', 
            'order_selesai', 
            'pendapatan'
        ));
    }
}