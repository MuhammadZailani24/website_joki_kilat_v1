<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    // Menampilkan daftar testimoni
    public function index()
    {
        // Mengambil review beserta data user-nya
        $reviews = Review::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    // Mengubah status persetujuan (Approve / Sembunyikan)
    public function approve(string $id)
    {
        $review = Review::findOrFail($id);
        
        // Membalik status (jika true jadi false, jika false jadi true)
        $review->update([
            'is_approved' => !$review->is_approved
        ]);

        $pesan = $review->is_approved ? 'ditampilkan di Landing Page' : 'disembunyikan dari Landing Page';
        return back()->with('success', 'Testimoni berhasil ' . $pesan . '!');
    }

    // Menghapus testimoni
    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Testimoni berhasil dihapus permanen!');
    }
}