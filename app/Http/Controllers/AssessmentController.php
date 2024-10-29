<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;

class AssessmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    // Menampilkan semua akses
    public function index()
    {
        return view('data_asesmen', [
            'assessments' => Assessment::all(),
            'active' => 'assessment'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'field' => 'required|string|max:255',
        ]);

        $assessment = new Assessment();
        $assessment->question = $request->input('question');
        $assessment->field = $request->input('field');
        $assessment->save();

        return redirect()->route('assessment.index')->with('success', 'Assessment berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'field' => 'required|string|max:255',
        ]);

        $assessment = Assessment::find($id);
        $assessment->question = $request->input('question');
        $assessment->field = $request->input('field');
        $assessment->save();

        return redirect()->route('assessment.index')->with('success', 'Assessment berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $assessment = Assessment::findOrFail($id);
        $assessment->delete();
        return redirect()->route('assessment.index')->with('success', 'Assessment berhasil dihapus!');
    }
}
