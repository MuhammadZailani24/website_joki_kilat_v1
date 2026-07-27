<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Tambahan agar VS Code mengenali Auth

class UserController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    // Mengupdate data dan role user (Ditambah 'string $id' agar VS Code tidak protes)
    public function update(Request $request, string $id)
    {
        $request->validate([
            'role' => 'required|in:user,admin,suspend'
        ]);

        $user = User::findOrFail($id);
        
        // Menggunakan Auth::id() menggantikan auth()->user()->id agar lebih clean
        if ($user->id === Auth::id() && $request->role !== 'admin') {
            return back()->with('error', 'Anda tidak bisa mengubah role akun Anda sendiri!');
        }

        $user->update([
            'role' => $request->role,
        ]);

        return back()->with('success', 'Status / Role pengguna berhasil diperbarui!');
    }

    // Menghapus user (Ditambah 'string $id')
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // Menggunakan Auth::id()
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus permanen dari sistem!');
    }
}