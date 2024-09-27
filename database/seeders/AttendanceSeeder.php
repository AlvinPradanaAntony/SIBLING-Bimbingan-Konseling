<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attendance;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attendances = [
            [
                'date' => '2024-09-26',
                'presence_status' => 'Hadir',
                'description' => 'Siswa hadir tepat waktu.',
                'user_id' => 3, // Misalnya ID dari Wali Kelas atau Guru
                'student_id' => 1,
            ],
            [
                'date' => '2024-09-26',
                'presence_status' => 'Sakit',
                'description' => 'Siswa sakit, tidak dapat hadir.',
                'user_id' => 3,
                'student_id' => 2,
            ],
            [
                'date' => '2024-09-27',
                'presence_status' => 'Ijin',
                'description' => 'Siswa izin karena ada acara keluarga.',
                'user_id' => 3,
                'student_id' => 1,
            ],
        ];

        foreach ($attendances as $attendance) {
            Attendance::create($attendance);
        }
    }
}
