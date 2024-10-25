<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\Achievement;
use App\Models\Student;

class AchievementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        return view('data_prestasi', [
            'achievements' => Achievement::with(['student'])->get(),
            'students' => Student::all(),
            'active' => 'achievement'
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'ranking' => 'required|string|max:255',
            'achievements_name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'description' => 'required',
            'type' => 'required|string|max:255',
            'date' => 'required|date',
            'recognition' => 'required|string|max:255',
            'certificate' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'student_id' => 'required|string|max:255',
        ]);

        if ($request->hasFile('certificate')) {
            $file = $request->file('certificate');
            $path = $file->store('certificates', 'public');
            $filename = basename($path);
        }

        $achievement = new Achievement();
        $achievement->ranking = $request->input('ranking');
        $achievement->achievements_name = $request->input('achievements_name');
        $achievement->level = $request->input('level');
        $achievement->description = $request->input('description');
        $achievement->type = $request->input('type');
        $achievement->date = $request->input('date');
        $achievement->recognition = $request->input('recognition');
        $achievement->certificate = $filename;
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
            'description' => 'required',
            'type' => 'required|string|max:255',
            'date' => 'required|date',
            'recognition' => 'required|string|max:255',
            'certificate' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'student_id' => 'required|string|max:255',
        ]);

        if ($request->hasFile('certificate')) {
            $file = $request->file('certificate');
            $path = $file->store('certificates', 'public');
            $filename = basename($path);
        }

        $achievement = Achievement::findOrFail($id);
        $achievement->ranking = $request->input('ranking');
        $achievement->achievements_name = $request->input('achievements_name');
        $achievement->level = $request->input('level');
        $achievement->description = $request->input('description');
        $achievement->type = $request->input('type');
        $achievement->date = $request->input('date');
        $achievement->recognition = $request->input('recognition');
        // $achievement->certificate = $filename;
        if ($request->hasFile('certificate')) {
            // Hapus sertifikat lama jika ada
            if ($achievement->certificate) {
                Storage::disk('public')->delete('certificates/' . $achievement->certificate);
            }

            // Simpan sertifikat baru
            $file = $request->file('certificate');
            $path = $file->store('certificates', 'public');
            $achievement->certificate = basename($path); // Menyimpan nama file pamflet baru
        }
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
