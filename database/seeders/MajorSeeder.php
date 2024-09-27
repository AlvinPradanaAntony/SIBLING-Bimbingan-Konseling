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
        Major::create([
            'major_name' => 'Teknik Kendaraan Ringan',
        ]);
        Major::create([
            'major_name' => 'Teknik Bisnis Sepeda Motor',
        ]);
        Major::create([
            'major_name' => 'Teknik Komputer dan Jaringan',
        ]);
        Major::create([
            'major_name' => 'Desain Komunikasi Visual',
        ]);
        Major::create([
            'major_name' => 'Tata Kecantikan Kulit dan Rambut',
        ]);
    }
}
