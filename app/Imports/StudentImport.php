<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class StudentImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Student([
            'nisn' => $row['nisn'],
            'name' => $row['name'],
            'class_id' => $row['class_id'],
            'gender' => $row['gender'],
            'place_of_birth' => $row['place_of_birth'],
            'date_of_birth' => $row['date_of_birth'],
            'religion' => $row['religion'],
            'phone_number' => $row['phone_number'],
            'address' => $row['address'],
            'guardian_name' => $row['guardian_name'],
            'guardian_phone_number' => $row['guardian_phone_number'],
            'email' => $row['email'],
            'status_id' => $row['status_id'],
            'admission_date' => $row['admission_date'],
        ]);
    }
    public function headingRow(): int
    {
        return 1; // Menentukan bahwa baris pertama adalah heading
    }
}
