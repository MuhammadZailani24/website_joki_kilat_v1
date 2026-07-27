<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function tandaiDibaca()
    {
        // Ubah semua notifikasi milik user yang login menjadi "sudah dibaca"
        Notifikasi::where('user_id', Auth::id())
                  ->where('is_read', false)
                  ->update(['is_read' => true]);

        return response()->json(['status' => 'success']);
    }
}