<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Major;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    
    // Menampilkan semua kelas
    public function index()
    {
        return view('data_kelas', [
            'majors' => Major::all(),
            'classes' => Classes::with('major')->get(),
            'active' => 'class'
        ]);
    }

    // Menampilkan form untuk menambahkan kelas
    public function store(Request $request)
    {
        $request->validate([
            'class_level' => 'required|string|max:255',
            'major_id' => 'required|string|max:255',
            'classroom' => 'required|string|max:255',
        ]);

        $class = new Classes();
        $class->class_level = $request->input('class_level');
        $class->major_id = $request->input('major_id');
        $class->classroom = $request->input('classroom');
        $class->save();

        return redirect()->route('class.index')->with('success', 'Kelas berhasil ditambahkan!');
    }

    // Menyimpan perubahan kelas ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'class_level' => 'required|string|max:255',
            'major_id' => 'required|string|max:255',
            'classroom' => 'required|string|max:255',
        ]);

        $class = Classes::findOrFail($id);
        $class->class_level = $request->input('class_level');
        $class->major_id = $request->input('major_id');
        $class->classroom = $request->input('classroom');
        $class->save();

        return redirect()->route('class.index', $class->id)->with('success', 'Kelas berhasil diupdate!');
    }

    // Fungsi untuk menghapus kelas
    public function destroy($id)
    {
        $class = Classes::findOrFail($id);
        $class->delete();

        return redirect()->route('class.index')->with('success', 'Kelas berhasil dihapus!');
    }
}
