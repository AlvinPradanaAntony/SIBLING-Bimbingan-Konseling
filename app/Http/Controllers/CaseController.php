<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cases;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;

class CaseController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    
    public function index(){
        return view('data_kasus', [
            'cases' => Cases::with(['student', 'user'])->get(),
            'students' => Student::all(),
            'users' => User::all(),
            'active' => 'case'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'case_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'resolution' => 'required|string|max:255',
            'case_point' => 'required|string|max:255',
            'date' => 'required|date',
            'student_id' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
        ]);

        $case = new Cases();
        $case->case_name = $request->input('case_name');
        $case->description = $request->input('description');
        $case->resolution = $request->input('resolution');
        $case->case_point = $request->input('case_point');
        $case->date = Carbon::parse($request->input('date'))->format('Y-m-d H:i:s');
        $case->student_id = $request->input('student_id');
        $case->user_id = $request->input('user_id');
        $case->save();

        return redirect()->route('case.index')->with('success', 'Kasus berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'case_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'resolution' => 'required|string|max:255',
            'case_point' => 'required|string|max:255',
            'date' => 'required|date',
            'student_id' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
        ]);

        $case = Cases::findOrFail($id);
        $case->case_name = $request->input('case_name');
        $case->description = $request->input('description');
        $case->resolution = $request->input('resolution');
        $case->case_point = $request->input('case_point');
        $case->date = Carbon::parse($request->input('date'))->format('Y-m-d H:i:s');
        $case->student_id = $request->input('student_id');
        $case->user_id = $request->input('user_id');
        $case->save();

        return redirect()->route('case.index')->with('success', 'Kasus berhasil diupdate!');
    }

    public function destroy($id)
    {
        $case = Cases::findOrFail($id);
        $case->delete();    

        return redirect()->route('case.index')->with('success', 'Kasus berhasil dihapus!');
    }
}
