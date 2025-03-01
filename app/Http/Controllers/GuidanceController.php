<?php

namespace App\Http\Controllers;

use App\Models\Guidance;
use App\Models\Student;
use App\Models\User;
use App\Models\Classes;
use App\Models\Major;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Imports\GuidanceImport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class GuidanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    
    public function index(Request $request)
    {
        $selectedMonth = $request->input('month', now()->format('m'));
        $selectedYear = $request->input('year', now()->format('Y'));
        $selectedClass = $request->input('class'); // Ambil input kelas
        
        $dates = [];
        $startDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1);
        $endDate = $startDate->copy()->endOfMonth();

        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $dates[] = [
                'date' => $date->format('Y-m-d'),
                'isWeekend' => $date->isWeekend()
            ];
        }

        $guidances = Guidance::with(['student', 'user'])
            ->whereYear('date', $selectedYear)
            ->whereMonth('date', $selectedMonth)
            ->get();
        
        $classes = Classes::all();
        $majors = Major::all();
        $users = User::all();
        $years = range(now()->year - 5, now()->year);
        
        $students = Student::when($selectedClass, function ($query) use ($selectedClass) {
                return $query->where('class_id', $selectedClass); // Asumsikan kolom class_id ada di tabel siswa
            })->get();
        
        return view('data_bimbingan', compact(
            'guidances', 'students', 'classes', 'majors', 'users', 'dates', 
            'selectedMonth', 'selectedYear', 'selectedClass', 'years'
        ), [
            'active' => 'guidance',
        ]);
        // return view('data_bimbingan', [
        //     'guidances' => Guidance::with(['student', 'user'])->get(),
        //     'users' => User::all(),
        //     'students' => Student::all(),
        //     'active' => 'guidance'
        // ]);
    }

    public function showImage($id)
    {
        $guidance = Guidance::findOrFail($id);
        if ($guidance->proof_of_guidance) {
            return response($guidance->proof_of_guidance)
                ->header('Content-Type', 'image/jpeg');
        }
        abort(404, 'Gambar tidak ditemukan.');
    }
    public function download($id)
    {
        $guidance = Guidance::findOrFail($id);
        if ($guidance->proof_of_guidance) {
            $fileContent = $guidance->proof_of_guidance;
            $extension = $this->getFileExtension($guidance->proof_of_guidance);
            $fileName = "bukti_bimbingan_{$guidance->id}.{$extension}";
            $contentType = $this->getContentTypeByExtension($extension);
            return response($fileContent)
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', "attachment; filename={$fileName}");
        }
        return redirect()->back()->with('error', 'Bukti tidak ditemukan.');
    }
    private function getFileExtension($blob)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $blob);
        finfo_close($finfo);
        switch ($mimeType) {
            case 'application/pdf':
                return 'pdf';
            case 'image/jpeg':
                return 'jpg';
            case 'image/png':
                return 'png';
            case 'image/gif':
                return 'gif';
            default:
                return 'bin'; 
        }
    }
    private function getContentTypeByExtension($extension)
    {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'bin' => 'application/octet-stream', 
        ];
        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }

    public function store(Request $request)
    {
        $request->validate([
            'topics' => 'required|string|max:255',
            'notes' => 'required|string|max:255',
            'date' => 'required|string|max:255',
            'proof_of_guidance' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'student_id' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
        ]);

        $lastGuidance = Guidance::where('student_id', $request->student_id)
            ->orderBy('guidance_count', 'desc')
            ->first();
        $guidanceCount = $lastGuidance ? $lastGuidance->guidance_count + 1 : 1;   
        $guidance = new Guidance();
        $guidance->topics = $request->input('topics');
        $guidance->notes = $request->input('notes');
        $guidance->date = $request->input('date');
        $guidance->student_id = $request->input('student_id');
        $guidance->user_id = $request->input('user_id');
        if ($request->hasFile('proof_of_guidance')) {
            $fileContent = file_get_contents($request->file('proof_of_guidance')->getRealPath());
            $guidance->proof_of_guidance = $fileContent; 
        }
        $guidance->guidance_count = $guidanceCount;
        $guidance->save();
        return redirect()->route('guidance.index')->with('success', 'Jurusan berhasil ditambahkan!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new GuidanceImport, $request->file('file'));

        return redirect()->route('guidance.index')->with('success', 'Data asesmen berhasil diimpor');
    }

    public function export()
    {
        // Mengambil semua data dari model Guidance
        $guidances = Guidance::all();

        // Buat file Excel
        $excelData = [];
        $excelData[] = ['ID', 'Topics', 'Notes', 'Date', 'Proof_of_guidance', 'Guidance_count', 'User_id', 'Student_id']; // Judul kolom

        foreach ($guidances as $guidance) {
            $excelData[] = [
                $guidance->id,      // Jika Anda ingin menyertakan ID
                $guidance->topics,
                $guidance->notes,
                $guidance->date,
                $guidance->proof_of_guidance,
                $guidance->guidance_count,
                $guidance->user->name,
                $guidance->student->name,
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
        $filename = 'guidances.xlsx';

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
            'topics' => 'required|string|max:255',
            'notes' => 'required|string|max:255',
            'date' => 'required|string|max:255',
            'student_id' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
            'proof_of_guidance' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);
        $guidance = Guidance::findOrFail($id);
        $guidance->topics = $request->input('topics');
        $guidance->notes = $request->input('notes');
        $guidance->date = $request->input('date');
        $guidance->student_id = $request->input('student_id');
        $guidance->user_id = $request->input('user_id');
        if ($guidance->guidance_count == 0 || is_null($guidance->guidance_count)) {
            $lastGuidance = Guidance::where('student_id', $request->student_id)
                ->orderBy('guidance_count', 'desc')
                ->first();
            $guidanceCount = $lastGuidance ? $lastGuidance->guidance_count + 1 : 1;
            $guidance->guidance_count = $guidanceCount;
        }
        if ($request->hasFile('proof_of_guidance')) {
            $fileContent = file_get_contents($request->file('proof_of_guidance')->getRealPath());
            $guidance->proof_of_guidance = $fileContent; 
        }
        $guidance->save();
        return redirect()->route('guidance.index')->with('success', 'Data bimbingan berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $guidance = Guidance::findOrFail($id);
        $guidance->delete();
        return redirect()->route('guidance.index')->with('success', 'Jurusan berhasil dihapus!');
    }
}
