<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cases;

class CaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cases = [
            [
                'case_name' => 'Terlambat Masuk Sekolah',
                'description' => 'Siswa terlambat masuk sekolah selama 30 menit.',
                'resolution' => 'Peringatan lisan diberikan oleh guru BK.',
                'case_point' => 5,
                'date' => '2024-09-15',
                'user_id' => 3, // ID dari guru atau staf yang mencatat kasus
                'student_id' => 1,
            ],
            [
                'case_name' => 'Tidak Mengumpulkan Tugas',
                'description' => 'Siswa tidak mengumpulkan tugas matematika sesuai dengan deadline.',
                'resolution' => 'Peringatan tertulis diberikan dan tugas harus diselesaikan dalam 3 hari.',
                'case_point' => 10,
                'date' => '2024-09-18',
                'user_id' => 4,
                'student_id' => 2,
            ],
            [
                'case_name' => 'Berkelahi di Sekolah',
                'description' => 'Siswa terlibat perkelahian di sekolah dengan teman sekelas.',
                'resolution' => 'Diberikan sanksi skorsing selama 3 hari oleh wali kelas dan guru BK.',
                'case_point' => 50,
                'date' => '2024-09-20',
                'user_id' => 2,
                'student_id' => 1,
            ],
        ];

        foreach ($cases as $case) {
            Cases::create($case);
        }
    }
}
