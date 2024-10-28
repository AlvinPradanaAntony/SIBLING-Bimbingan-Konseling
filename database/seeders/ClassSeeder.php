<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classes;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $class_level = ['X', 'XI', 'XII'];
        $major_id = [1,2,3,4,5];
        $classroom = ['1', '2'];

        foreach ($class_level as $level) {
            foreach ($major_id as $major) {
                foreach ($classroom as $room) {
                    Classes::create([
                        'class_level' => $level,
                        'major_id' => $major,
                        'classroom' => $room,
                    ]);
                }
            }
        }
    }
}
