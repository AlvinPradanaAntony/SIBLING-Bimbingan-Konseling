<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Imports\AssessmentImport;
use Maatwebsite\Excel\Facades\Excel;

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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new AssessmentImport, $request->file('file'));

        return redirect()->route('assessment.index')->with('success', 'Data asesmen berhasil diimpor');
    }

    public function export()
    {
        // Mengambil semua data dari model Assessment
        $assessments = Assessment::all();

        // Buat file Excel
        $excelData = [];
        $excelData[] = ['ID', 'Question', 'Field']; // Judul kolom

        foreach ($assessments as $assessment) {
            $excelData[] = [
                $assessment->id,      // Jika Anda ingin menyertakan ID
                $assessment->question,
                $assessment->field,
            ];
        }

        // Menggunakan PhpSpreadsheet untuk membuat file Excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menyisipkan data ke dalam sheet
        foreach ($excelData as $rowIndex => $row) {
            foreach ($row as $colIndex => $cellValue) {
                $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 1, $cellValue);
            }
        }

        // Mengatur response untuk mengunduh file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'assessments.xlsx';

        // Mengembalikan response download
        return response()->stream(function() use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
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
