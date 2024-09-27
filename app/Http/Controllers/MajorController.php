<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Major;

class MajorController extends Controller
{
    // Menampilkan semua jurusan
    public function index()
    {
        return view('data_jurusan', [
            'majors' => Major::all(),
        ]);
    }

    // Menampilkan form untuk menambahkan jurusan
    public function store(Request $request)
    {
        $request->validate([
            'major_name' => 'required|string|max:255',
        ]);

        $major = new Major();
        $major->major_name = $request->input('major_name');
        $major->save();

        return redirect()->route('major.index')->with('success', 'Jurusan berhasil ditambahkan!');
    }

    // Menyimpan perubahan jurusan ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'major_name' => 'required|string|max:255',
        ]);

        $major = Major::findOrFail($id);
        $major->major_name = $request->input('major_name');
        $major->save();

        return redirect()->route('major.index', $major->id)->with('success', 'Jurusan berhasil diupdate!');
    }

    // Fungsi untuk menghapus jurusan
    public function destroy($id)
    {
        $major = Major::findOrFail($id);
        $major->delete();

        // Redirect atau menampilkan pesan sukses
        return redirect()->route('major.index')->with('success', 'Jurusan berhasil dihapus!');
    }
}
