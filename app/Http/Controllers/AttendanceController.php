<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Major;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Imports\GuidanceImport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
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

        $attendances = Attendance::with(['student', 'user'])
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

        return view('data_absensi', compact(
            'attendances', 'students', 'classes', 'majors', 'users', 'dates', 
            'selectedMonth', 'selectedYear', 'selectedClass', 'years'
        ), [
            'active' => 'attendance',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'month' => 'required|numeric|min:1|max:12',
            'year' => 'required|numeric',
            'presence_status' => 'required|array',
            'presence_status.*' => 'required|in:Hadir,Alpa,Ijin,Sakit',
            'user_id' => 'required|exists:users,id',
        ]);

        $user_id_bk = auth()->id();

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year);

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($request->year, $request->month, $day)->format('Y-m-d');
            if (isset($request->presence_status[$date])) {
                Attendance::create([
                    'student_id' => $request->student_id,
                    'date' => $date,
                    'presence_status' => $request->presence_status[$date],
                    'user_id' => $request->user_id,
                    'month' => $request->month,
                    'year' => $request->year,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data absensi bulanan berhasil ditambahkan');
    }

    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,xls,csv'
    //     ]);

    //     Excel::import(new AttendanceImport, $request->file('file'));

    //     return redirect()->route('attendance.index')->with('success', 'Data asesmen berhasil diimpor');
    // }

    public function export()
    {
        // Mengambil semua data dari model Attendance
        $attendances = Attendance::all();

        // Buat file Excel
        $excelData = [];
        $excelData[] = ['ID', 'Date', 'Presence_status', 'Description', 'user_id', 'student_id']; // Judul kolom

        foreach ($attendances as $attendance) {
            $excelData[] = [
                $attendance->id,      // Jika Anda ingin menyertakan ID
                $attendance->date,
                $attendance->presence_status,
                $attendance->description,
                $attendance->user->name,
                $attendance->student->name,
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
        $filename = 'attendances.xlsx';

        // Mengembalikan response download
        return response()->stream(function() use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function update(Request $request, $student_id)
    {
        $request->validate([
            'presence_status' => 'required|array',
            'user_id' => 'required|exists:users,id',
            'month' => 'required|numeric',
            'year' => 'required|numeric',
        ]);

        $user_id = auth()->id();
        
        foreach ($request->input('presence_status') as $date => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'date' => $date,
                ],
                [
                    'presence_status' => $status,
                    'user_id' => $user_id,
                ]
            );
        }

        return redirect()->back()->with('success', 'Absensi berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        Attendance::where('student_id', $id)
                ->whereMonth('date', $request->month)
                ->whereYear('date', $request->year)
                ->delete();

        return redirect()->route('attendance.index')->with('success', 'Data absensi berhasil dihapus.');
    }
}
