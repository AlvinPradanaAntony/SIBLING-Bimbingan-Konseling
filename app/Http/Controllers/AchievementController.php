<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achievement;
use App\Models\Student;

class AchievementController extends Controller
{
    public function index()
    {
        return view('data_prestasi', [
            'achievements' => Achievement::with(['student'])->get(),
            'students' => Student::all()
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'ranking' => 'required|string|max:255',
            'achievements_name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'date' => 'required|string|max:255',
            'recognition' => 'required|string|max:255',
            'certificate' => 'required|string|max:255',
            'student_id' => 'required|string|max:255',
        ]);

        $achievement = new Achievement();
        $achievement->ranking = $request->input('ranking');
        $achievement->achievements_name = $request->input('achievements_name');
        $achievement->level = $request->input('level');
        $achievement->description = $request->input('description');
        $achievement->type = $request->input('type');
        $achievement->date = $request->input('date');
        $achievement->recognition = $request->input('recognition');
        $achievement->certificate = $request->input('certificate');
        $achievement->student_id = $request->input('student_id');
        $achievement->save();

        return redirect()->route('achievement.index')->with('success', 'Jurusan berhasil ditambahkan!');
    }

    // Menyimpan perubahan jurusan ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'ranking' => 'required|string|max:255',
            'achievements_name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'date' => 'required|string|max:255',
            'recognition' => 'required|string|max:255',
            'certificate' => 'required|string|max:255',
            'student_id' => 'required|string|max:255',
        ]);

        $achievement = Achievement::findOrFail($id);
        $achievement->ranking = $request->input('ranking');
        $achievement->achievements_name = $request->input('achievements_name');
        $achievement->level = $request->input('level');
        $achievement->description = $request->input('description');
        $achievement->type = $request->input('type');
        $achievement->date = $request->input('date');
        $achievement->recognition = $request->input('recognition');
        $achievement->certificate = $request->input('certificate');
        $achievement->student_id = $request->input('student_id');
        $achievement->save();

        return redirect()->route('achievement.index', $achievement->id)->with('success', 'Jurusan berhasil diupdate!');
    }

    // Fungsi untuk menghapus jurusan
    public function destroy($id)
    {
        $achievement = Achievement::findOrFail($id);
        $achievement->delete();

        // Redirect atau menampilkan pesan sukses
        return redirect()->route('achievement.index')->with('success', 'Jurusan berhasil dihapus!');
    }
}
