<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UsersController extends Controller
{
        public function index()
        {
            return view('autentifikasi', [
                'users' => User::with('role')->get(),
                'roles' => Role::all()
            ]);
        }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Buat user baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            // Tambahkan field lainnya sesuai kebutuhan
        ]);

        // Redirect ke halaman daftar pengguna dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Tampilkan form edit dengan data user
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            // Tambahkan validasi lain sesuai kebutuhan, misalnya untuk role
        ]);

        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Perbarui data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            // Tambahkan field lain yang akan diupdate
        ]);

        // Redirect ke halaman yang diinginkan dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Hapus user
        $user->delete();

        // Redirect ke halaman users dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
