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
        $statuses = [
            'Aktif',
            'Cuti',
            'Berhenti',
            'Lulus',
            'Non-Aktif',
            'Tunda Studi',
            'Dikeluarkan'
        ];
    
        foreach ($statuses as $status) {
            Status::create([
                'status_name' => $status,
            ]);
        }
    }
}
