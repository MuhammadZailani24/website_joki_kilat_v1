<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan dan tahun, default ke bulan ini
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $reports = Order::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->where('status', 'Selesai')
            ->get();

        $total_pendapatan = $reports->sum('total_harga');

        return view('admin.reports.index', compact('reports', 'total_pendapatan', 'bulan', 'tahun'));
    }
}