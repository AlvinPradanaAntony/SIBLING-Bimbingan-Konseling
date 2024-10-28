<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = [
            'Teknik Kendaraan Ringan',
            'Teknik Bisnis Sepeda Motor',
            'Teknik Komputer dan Jaringan',
            'Desain Komunikasi Visual',
            'Tata Kecantikan Kulit dan Rambut',
        ];

        foreach ($majors as $major) {
            Major::create(['major_name' => $major]);
        }
    }
}
