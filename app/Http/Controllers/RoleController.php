<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    // Menampilkan semua akses
    public function index()
    {
        return view('data_akses', [
            'roles' => Role::all(),
            'active' => 'role'
        ]);
    }

    // Menampilkan form untuk menambahkan akses
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = new Role();
        $role->name = $request->input('name');
        $role->guard_name ='web';
        $role->save();

        return redirect()->route('role.index')->with('success', 'Akses berhasil ditambahkan!');
    }

    // Menyimpan perubahan akses ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->guard_name ='web';
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
