<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Imports\AssessmentImport;
use Maatwebsite\Excel\Facades\Excel;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        for ($i = 1; $i < count($rows); $i++) {
            // Skip baris kosong
            if (empty($rows[$i][0]) && empty($rows[$i][1])) {
                continue;
            }

            $question = trim($rows[$i][0]);
            $field = trim($rows[$i][1]);

            // Validasi sederhana (opsional)
            if (empty($question) || empty($field)) {
                return back()->with('error', "❌ Pertanyaan atau field kosong di baris " . ($i + 1));
            }

            DB::table('assessments')->insert([
                'question' => $question,
                'field' => $field,
            ]);
        }

        return back()->with('success', '✅ Template asesmen berhasil diimpor!');
    }

    public function downloadFormat()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Format Asesmen');

        // Header kolom
        $sheet->setCellValue('A1', 'Pertanyaan');
        $sheet->setCellValue('B1', 'Bidang');

        // Dropdown untuk Field dari baris 2 sampai 1000
        for ($row = 2; $row <= 1000; $row++) {
            $validation = $sheet->getCell('B' . $row)->getDataValidation();
            $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
            $validation->setAllowBlank(true);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setShowDropDown(true);
            $validation->setFormula1('"Pribadi,Sosial,Belajar,Karir"');
            $sheet->getCell('B' . $row)->setDataValidation($validation);
        }

        // Auto-size kolom agar rapi
        foreach (range('A', 'B') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Nama file
        $filename = 'format_import_asesmen.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }


    public function export()
    {
        // Mengambil semua data dari model Assessment
        $assessments = Assessment::all();

        // Buat file Excel
        $excelData = [];
        $excelData[] = ['ID', 'Pertanyaan', 'Bidang']; // Judul kolom

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
        $filename = 'export_asesmen.xlsx';

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
