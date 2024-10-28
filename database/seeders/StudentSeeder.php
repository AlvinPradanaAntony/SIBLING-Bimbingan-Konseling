<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'nisn' => '1234567890',
                'name' => 'Budi Santoso',
                'gender' => 'Laki-laki',
                'place_of_birth' => 'Jakarta',
                'date_of_birth' => '2005-03-15',
                'religion' => 'Islam',
                'phone_number' => '081234567890',
                'address' => 'Jl. Merdeka No.1, Jakarta',
                'admission_date' => '2020-07-10',
                'guardian_name' => fake()->name,
                'guardian_phone_number' => '081987654321',
                'class_id' => 1,
                'status_id' => 1,
                'email' => 'budi@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'nisn' => '0987654321',
                'name' => 'Siti Nurhaliza',
                'gender' => 'Perempuan',
                'place_of_birth' => 'Bandung',
                'date_of_birth' => '2006-05-20',
                'religion' => 'Kristen',
                'phone_number' => '082234567890',
                'address' => 'Jl. Sudirman No.2, Bandung',
                'admission_date' => '2021-07-12',
                'guardian_name' => fake()->name,
                'guardian_phone_number' => '082987654321',
                'class_id' => 2,
                'status_id' => 1,
                'email' => 'siti@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'nisn' => '1122334455',
                'name' => 'Ahmad Fauzi',
                'gender' => 'Laki-laki',
                'place_of_birth' => 'Surabaya',
                'date_of_birth' => '2007-08-25',
                'religion' => 'Islam',
                'phone_number' => '083345678901',
                'address' => 'Jl. Pahlawan No.3, Surabaya',
                'admission_date' => '2022-07-15',
                'guardian_name' => fake()->name,
                'guardian_phone_number' => '083987654321',
                'class_id' => 16,
                'status_id' => 4,
                'email' => 'ahmad@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
