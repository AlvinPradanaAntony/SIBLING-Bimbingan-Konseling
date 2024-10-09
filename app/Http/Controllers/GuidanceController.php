<?php

namespace App\Http\Controllers;

use App\Models\Guidance;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class GuidanceController extends Controller
{
    public function index()
    {
        return view('data_bimbingan', [
            'guidances' => Guidance::with(['student', 'user'])->get(),
            'users' => User::all(),
            'students' => Student::all(),
            'active' => 'guidance'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'topics' => 'required|string|max:255',
            'notes' => 'required|string|max:255',
            'date' => 'required|string|max:255',
            'student_id' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
        ]);

        $guidance = new Guidance();
        $guidance->topics = $request->input('topics');
        $guidance->notes = $request->input('notes');
        $guidance->date = $request->input('date');
        $guidance->student_id = $request->input('student_id');
        $guidance->user_id = $request->input('user_id');
        $guidance->save();

        return redirect()->route('guidance.index')->with('success', 'Jurusan berhasil ditambahkan!');
    }

    // Menyimpan perubahan jurusan ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'topics' => 'required|string|max:255',
            'notes' => 'required|string|max:255',
            'date' => 'required|string|max:255',
            'student_id' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
        ]);

        $guidance = Guidance::findOrFail($id);
        $guidance->topics = $request->input('topics');
        $guidance->notes = $request->input('notes');
        $guidance->date = $request->input('date');
        $guidance->student_id = $request->input('student_id');
        $guidance->user_id = $request->input('user_id');
        $guidance->save();

        return redirect()->route('guidance.index', $guidance->id)->with('success', 'Jurusan berhasil diupdate!');
    }

    // Fungsi untuk menghapus jurusan
    public function destroy($id)
    {
        $guidance = Guidance::findOrFail($id);
        $guidance->delete();

        // Redirect atau menampilkan pesan sukses
        return redirect()->route('guidance.index')->with('success', 'Jurusan berhasil dihapus!');
    }
}
