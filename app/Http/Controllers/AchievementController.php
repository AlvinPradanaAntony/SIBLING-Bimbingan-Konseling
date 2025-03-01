<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\Achievement;
use App\Models\Student;
use Maatwebsite\Excel\Facades\Excel;

class AchievementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        return view('data_prestasi', [
            'achievements' => Achievement::with(['student'])->get(),
            'students' => Student::all(),
            'active' => 'achievement'
        ]);
    }

    public function showImage($id)
    {
        $achievement = Achievement::findOrFail($id);
        if ($achievement->certificate) {
            return response($achievement->certificate)
                ->header('Content-Type', 'image/jpeg');
        }
        abort(404, 'Gambar tidak ditemukan.');
    }
    public function download($id)
    {
        $achievement = Achievement::findOrFail($id);
        if ($achievement->certificate) {
            $fileContent = $achievement->certificate;
            $extension = $this->getFileExtension($achievement->certificate);
            $fileName = "sertifikat_{$achievement->id}.{$extension}";
            $contentType = $this->getContentTypeByExtension($extension);
            return response($fileContent)
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', "attachment; filename={$fileName}");
        }
        return redirect()->back()->with('error', 'Sertifikat tidak ditemukan.');
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
            'ranking' => 'required|string|max:255',
            'achievements_name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'description' => 'required',
            'type' => 'required|string|max:255',
            'date' => 'required|date',
            'recognition' => 'required|string|max:255',
            'certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'student_id' => 'required|string|max:255',
        ]);

        $achievement = new Achievement();
        $achievement->ranking = $request->input('ranking');
        $achievement->achievements_name = $request->input('achievements_name');
        $achievement->level = $request->input('level');
        $achievement->description = $request->input('description');
        $achievement->type = $request->input('type');
        $achievement->date = $request->input('date');
        $achievement->recognition = $request->input('recognition');
        if ($request->hasFile('certificate')) {
            $fileContent = file_get_contents($request->file('certificate')->getRealPath());
            $achievement->certificate = $fileContent; 
        }
        $achievement->student_id = $request->input('student_id');
        $achievement->save();

        return redirect()->route('achievement.index')->with('success', 'Jurusan berhasil ditambahkan!');
    }

    public function export()
    {
        // Mengambil semua data dari model Achievement
        $achievements = Achievement::all();

        // Buat file Excel
        $excelData = [];
        $excelData[] = ['ID', 'Ranking', 'Achievement Name', 'Level', 'Description', 'Type', 'Date', 'Recognition', 'Certificate', 'Student ID']; // Judul kolom

        foreach ($achievements as $achievement) {
            $excelData[] = [
                $achievement->id,
                $achievement->ranking,
                $achievement->achievements_name,
                $achievement->level,
                $achievement->description,
                $achievement->type,
                $achievement->date,
                $achievement->recognition,
                $achievement->certificate,
                $achievement->student->name,
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
        $filename = 'achievements.xlsx';

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
            'ranking' => 'required|string|max:255',
            'achievements_name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'description' => 'required',
            'type' => 'required|string|max:255',
            'date' => 'required|date',
            'recognition' => 'required|string|max:255',
            'certificate' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'student_id' => 'required|string|max:255',
        ]);

        $achievement = Achievement::findOrFail($id);
        $achievement->ranking = $request->input('ranking');
        $achievement->achievements_name = $request->input('achievements_name');
        $achievement->level = $request->input('level');
        $achievement->description = $request->input('description');
        $achievement->type = $request->input('type');
        $achievement->date = $request->input('date');
        $achievement->recognition = $request->input('recognition');
        if ($request->hasFile('certificate')) {
            $fileContent = file_get_contents($request->file('certificate')->getRealPath());
            $achievement->certificate = $fileContent; 
        }
        $achievement->student_id = $request->input('student_id');
        $achievement->save();
        return redirect()->route('achievement.index', $achievement->id)->with('success', 'Pencapaian berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $achievement = Achievement::findOrFail($id);
        $achievement->delete();
        return redirect()->route('achievement.index')->with('success', 'Jurusan berhasil dihapus!');
    }
}
