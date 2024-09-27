<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create([
            'status_name' => 'Aktif',
        ]);
        Status::create([
            'status_name' => 'Cuti',
        ]);
        Status::create([
            'status_name' => 'Berhenti',
        ]);
        Status::create([
            'status_name' => 'Lulus',
        ]);
        Status::create([
            'status_name' => 'Non-Aktif',
        ]);
        Status::create([
            'status_name' => 'Tunda Studi',
        ]);
        Status::create([
            'status_name' => 'Dikeluarkan',
        ]);
    }
}
