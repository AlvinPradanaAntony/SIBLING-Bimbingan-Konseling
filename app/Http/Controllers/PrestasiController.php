<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function index()
    {
        return view('data_prestasi',[
            'prestasi' => Prestasi::all()
        ]);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan
        ]);

        Prestasi::create([
            // Tambahkan field sesuai kebutuhan
        ]);
        return redirect()->route('prestasi.index')->with('success', 'Data baru berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $user = Prestasi::findOrFail($id);
        return view('prestasi.edit', compact('prestasi'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan, misalnya untuk role
        ]);

        $user = Prestasi::findOrFail($id);
        $user->update([
            // Tambahkan field  yang akan diupdate
        ]);

        return redirect()->route('prestasi.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = Prestasi::findOrFail($id);
        $user->delete();
        return redirect()->route('prestasi.index')->with('success', 'Data berhasil dihapus.');
    }
}
