<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cases;
use App\Models\Student;
use App\Models\User;
use App\Models\Classes;
use App\Models\Major;   
use Carbon\Carbon;
use App\Imports\CaseImport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CaseController extends Controller
{
    protected $UserModel;
    protected $StudentModel;
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->UserModel = new User();
        $this->StudentModel = new Student();
    }
    
    public function index(Request $request){
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

        $cases = Cases::with(['student', 'user'])
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
        
        return view('data_kasus', compact(
            'cases', 'students', 'classes', 'majors', 'users', 'dates', 
            'selectedMonth', 'selectedYear', 'selectedClass', 'years'
        ), [
            'active' => 'case',
        ]);
        // return view('data_kasus', [
        //     'cases' => Cases::with(['student', 'user'])->get(),
        //     'students' => Student::all(),
        //     'users' => User::all(),
        //     'active' => 'case'
        // ]);
    }

    public function showImage($id)
    {
        $case = Cases::findOrFail($id);
        if ($case->evidence) {
            return response($case->evidence)
                ->header('Content-Type', 'image/jpeg');
        }
        abort(404, 'Gambar tidak ditemukan.');
    }
    public function download($id)
    {
        $case = Cases::findOrFail($id);
        if ($case->evidence) {
            $fileContent = $case->evidence;
            $extension = $this->getFileExtension($case->evidence);
            $fileName = "bukti_kasus_{$case->id}.{$extension}";
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
            'case_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'resolution' => 'required|string|max:255',
            'case_point' => 'required|string|max:255',
            'date' => 'required|date',
            'evidence' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'student_id' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
        ]);

        $case = new Cases();
        $case->case_name = $request->input('case_name');
        $case->description = $request->input('description');
        $case->resolution = $request->input('resolution');
        $case->case_point = $request->input('case_point');
        $case->date = Carbon::parse($request->input('date'))->format('Y-m-d H:i:s');
        if ($request->hasFile('evidence')) {
            $fileContent = file_get_contents($request->file('evidence')->getRealPath());
            $case->evidence = $fileContent;
        }
        $case->student_id = $request->input('student_id');
        $case->user_id = $request->input('user_id');
        $case->save();

        return redirect()->route('case.index')->with('success', 'Kasus berhasil ditambahkan!');
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
        if (
            empty($rows[$i][0]) && empty($rows[$i][1]) && empty($rows[$i][2]) &&
            empty($rows[$i][3]) && empty($rows[$i][4]) && empty($rows[$i][5]) &&
            empty($rows[$i][6]) && empty($rows[$i][7])
        ) {
            continue;
        }

        $case_name     = trim($rows[$i][0]);
        $description   = trim($rows[$i][1]);
        $resolution    = trim($rows[$i][2]);
        $case_point    = (int) $rows[$i][3];
        $date          = trim($rows[$i][4]);
        $evidence      = trim($rows[$i][5]);
        $user_name     = trim($rows[$i][6]);
        $student_name  = trim($rows[$i][7]);

        $user = $this->UserModel->getByName($user_name);
        $student = $this->StudentModel->getByName($student_name);

        if (!$user) {
            return back()->with('error', "❌ Guru BK tidak ditemukan: $user_name (baris " . ($i + 1) . ")");
        }

        if (!$student) {
            return back()->with('error', "❌ Siswa tidak ditemukan: $student_name (baris " . ($i + 1) . ")");
        }

        DB::table('cases')->insert([
            'case_name'   => $case_name,
            'description' => $description,
            'resolution'  => $resolution,
            'case_point'  => $case_point,
            'date'        => $date,
            'evidence'    => $evidence,
            'user_id'     => $user->id,
            'student_id'  => $student->id,
        ]);
    }

    return back()->with('success', '✅ Data kasus berhasil diimpor!');
}
public function downloadFormat()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Format Kasus');

    // Header kolom
    $sheet->fromArray([[
        'Nama Kasus',
        'Deskripsi',
        'Solusi',
        'Poin Kasus',
        'Tanggal',
        'Bukti',
        'Guru BK',
        'Nama Siswa'
    ]], null, 'A1');

    // Format tanggal
    $sheet->getStyle('E2:E1000')->getNumberFormat()
        ->setFormatCode('yyyy-mm-dd');

    // Auto-size kolom
    foreach (range('A', 'H') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Nama file dan response
    $filename = 'format_import_kasus.xlsx';
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
        // Mengambil semua data dari model Case
        $cases = Cases::all();

        // Buat file Excel
        $excelData = [];
        $excelData[] = ['ID', 'Nama Kasus', 'Deskripsi', 'Solusi', 'Poin', 'Tanggal', 'Bukti', 'Guru BK', 'Nama Siswa']; // Judul kolom

        foreach ($cases as $case) {
            $excelData[] = [
                $case->id,      // Jika Anda ingin menyertakan ID
                $case->case_name,
                $case->description,
                $case->resolution,
                $case->case_point,
                $case->date,
                $case->evidence,
                $case->user->name,
                $case->student->name,
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
        $filename = 'export_kasus.xlsx';

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
            'case_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'resolution' => 'required|string|max:255',
            'case_point' => 'required|string|max:255',
            'date' => 'required|date',
            'evidence' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'student_id' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
        ]);

        $case = Cases::findOrFail($id);
        $case->case_name = $request->input('case_name');
        $case->description = $request->input('description');
        $case->resolution = $request->input('resolution');
        $case->case_point = $request->input('case_point');
        $case->date = Carbon::parse($request->input('date'))->format('Y-m-d H:i:s');
        if ($request->hasFile('evidence')) {
            $fileContent = file_get_contents($request->file('evidence')->getRealPath());
            $case->evidence = $fileContent;
        }
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
