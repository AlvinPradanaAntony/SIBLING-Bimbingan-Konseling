<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Status;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentImport implements ToModel, WithHeadingRow, WithMapping
{
    /**
     * Normalize Excel headers to snake_case lowercase
     */
    public function map($row): array
    {
        $mapped = [];
        foreach ($row as $key => $value) {
            $normalizedKey = Str::slug(trim($key), '_');
            $mapped[$normalizedKey] = $value;
        }
        return $mapped;
    }

    public function model(array $row)
    {
        // Normalize status (if found)
        $statusName = strtolower(trim($row['status'] ?? ''));
        $status = Status::whereRaw("LOWER(TRIM(status_name)) = ?", [$statusName])->select('id')->first();

        // Normalize gender
        $gender = strtolower(trim($row['gender'] ?? '')) === 'laki-laki' ? 'Laki-laki' : 'Perempuan';

        // Validate religion
        $validReligions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
        $religion = in_array($row['religion'] ?? '', $validReligions) ? $row['religion'] : null;

        // Format date of birth
        $dateOfBirth = null;
        if (!empty($row['date_of_birth']) && is_numeric($row['date_of_birth'])) {
            $dateOfBirth = Date::excelToDateTimeObject($row['date_of_birth'])->format('Y-m-d');
        }

        // Format admission date
        $admissionDate = null;
        if (!empty($row['admission_date']) && is_numeric($row['admission_date'])) {
            $admissionDate = Date::excelToDateTimeObject($row['admission_date'])->format('Y-m-d');
        }

        // Format phone numbers
        $phoneNumber = isset($row['phone_number']) ? preg_replace('/\D/', '', $row['phone_number']) : null;
        $guardianPhoneNumber = isset($row['guardian_phone_number']) ? preg_replace('/\D/', '', $row['guardian_phone_number']) : null;

        return new Student([
            'nisn' => trim((string) ($row['nisn'] ?? '')),
            'name' => $row['name'] ?? null,
            'gender' => $gender,
            'place_of_birth' => $row['place_of_birth'] ?? null,
            'date_of_birth' => $dateOfBirth,
            'religion' => $religion,
            'phone_number' => $phoneNumber,
            'address' => $row['address'] ?? null,
            'guardian_name' => $row['guardian_name'] ?? null,
            'guardian_phone_number' => $guardianPhoneNumber,
            'email' => $row['email'] ?? null,
            'status_id' => $status->id ?? null,
            'admission_date' => $admissionDate,
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
