<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function cekVoucher(Request $request)
    {
        $request->validate([
            'kode' => 'required|string'
        ]);

        $voucher = Voucher::where('kode', strtoupper($request->kode))
                          ->where('is_active', true)
                          ->first();

        if (!$voucher) {
            return response()->json(['status' => 'error', 'message' => 'Kode voucher tidak ditemukan atau tidak aktif.']);
        }

        if ($voucher->kuota <= 0) {
            return response()->json(['status' => 'error', 'message' => 'Kuota voucher ini sudah habis.']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Voucher berhasil digunakan!',
            'potongan' => $voucher->potongan
        ]);
    }
}