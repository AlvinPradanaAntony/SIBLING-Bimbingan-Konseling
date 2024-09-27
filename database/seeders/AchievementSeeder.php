<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'ranking' => '1',
                'achievements_name' => 'Olimpiade Matematika',
                'level' => 'Nasional',
                'description' => 'Memenangkan juara 1 pada Olimpiade Matematika tingkat nasional.',
                'type' => 'Individu',
                'date' => '2023-08-15',
                'recognition' => 'Medali Emas',
                'certificate' => 'olimpiade_matematika_2023.pdf',
                'student_id' => 1,
            ],
            [
                'ranking' => '3',
                'achievements_name' => 'Lomba Pidato Bahasa Inggris',
                'level' => 'Provinsi',
                'description' => 'Juara 3 dalam lomba pidato bahasa Inggris tingkat provinsi.',
                'type' => 'Kelompok',
                'date' => '2022-12-10',
                'recognition' => 'Piala Perunggu',
                'certificate' => 'pidato_bahasa_inggris_2022.pdf',
                'student_id' => 2,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}
