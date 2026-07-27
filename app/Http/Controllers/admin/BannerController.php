<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('created_at', 'desc')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // Maks 5MB
        ]);

        $path = $request->file('gambar')->store('banners', 'public');

        // Matikan banner lama agar banner baru ini yang langsung aktif
        Banner::where('is_active', true)->update(['is_active' => false]);

        Banner::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $path,
            'is_active' => true, // Otomatis aktif
        ]);

        return back()->with('success', 'Banner baru berhasil diunggah dan diaktifkan!');
    }

    public function activate(string $id)
    {
        // Matikan semua banner dulu
        Banner::where('is_active', true)->update(['is_active' => false]);
        
        // Aktifkan banner yang dipilih
        $banner = Banner::findOrFail($id);
        $banner->update(['is_active' => true]);

        return back()->with('success', 'Banner berhasil diaktifkan ke halaman utama!');
    }

    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        
        // Hapus file fisiknya
        if (Storage::disk('public')->exists($banner->gambar)) {
            Storage::disk('public')->delete($banner->gambar);
        }
        
        $banner->delete();
        return back()->with('success', 'Banner berhasil dihapus permanen!');
    }
}