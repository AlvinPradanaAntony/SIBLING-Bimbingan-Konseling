<?php

namespace App\Http\Controllers;

use App\Models\Karir;
use Illuminate\Http\Request;

class KarirController extends Controller
{
    public function index()
    {
        return view('data_karir',[
            'karir' => Karir::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan
        ]);

        Karir::create([
            // Tambahkan field sesuai kebutuhan
        ]);
        return redirect()->route('karir.index')->with('success', 'Data baru berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $user = Karir::findOrFail($id);
        return view('karir.edit', compact('karir'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan, misalnya untuk role
        ]);

        $user = Karir::findOrFail($id);
        $user->update([
            // Tambahkan field  yang akan diupdate
        ]);

        return redirect()->route('karir.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = Karir::findOrFail($id);
        $user->delete();
        return redirect()->route('karir.index')->with('success', 'Data berhasil dihapus.');
    }
}
