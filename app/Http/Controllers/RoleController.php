<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    // Menampilkan semua akses
    public function index()
    {
        return view('data_akses', [
            'roles' => Role::all(),
        ]);
    }

    // Menampilkan form untuk menambahkan akses
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
        ]);

        $role = new Role();
        $role->role_name = $request->input('role_name');
        $role->save();

        return redirect()->route('role.index')->with('success', 'Akses berhasil ditambahkan!');
    }

    // Menyimpan perubahan akses ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
        ]);

        $role = Role::findOrFail($id);
        $role->role_name = $request->input('role_name');
        $role->save();

        return redirect()->route('role.index', $role->id)->with('success', 'Akses berhasil diupdate!');
    }

    // Fungsi untuk menghapus akses
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        // Redirect atau menampilkan pesan sukses
        return redirect()->route('role.index')->with('success', 'Akses berhasil dihapus!');
    }
}
