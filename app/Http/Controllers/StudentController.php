<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Status;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

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

    public function downloadFormat()
    {
        $spreadsheet = new Spreadsheet();

        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Template Siswa');

        $headers = ['NISN', 'Name', 'Class', 'Gender', 'Place of Birth', 'Date of Birth', 'Religion', 'Phone Number', 'Address', 'Guardian Name', 'Guardian Phone Number', 'Email', 'Status', 'Admission Date'];
        $sheet1->fromArray([$headers], null, 'A1');

        $classSheet = new Worksheet($spreadsheet, 'Daftar Kelas');
        $spreadsheet->addSheet($classSheet);

        // Judul kolom
        $classSheet->setCellValue('A1', 'ID');
        $classSheet->setCellValue('B1', 'Class Level');
        $classSheet->setCellValue('C1', 'Major');
        $classSheet->setCellValue('D1', 'Classroom');

        // Ambil data kelas
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

        // Masukkan data mulai dari A2
        $classSheet->fromArray($classData, null, 'A2');


        $statusSheet = new Worksheet($spreadsheet, 'Daftar Status');
        $spreadsheet->addSheet($statusSheet);

        $statusSheet->setCellValue('A1', 'ID');
        $statusSheet->setCellValue('B1', 'Status Name');

        $statuses = Status::all();
        $statusData = [];
        foreach ($statuses as $status) {
            $statusData[] = [$status->id, $status->status_name];
        }

        $statusSheet->fromArray($statusData, null, 'A2');

for ($i = 2; $i <= count($classData) + 1; $i++) {
    $classSheet->setCellValue('E' . $i, '=B' . $i . ' & " " & C' . $i . ' & " " & D' . $i);
}

        $dropdownClass = $sheet1->getCell('C2')->getDataValidation();
$dropdownClass->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
$dropdownClass->setFormula1("'Daftar Kelas'!E2:E" . (count($classData) + 1));
$dropdownClass->setAllowBlank(false);
$dropdownClass->setShowDropDown(true);
$classSheet->getColumnDimension('E')->setVisible(false);


        $dropdownGender = $sheet1->getCell('D2')->getDataValidation();
        $dropdownGender->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $dropdownGender->setFormula1('"Laki-laki,Perempuan"');
        $dropdownGender->setAllowBlank(false);
        $dropdownGender->setShowDropDown(true);

        $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']; // Bisa ditambah dari DB kalau perlu
        $religionList = '"' . implode(',', $religions) . '"';

        $dropdownReligion = $sheet1->getCell('G2')->getDataValidation();
        $dropdownReligion->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $dropdownReligion->setFormula1($religionList);
        $dropdownReligion->setAllowBlank(false);
        $dropdownReligion->setShowDropDown(true);

        $dateColumns = ['F', 'N']; 
        foreach ($dateColumns as $col) {
            $sheet1->getStyle($col . '2:' . $col . '1000')
                ->getNumberFormat()
                ->setFormatCode('yyyy-mm-dd');

            for ($i = 2; $i <= 1000; $i++) {
                $dateValidation = $sheet1->getCell($col . $i)->getDataValidation();
                $dateValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_DATE);
                $dateValidation->setAllowBlank(false);
                $dateValidation->setShowErrorMessage(true);
                $dateValidation->setErrorTitle('Invalid Date Format');
                $dateValidation->setError('Gunakan format tanggal YYYY-MM-DD.');
            }
        }

        for ($i = 2; $i <= 1000; $i++) {
            $phoneValidation = $sheet1->getCell('H' . $i)->getDataValidation();
            $phoneValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_WHOLE);
            $phoneValidation->setAllowBlank(false);
            $phoneValidation->setShowErrorMessage(true);
            $phoneValidation->setErrorTitle('Invalid Phone Number');
            $phoneValidation->setError('Harap masukkan angka saja, tanpa huruf atau karakter lain.');

            $guardianPhoneValidation = $sheet1->getCell('K' . $i)->getDataValidation();
            $guardianPhoneValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_WHOLE);
            $guardianPhoneValidation->setAllowBlank(false);
            $guardianPhoneValidation->setShowErrorMessage(true);
            $guardianPhoneValidation->setErrorTitle('Invalid Phone Number');
            $guardianPhoneValidation->setError('Harap masukkan angka saja, tanpa huruf atau karakter lain.');
        }
        
        for ($i = 2; $i <= 1000; $i++) {
            $emailValidation = $sheet1->getCell('L' . $i)->getDataValidation();
            $emailValidation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_CUSTOM);
            $emailValidation->setFormula1('=ISNUMBER(FIND("@",L' . $i . '))');
            $emailValidation->setAllowBlank(false);
            $emailValidation->setShowErrorMessage(true);
            $emailValidation->setErrorTitle('Invalid Email');
            $emailValidation->setError('Harap masukkan email yang valid (harus ada "@").');
        }

        $dropdownStatus = $sheet1->getCell('M2')->getDataValidation();
        $dropdownStatus->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $dropdownStatus->setFormula1("'Daftar Status'!B2:B" . (count($statusData) + 1));
        $dropdownStatus->setAllowBlank(false);
        $dropdownStatus->setShowDropDown(true);

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
        $excelData[] = ['NISN', 'Name', 'Class', 'Gender', 'Place of Birth', 'Date of Birth', 'Religion', 'Phone Number', 'Address', 'Guardian Name', 'Guardian Phone', 'Email', 'Status', 'Admission Date']; // Judul kolom

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

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'students.xlsx';

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
