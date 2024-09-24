<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        return view('data_jurusan',[
            'jurusan' => Jurusan::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan
        ]);

        Jurusan::create([
            // Tambahkan field sesuai kebutuhan
        ]);
        return redirect()->route('jurusan.index')->with('success', 'Data baru berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $user = Jurusan::findOrFail($id);
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            // Tambahkan validasi sesuai kebutuhan, misalnya untuk role
        ]);

        $user = Jurusan::findOrFail($id);
        $user->update([
            // Tambahkan field  yang akan diupdate
        ]);

        return redirect()->route('jurusan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = Jurusan::findOrFail($id);
        $user->delete();
        return redirect()->route('jurusan.index')->with('success', 'Data berhasil dihapus.');
    }
}
