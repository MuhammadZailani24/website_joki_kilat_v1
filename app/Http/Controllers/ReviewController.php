<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $order_id)
    {
        $order = Order::where('id', $order_id)->where('user_id', Auth::id())->firstOrFail();

        // Pastikan tugas sudah selesai dan belum pernah di-review
        if ($order->status !== 'Selesai' || $order->review) {
            return back()->withErrors('Tugas belum selesai atau Anda sudah memberikan ulasan.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
            'screenshot' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ]);

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('reviews', 'public');
        }

        Review::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'screenshot' => $screenshotPath,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan dan rating Anda telah berhasil disimpan.');
    }
}