<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function index()
    {
        return view('data_bimbingan',[
            'bimbingan' => Bimbingan::all(),
            'active' => 'bimbingan'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan
        ]);

        Bimbingan::create([
            // Tambahkan field sesuai kebutuhan
        ]);
        return redirect()->route('bimbingan.index')->with('success', 'Data baru berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $user = Bimbingan::findOrFail($id);
        return view('bimbingan.edit', compact('bimbingan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan, misalnya untuk role
        ]);

        $user = Bimbingan::findOrFail($id);
        $user->update([
            // Tambahkan field  yang akan diupdate
        ]);

        return redirect()->route('bimbingan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = Bimbingan::findOrFail($id);
        $user->delete();
        return redirect()->route('bimbingan.index')->with('success', 'Data berhasil dihapus.');
    }
}
