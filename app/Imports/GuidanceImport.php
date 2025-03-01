<?php

namespace App\Imports;

use App\Models\Guidance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class GuidanceImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Guidance([
            'topics' => $row['topics'],
            'notes' => $row['notes'],
            'date' => $row['date'],
            'proof_of_guidance' => $row['proof_of_guidance'],
            'guidance_count' => $row['guidance_count'],
            'user_id' => $row['user_id'],
            'student_id' => $row['student_id'],
        ]);
    }
    public function headingRow(): int
    {
        return 1; // Menentukan bahwa baris pertama adalah heading
    }
}
