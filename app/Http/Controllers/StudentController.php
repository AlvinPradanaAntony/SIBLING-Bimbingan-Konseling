<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Status;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        return view('data_siswa', [
            'students' => Student::with(['class.major', 'status'])->get(),
            'classes' => Classes::all(),
            'statuses' => Status::all(),
            'active' => 'student'
        ]);
    }

    public function create(){
        return view('student.create', [
            // 'students' => Student::with(['class', 'status'])->get(),
            'active' => 'student',
        ]);
    }

    public function showImage($id)
    {
        $student = Student::findOrFail($id);
        if ($student->photo) {
            return response($student->photo)
                ->header('Content-Type', 'image/jpeg');
        }
        abort(404, 'Gambar tidak ditemukan.');
    }
    public function download($id)
    {
        $student = Student::findOrFail($id);
        if ($student->photo) {
            $fileContent = $student->photo;
            $extension = $this->getFileExtension($student->photo);
            $fileName = "foto_siswa_{$student->id}.{$extension}";
            $contentType = $this->getContentTypeByExtension($extension);
            return response($fileContent)
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', "attachment; filename={$fileName}");
        }
        return redirect()->back()->with('error', 'Foto tidak ditemukan.');
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
            'nisn' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'religion' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'photo' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'admission_date' => 'required|date',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone_number' => 'required|string|max:255',
            'class_id' => 'required|string|max:255',
            'status_id' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $student = new Student();
        $student->nisn = $request->input('nisn');
        $student->name = $request->input('name');
        $student->gender = $request->input('gender');
        $student->place_of_birth = $request->input('place_of_birth');
        $student->date_of_birth = $request->input('date_of_birth');
        $student->religion = $request->input('religion');
        $student->phone_number = $request->input('phone_number');
        $student->address = $request->input('address');
        if ($request->hasFile('photo')) {
            $fileContent = file_get_contents($request->file('photo')->getRealPath());
            $student->photo = $fileContent; 
        }
        $student->admission_date = $request->input('admission_date');
        $student->guardian_name = $request->input('guardian_name');
        $student->guardian_phone_number = $request->input('guardian_phone_number');
        $student->class_id = $request->input('class_id');
        $student->status_id = $request->input('status_id');
        $student->email = $request->input('email');
        $student->save();
        return redirect()->route('student.index')->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        Excel::import(new StudentImport, $request->file('file'));
        return redirect()->route('student.index')->with('success', 'Data asesmen berhasil diimpor');
    }

    public function export()
    {
        // Mengambil semua data dari model Student
        $students = Student::all();

        // Buat file Excel
        $excelData = [];
        $excelData[] = ['NISN', 'Name', 'Class_id', 'Gender', 'Place_of_birth', 'Date_of_birth', 'Religion', 'Phone_number', 'Address', 'Guardian_name', 'Guardian_phone_number', 'Email', 'Status_id', 'Admission_date']; // Judul kolom

        foreach ($students as $student) {
            $excelData[] = [
                $student->nisn,
                $student->name,
                $student->class->class_level . ' ' . $student->class->major->major_name . ' ' . $student->class->classroom,
                $student->gender,
                $student->place_of_birth,
                $student->date_of_birth,
                $student->religion,
                $student->phone_number,
                $student->address,
                $student->guardian_name,
                $student->guardian_phone_number,
                $student->email,
                $student->status->status_id,
                $student->admission_date,
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
        $filename = 'students.xlsx';

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
            'nisn' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'religion' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'photo' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'admission_date' => 'required|date',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone_number' => 'required|string|max:255',
            'class_id' => 'required|string|max:255',
            'status_id' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $student = Student::findOrFail($id);
        
        $student->nisn = $request->input('nisn');
        $student->name = $request->input('name');
        $student->gender = $request->input('gender');
        $student->place_of_birth = $request->input('place_of_birth');
        $student->date_of_birth = $request->input('date_of_birth');
        $student->religion = $request->input('religion');
        $student->phone_number = $request->input('phone_number');
        $student->address = $request->input('address');
        if ($request->hasFile('photo')) {
            $fileContent = file_get_contents($request->file('photo')->getRealPath());
            $student->photo = $fileContent; 
        }
        $student->admission_date = $request->input('admission_date');
        $student->guardian_name = $request->input('guardian_name');
        $student->guardian_phone_number = $request->input('guardian_phone_number');
        $student->class_id = $request->input('class_id');
        $student->status_id = $request->input('status_id');
        $student->email = $request->input('email');
        $student->save();

        return redirect()->route('student.index')->with('success', 'Data siswa berhasil diubah');
    }

    public function destroy($id){
        $student = Student::find($id);
        $student->delete();
        return redirect()->route('student.index')->with('success', 'Siswa berhasil dihapus!');
    }
}
