<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Status;
use App\Models\Classes;
use App\Models\Major;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class StudentController extends Controller
{
    protected $ClassModel;
    protected $StatusModel;
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->ClassModel = new Classes();
        $this->StatusModel = new Status();
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

    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,xls,csv'
    //     ]);
    //     Excel::import(new StudentImport, $request->file('file'));
    //     return redirect()->route('student.index')->with('success', 'Data asesmen berhasil diimpor');
    // }

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
            if (empty($rows[$i][0]) && empty($rows[$i][1]) && empty($rows[$i][2])) {
                continue;
            }

            $nisn = addslashes($rows[$i][0]);
            $name = addslashes($rows[$i][1]);
            $class = trim($rows[$i][2]);
            $gender = $rows[$i][3];
            $place_of_birth = $rows[$i][4];
            $date_of_birth = $rows[$i][5];
            $religion = $rows[$i][6];
            $phone_number = $rows[$i][7];
            $address = $rows[$i][8];
            $guardian_name = $rows[$i][9];
            $guardian_phone_number = $rows[$i][10];
            $email = $rows[$i][11];
            $status = trim($rows[$i][12]);
            $admission_date = $rows[$i][13];

            $kelas = $this->ClassModel->getByName($class);
            $statu = $this->StatusModel->getByName($status);

            if (!$kelas) {
                return back()->with('error', "❌ Kelas tidak ditemukan: $class (baris ".($i+1).")");
            }
            if (!$statu) {
                return back()->with('error', "❌ Status tidak ditemukan: $status (baris ".($i+1).")");
            }

            DB::table('students')->insert([
                'nisn' => $nisn,
                'name' => $name,
                'class_id' => $kelas->id,
                'gender' => $gender,
                'place_of_birth' => $place_of_birth,
                'date_of_birth' => $date_of_birth,
                'religion' => $religion,
                'phone_number' => $phone_number,
                'address' => $address,
                'guardian_name' => $guardian_name,
                'guardian_phone_number' => $guardian_phone_number,
                'email' => $email,
                'status_id' => $statu->id,
                'admission_date' => $admission_date,
            ]);
        }

        return back()->with('success', '✅ Excel berhasil diimpor ke database!');
    }


    public function downloadFormat()
    {
        $spreadsheet = new Spreadsheet();

        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Format Siswa');

        $headers = ['NISN', 'Nama', 'Kelas', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Agama', 'No Telepon', 'Alamat', 'Nama Wali', 'Nomor Telepon Wali', 'Email', 'Status', 'Tanggal Masuk'];
        $sheet1->fromArray([$headers], null, 'A1');

        $classSheet = new Worksheet($spreadsheet, 'Daftar Kelas');
        $spreadsheet->addSheet($classSheet);
        $classSheet->fromArray(['ID', 'Kelas', 'Jurusan', 'Ruang'], null, 'A1');

        $classes = Classes::with('major')->get();
        $classData = [];
        foreach ($classes as $class) {
            $classData[] = [
                $class->id,
                $class->class_level,
                $class->major->major_name,
                $class->classroom
            ];
        }
        $classSheet->fromArray($classData, null, 'A2');

        $statusSheet = new Worksheet($spreadsheet, 'Daftar Status');
        $spreadsheet->addSheet($statusSheet);
        $statusSheet->fromArray(['ID', 'Status'], null, 'A1');

        $statuses = Status::all();
        $statusData = [];
        foreach ($statuses as $status) {
            $statusData[] = [$status->id, $status->status_name];
        }
        $statusSheet->fromArray($statusData, null, 'A2');

        for ($i = 2; $i <= count($classData) + 1; $i++) {
            $classSheet->setCellValue('E' . $i, '=B' . $i . ' & " " & C' . $i . ' & " " & D' . $i);
        }

        for ($i = 2; $i <= 1000; $i++) {
            $dropdownGender = $sheet1->getCell('D' . $i)->getDataValidation();
            $dropdownGender->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $dropdownGender->setFormula1('"Laki-laki,Perempuan"');
            $dropdownGender->setAllowBlank(false);
            $dropdownGender->setShowDropDown(true);
        }

        $sheet1->getStyle('F2:F1000')->getNumberFormat()->setFormatCode('yyyy-mm-dd');
        $sheet1->getStyle('N2:N1000')->getNumberFormat()->setFormatCode('yyyy-mm-dd');

        $filename = 'format_import_siswa.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->stream(function() use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function export()
    {
        $students = Student::all();

        $excelData = [];
        $excelData[] = ['NISN', 'Nama', 'Kelas', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Agama', 'No Telepon', 'Alamat', 'Nama Wali', 'Nomor Telepon Wali', 'Email', 'Status', 'Tanggal Masuk']; // Judul kolom

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
                $student->status->status_name,
                $student->admission_date,
            ];
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($excelData as $rowIndex => $row) {
            foreach ($row as $colIndex => $cellValue) {
                $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 1, $cellValue);
            }
        }

        $dateColumns = ['F', 'N']; 
        $rowCount = count($students) + 1;

        foreach ($dateColumns as $col) {
            $sheet->getStyle($col . '2:' . $col . $rowCount)
                ->getNumberFormat()
                ->setFormatCode('yyyy-mm-dd');
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'export_siswa.xlsx';

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
