<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobVacancy;

class JobVacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $job_vacancies = [
            [
                'position' => 'Software Engineer',
                'company_name' => 'PT. Teknologi Canggih',
                'description' => 'Mencari Software Engineer yang berpengalaman dalam pengembangan aplikasi web menggunakan Laravel dan React.',
                'location' => 'Jakarta',
                'salary' => 'Rp10.000.000 - Rp15.000.000',
                'dateline_date' => '2024-10-15',
                'pamphlet' => 'pamphlet_software_engineer.pdf',
                'user_id' => 1, // ID dari pengguna yang mengiklankan lowongan
            ],
            [
                'position' => 'UI/UX Designer',
                'company_name' => 'PT. Desain Kreatif',
                'description' => 'Dibutuhkan UI/UX Designer untuk merancang antarmuka pengguna yang intuitif dan menarik.',
                'location' => 'Bandung',
                'salary' => 'Rp8.000.000 - Rp12.000.000',
                'dateline_date' => '2024-10-30',
                'pamphlet' => 'pamphlet_uiux_designer.pdf',
                'user_id' => 2,
            ],
            [
                'position' => 'Data Analyst',
                'company_name' => 'PT. Analisis Data Terbaik',
                'description' => 'Mencari Data Analyst untuk menganalisis data dan memberikan wawasan yang mendukung keputusan bisnis.',
                'location' => 'Yogyakarta',
                'salary' => 'Rp9.000.000 - Rp13.000.000',
                'dateline_date' => '2024-11-01',
                'pamphlet' => 'pamphlet_data_analyst.pdf',
                'user_id' => 1,
            ],
        ];

        foreach ($job_vacancies as $jobVacancy) {
            JobVacancy::create($jobVacancy);
        }
    }
}
