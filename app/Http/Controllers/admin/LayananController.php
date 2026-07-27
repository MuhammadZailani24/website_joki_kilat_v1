<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;

class LayananController extends Controller
{
    // Menampilkan daftar layanan
    public function index()
    {
        $layanans = Layanan::orderBy('kategori', 'asc')->get();
        return view('admin.layanans.index', compact('layanans'));
    }

    // Menyimpan layanan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'kategori' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        Layanan::create($request->all());

        return back()->with('success', 'Layanan baru berhasil ditambahkan!');
    }

    // Mengupdate data layanan (Gunakan string $id agar VS Code tenang)
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'kategori' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        $layanan = Layanan::findOrFail($id);
        $layanan->update($request->all());

        return back()->with('success', 'Data layanan dan harga berhasil diperbarui!');
    }

    // Menghapus layanan
    public function destroy(string $id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return back()->with('success', 'Layanan berhasil dihapus dari sistem!');
    }
}