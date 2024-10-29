<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Status;
use App\Models\Classes;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        return view('data_siswa', [
            'students' => Student::with(['class.major', 'status'])->get(),
            'classes' => Classes::all(),
            'statuses' => Status::all(),
            'active' => 'student'
        ]);
    }

    public function create(){
        return view('student.create', [
            // 'students' => Student::with(['class', 'status'])->get(),
            'active' => 'student',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'religion' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'admission_date' => 'required|date',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone_number' => 'required|string|max:255',
            'class_id' => 'required|string|max:255',
            'status_id' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('student_photos', 'public');
            $filename = basename($path);
        }

        $student = new Student();
        $student->nisn = $request->input('nisn');
        $student->name = $request->input('name');
        $student->gender = $request->input('gender');
        $student->place_of_birth = $request->input('place_of_birth');
        $student->date_of_birth = $request->input('date_of_birth');
        $student->religion = $request->input('religion');
        $student->phone_number = $request->input('phone_number');
        $student->address = $request->input('address');
        $student->photo = $filename;
        $student->admission_date = $request->input('admission_date');
        $student->guardian_name = $request->input('guardian_name');
        $student->guardian_phone_number = $request->input('guardian_phone_number');
        $student->class_id = $request->input('class_id');
        $student->status_id = $request->input('status_id');
        $student->email = $request->input('email');
        $student->save();
        return redirect()->route('student.index')->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nisn' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'religion' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            // 'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'admission_date' => 'required|date',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone_number' => 'required|string|max:255',
            'class_id' => 'required|string|max:255',
            'status_id' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $student = Student::findOrFail($id);
        
        $student->nisn = $request->input('nisn');
        $student->name = $request->input('name');
        $student->gender = $request->input('gender');
        $student->place_of_birth = $request->input('place_of_birth');
        $student->date_of_birth = $request->input('date_of_birth');
        $student->religion = $request->input('religion');
        $student->phone_number = $request->input('phone_number');
        $student->address = $request->input('address');
        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete('student_photos/' . $student->photo);
            }
            $file = $request->file('photo');
            $path = $file->store('student_photos', 'public');
            $student->photo = basename($path);
        }
        $student->admission_date = $request->input('admission_date');
        $student->guardian_name = $request->input('guardian_name');
        $student->guardian_phone_number = $request->input('guardian_phone_number');
        $student->class_id = $request->input('class_id');
        $student->status_id = $request->input('status_id');
        $student->email = $request->input('email');
        $student->save();

        return redirect()->route('student.index')->with('success', 'Data siswa berhasil diubah');
    }

    public function destroy($id){
        $student = Student::find($id);
        $student->delete();
        return redirect()->route('student.index')->with('success', 'Siswa berhasil dihapus!');
    }
}
