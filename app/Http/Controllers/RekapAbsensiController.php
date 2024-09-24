<?php

namespace App\Http\Controllers;

use App\Models\RekapAbsensi;
use Illuminate\Http\Request;

class RekapAbsensiController extends Controller
{
    public function index()
    {
        return view('data_absensi',[
            'absensi' => RekapAbsensi::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan
        ]);

        RekapAbsensi::create([
            // Tambahkan field sesuai kebutuhan
        ]);
        return redirect()->route('absensi.index')->with('success', 'Data baru berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $user = RekapAbsensi::findOrFail($id);
        return view('absensi.edit', compact('absensi'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan, misalnya untuk role
        ]);

        $user = RekapAbsensi::findOrFail($id);
        $user->update([
            // Tambahkan field  yang akan diupdate
        ]);

        return redirect()->route('absensi.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = RekapAbsensi::findOrFail($id);
        $user->delete();
        return redirect()->route('absensi.index')->with('success', 'Data berhasil dihapus.');
    }
}
