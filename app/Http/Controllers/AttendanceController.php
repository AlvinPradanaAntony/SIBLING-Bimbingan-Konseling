<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\User;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('data_absensi', [
            'attendances' => Attendance::with(['student', 'user'])->get(),
            'users' => User::all(),
            'students' => Student::all(),
            'active' => 'attendance'
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|string|max:255',
            'presence_status' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'student_id' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
        ]);

        $attendance = new Attendance();
        $attendance->date = $request->input('date');
        $attendance->presence_status = $request->input('presence_status');
        $attendance->description = $request->input('description');
        $attendance->student_id = $request->input('student_id');
        $attendance->user_id = $request->input('user_id');
        $attendance->save();

        return redirect()->route('attendance.index')->with('success', 'Jurusan berhasil ditambahkan!');
    }

    // Menyimpan perubahan jurusan ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|string|max:255',
            'presence_status' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'student_id' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
        ]);

        $attendance = Attendance::findOrFail($id);
        $attendance->date = $request->input('date');
        $attendance->presence_status = $request->input('presence_status');
        $attendance->description = $request->input('description');
        $attendance->student_id = $request->input('student_id');
        $attendance->user_id = $request->input('user_id');
        $attendance->save();

        return redirect()->route('attendance.index', $attendance->id)->with('success', 'Jurusan berhasil diupdate!');
    }

    // Fungsi untuk menghapus jurusan
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        // Redirect atau menampilkan pesan sukses
        return redirect()->route('attendance.index')->with('success', 'Jurusan berhasil dihapus!');
    }
}
