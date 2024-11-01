<?php

namespace App\Imports;

use App\Models\Assessment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class AssessmentImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Assessment([
            'question' => $row['question'], 
            'field' => $row['field'],
        ]);
    }
    public function headingRow(): int
    {
        return 1; // Menentukan bahwa baris pertama adalah heading
    }
}
