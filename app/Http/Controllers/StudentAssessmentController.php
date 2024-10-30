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

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'answers' => 'required|array',
        ]);

        foreach ($validated['answers'] as $assessmentId => $answer) {
            // Update atau simpan jawaban siswa
            StudentAssessment::updateOrCreate(
                ['student_id' => $validated['student_id'], 'assessment_id' => $assessmentId],
                ['answer' => $answer]
            );
        }
        return redirect()->route('student_assessment.index')->with('success', 'Jawaban berhasil diperbarui');
    }



    public function destroy($id)
    {
        StudentAssessment::where('student_id', $id)->delete();
        return redirect()->route('student_assessment.index')->with('success', 'Data Berhasil');
    }
}
