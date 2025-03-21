<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::take(3)->get();

        // Tentukan bulan dan tahun yang diinginkan
        $selectedMonth = now()->format('m'); // bulan saat ini
        $selectedYear = now()->format('Y');   // tahun saat ini

        // Buat tanggal dari 1 hingga akhir bulan
        $startDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1);
        $endDate = $startDate->copy()->endOfMonth();

        // Mengambil user dengan role "Guru BK" dan "Wali Kelas" menggunakan Spatie
        $userBK = User::whereHas('roles', function ($query) {
            $query->where('name', 'Guru BK');
        })->first();

        // Daftar status kehadiran yang mungkin
        $presenceStatuses = ['Hadir', 'Alpa', 'Ijin', 'Sakit'];

        // Loop untuk setiap tanggal dalam bulan tersebut
        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            foreach ($students as $student) {
                // Menghasilkan status kehadiran secara acak
                $presenceStatus = $presenceStatuses[array_rand($presenceStatuses)];
                
                Attendance::create([
                    'date' => $date->format('Y-m-d'),
                    'presence_status' => $presenceStatus, // menggunakan string status
                    'description' => 'Absensi untuk ' . $student->name,
                    'student_id' => $student->id,
                    'user_id' => $userBK->id, // Menggunakan id dari user BK jika ada
                ]);
            }
        }
    }
}
