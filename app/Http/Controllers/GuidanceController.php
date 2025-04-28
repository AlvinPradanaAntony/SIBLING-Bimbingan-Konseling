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
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class GuidanceController extends Controller
{
    protected $UserModel;
    protected $StudentModel;
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->UserModel = new User();
        $this->StudentModel = new Student();
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
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        for ($i = 1; $i < count($rows); $i++) {
            if (empty($rows[$i][0]) && empty($rows[$i][1]) && empty($rows[$i][2])) {
                continue;
            }

            $topics = trim($rows[$i][0]);
            $notes = trim($rows[$i][1]);
            $date = trim($rows[$i][2]);
            $proof_of_guidance = trim($rows[$i][3]);
            $guidance_count = (int) $rows[$i][4];
            $user_name = trim($rows[$i][5]);      
            $student_name = trim($rows[$i][6]);   

            $user = $this->UserModel->getByName($user_name);
            $student = $this->StudentModel->getByName($student_name);

            if (!$user) {
                return back()->with('error', "❌ User tidak ditemukan: $user_name (baris " . ($i + 1) . ")");
            }

            if (!$student) {
                return back()->with('error', "❌ Siswa tidak ditemukan: $student_name (baris " . ($i + 1) . ")");
            }

            DB::table('guidances')->insert([
                'topics' => $topics,
                'notes' => $notes,
                'date' => $date,
                'proof_of_guidance' => $proof_of_guidance,
                'guidance_count' => $guidance_count,
                'user_id' => $user->id,
                'student_id' => $student->id,
            ]);
        }

        return back()->with('success', '✅ Data bimbingan berhasil diimpor!');
    }


    public function downloadFormat()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Format Bimbingan');

        // Header kolom
        $sheet->fromArray([[
            'Topik',
            'Catatan',
            'Tanggal',
            'Bukti Bimbingan',
            'Bimbingan Ke',
            'Guru BK',
            'Nama Siswa'
        ]], null, 'A1');

        $sheet->getStyle('C2:C1000')->getNumberFormat()
            ->setFormatCode('yyyy-mm-dd');

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'format_import_bimbingan.xlsx';
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
        $guidances = Guidance::all();

        $excelData = [];
        $excelData[] = ['ID', 'Topik', 'Catatan', 'Tanggal', 'Bukti Bimbingan', 'Bimbingan Ke', 'Guru BK', 'Nama Siswa']; // Judul kolom

        foreach ($guidances as $guidance) {
            $excelData[] = [
                $guidance->id,      
                $guidance->topics,
                $guidance->notes,
                $guidance->date,
                $guidance->proof_of_guidance,
                $guidance->guidance_count,
                $guidance->user->name,
                $guidance->student->name,
            ];
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($excelData as $rowIndex => $row) {
            foreach ($row as $colIndex => $cellValue) {
                $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 1, $cellValue);
            }
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'export_bimbingan.xlsx';

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
