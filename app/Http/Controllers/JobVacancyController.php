<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\User;
use Faker\Provider\Base;
use App\Imports\GuidanceImport;
use Maatwebsite\Excel\Facades\Excel;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class JobVacancyController extends Controller
{
    protected $UserModel;
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except(['landing']);
        $this->UserModel = new User();
    }
    public function index()
    {
        return view('data_loker', [
            'job_vacancies' => JobVacancy::with([ 'user'])->get(),
            'users' => User::all(),
            'active' => 'job_vacancy'
        ]);
    }

    public function showLatestImage()
    {
        $latestJobVacancy = JobVacancy::latest()->first();

        if ($latestJobVacancy && $latestJobVacancy->pamhplet) {
            return response()->json([
                'pamphlet' => route('jobVacancy.showImage', $latestJobVacancy->id),
            ]);
        }

        return response()->json([
            'message' => 'Tidak ada pamflet terbaru.',
        ], 404);
    }

    public function landing()
    {
        $job_vacancies = JobVacancy::latest()->paginate(3);
        $latestJobVacancy = JobVacancy::latest()->first();
        return view('landing', compact('job_vacancies', 'latestJobVacancy'));
    }

    public function showImage($id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        if ($jobVacancy->pamphlet) {
            return response($jobVacancy->pamphlet)
                ->header('Content-Type', 'image/jpeg');
        }
        abort(404, 'Gambar tidak ditemukan.');
    }
    public function download($id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        if ($jobVacancy->pamphlet) {
            $fileContent = $jobVacancy->pamphlet;
            $extension = $this->getFileExtension($jobVacancy->pamphlet);
            $fileName = "pamflet_{$jobVacancy->id}.{$extension}";
            $contentType = $this->getContentTypeByExtension($extension);
            return response($fileContent)
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', "attachment; filename={$fileName}");
        }
        return redirect()->back()->with('error', 'Pamflet tidak ditemukan.');
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
            'position' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'dateline_date' => 'required|date',
            'pamphlet' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'link' => 'nullable|string|max:255',
            'user_id' => 'required|string|max:255',
        ]);

        $jobVacancy = new JobVacancy();
        $jobVacancy->position = $request->input('position');
        $jobVacancy->company_name = $request->input('company_name');
        $jobVacancy->description = $request->input('description');
        $jobVacancy->location = $request->input('location');
        $jobVacancy->salary = $request->input('salary');
        $jobVacancy->dateline_date = $request->input('dateline_date');
        if ($request->hasFile('pamphlet')) {
            $fileContent = file_get_contents($request->file('pamphlet')->getRealPath());
            $jobVacancy->pamphlet = $fileContent; 
        }
        $jobVacancy->link = $request->input('link');
        $jobVacancy->user_id = $request->input('user_id');
        $jobVacancy->save();

        return redirect()->route('jobVacancy.index')->with('success', 'Jurusan berhasil ditambahkan!');
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
            empty($rows[$i][6]) && empty($rows[$i][7]) && empty($rows[$i][8])
        ) {
            continue;
        }

        $position      = trim($rows[$i][0]);
        $company_name  = trim($rows[$i][1]);
        $description   = trim($rows[$i][2]);
        $location      = trim($rows[$i][3]);
        $salary        = trim($rows[$i][4]);
        $dateline_date = trim($rows[$i][5]);
        $pamphlet      = trim($rows[$i][6]);
        $link          = trim($rows[$i][7]);
        $user_name     = trim($rows[$i][8]);

        $user = $this->UserModel->getByName($user_name);

        if (!$user) {
            return back()->with('error', "❌ User tidak ditemukan: $user_name (baris " . ($i + 1) . ")");
        }

        DB::table('job_vacancies')->insert([
            'position'       => $position,
            'company_name'   => $company_name,
            'description'    => $description,
            'location'       => $location,
            'salary'         => $salary,
            'dateline_date'  => $dateline_date,
            'pamphlet'       => $pamphlet,
            'link'           => $link,
            'user_id'        => $user->id,
        ]);
    }

    return back()->with('success', '✅ Data lowongan kerja berhasil diimpor!');
}

public function downloadFormat()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Format Loker');

    // Header kolom
    $sheet->fromArray([[
        'Posisi',
        'Nama Perusahaan',
        'Deskripsi',
        'Lokasi',
        'Gaji',
        'Tanggal Deadline',
        'Pamflet (URL / Path)',
        'Link Pendaftaran',
        'Nama User'
    ]], null, 'A1');

    // Format tanggal
    $sheet->getStyle('F2:F1000')->getNumberFormat()
        ->setFormatCode('yyyy-mm-dd');

    // Auto-size kolom
    foreach (range('A', 'I') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Nama file dan response
    $filename = 'format_import_loker.xlsx';
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
        // Mengambil semua data dari model JobVacancy
        $job_vacansies = JobVacancy::all();

        // Buat file Excel
        $excelData = [];
        $excelData[] = ['ID', 'Posisi', 'Nama Perusahaan', 'Deskripsi', 'Lokasi', 'Gaji', 'Tanggal Deadline', 'Pamphlet (URL / Path)', 'Link Pendaftaran', 'Nama User']; // Judul kolom

        foreach ($job_vacansies as $jobVacancy) {
            $excelData[] = [
                $jobVacancy->id,      // Jika Anda ingin menyertakan ID
                $jobVacancy->position,
                $jobVacancy->company_name,
                $jobVacancy->description,
                $jobVacancy->location,
                $jobVacancy->salary,
                $jobVacancy->dateline_date,
                $jobVacancy->pamphlet,
                $jobVacancy->link,
                $jobVacancy->user->name,
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
        $filename = 'loker.xlsx';

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
            'position' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'dateline_date' => 'required|date',
            'pamphlet' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'link' => 'nullable|string|max:255',
            'user_id' => 'required|string|max:255',
        ]);

        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->position = $request->input('position');
        $jobVacancy->company_name = $request->input('company_name');
        $jobVacancy->description = $request->input('description');
        $jobVacancy->location = $request->input('location');
        $jobVacancy->salary = $request->input('salary');
        $jobVacancy->dateline_date = $request->input('dateline_date');
        if ($request->hasFile('pamphlet')) {
            $fileContent = file_get_contents($request->file('pamphlet')->getRealPath());
            $jobVacancy->pamphlet = $fileContent; 
        }
        $jobVacancy->link = $request->input('link');
        $jobVacancy->user_id = $request->input('user_id');
        $jobVacancy->save();

        return redirect()->route('jobVacancy.index')->with('success', 'Jurusan berhasil diubah!');
    }

    // Fungsi untuk menghapus jurusan
    public function destroy($id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();

        // Redirect atau menampilkan pesan sukses
        return redirect()->route('jobVacancy.index')->with('success', 'Jurusan berhasil dihapus!');
    }
}
