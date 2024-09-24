<?php

namespace App\Http\Controllers;

use App\Models\Kasus;
use Illuminate\Http\Request;

class KasusController extends Controller
{
    public function index()
    {
        return view('data_kasus',[
            'kasus' => Kasus::all(),
            'active' => 'kasus'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan
        ]);

        Kasus::create([
            // Tambahkan field sesuai kebutuhan
        ]);
        return redirect()->route('kasus.index')->with('success', 'Data baru berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $user = Kasus::findOrFail($id);
        return view('kasus.edit', compact('kasus'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan, misalnya untuk role
        ]);

        $user = Kasus::findOrFail($id);
        $user->update([
            // Tambahkan field  yang akan diupdate
        ]);

        return redirect()->route('kasus.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = Kasus::findOrFail($id);
        $user->delete();
        return redirect()->route('kasus.index')->with('success', 'Data berhasil dihapus.');
    }
}
