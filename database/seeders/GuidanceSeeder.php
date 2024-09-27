<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guidance;

class GuidanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guidances = [
            [
                'topics' => 'Masalah Pribadi',
                'notes' => 'Siswa mengalami masalah di rumah yang mempengaruhi prestasi akademisnya. Sesi konseling diadakan untuk membantu siswa menemukan solusi.',
                'date' => '2024-09-25',
                'user_id' => 3, // ID dari Guru BK yang memberikan konseling
                'student_id' => 1,
            ],
            [
                'topics' => 'Perencanaan Karir',
                'notes' => 'Konseling mengenai pilihan karir setelah lulus. Diskusi tentang minat siswa dalam bidang teknik dan persiapan untuk melanjutkan pendidikan ke perguruan tinggi.',
                'date' => '2024-09-28',
                'user_id' => 3,
                'student_id' => 2,
            ],
            [
                'topics' => 'Masalah Disiplin',
                'notes' => 'Sesi konseling diadakan setelah siswa terlibat dalam perkelahian di sekolah. Diskusi mengenai kontrol emosi dan pentingnya disiplin.',
                'date' => '2024-09-30',
                'user_id' => 3,
                'student_id' => 1,
            ],
        ];

        foreach ($guidances as $guidance) {
            Guidance::create($guidance);
        }
    }
}
