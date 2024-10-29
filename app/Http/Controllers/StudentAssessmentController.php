<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentAssessment;
use App\Models\Student;
use App\Models\Assessment;

class StudentAssessmentController extends Controller
{
    public function index()
    {
        return view('data_asesmen_siswa', [
            'student_assessments' => StudentAssessment::with(['student', 'assessment'])->get(),
            'students' => Student::with(['class', 'status'])->get(),
            'assessments' => Assessment::all(),
            'active' => 'student_assessment'
        ]);
    }

    public function create()
    {
        return view('student_assessment.create', [
            'active' => 'student_assessment'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|max:255',
            'answers' => 'required|array', // Pastikan ini adalah 'answers' untuk input
            'answers.*' => 'in:0,1', // Validasi huruf kapital
        ]);

        // Loop untuk menyimpan setiap jawaban
        foreach ($validated['answers'] as $assessment_id => $answer) {
            $student_assessment = new StudentAssessment();
            $student_assessment->student_id = $validated['student_id'];
            $student_assessment->assessment_id = $assessment_id;
            $student_assessment->answer = $answer; // Menggunakan huruf kapital sesuai enum
            $student_assessment->save();
        }

        return redirect()->route('student_assessment.index')->with('success', 'Data Berhasil');
    }

    public function edit($id)
    {
        $student_assessment = StudentAssessment::find($id);
        return view('student_assessment.edit', [
            'active' => 'student_assessment',
            'student_assessment' => $student_assessment
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'answer' => 'required|in:0,1',
        ]);
        $student_assessment = StudentAssessment::findOrFail($id);
        $student_assessment->update([
            'answer' => $validated['answer']
        ]);
        return redirect()->route('student_assessment.index')->with('success', 'Jawaban berhasil diperbarui');
    }



    public function destroy($id)
    {
        $student_assessment = StudentAssessment::find($id);
        $student_assessment->delete();
        return redirect()->route('student_assessment.index')->with('success', 'Data Berhasil');
    }
}
