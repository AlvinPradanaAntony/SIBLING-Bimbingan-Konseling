<?php

namespace App\Imports;

use App\Models\Case;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class CaseImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Case([
            'question' => $row['question'], 
            'field' => $row['field'],
        ]);
    }
    public function headingRow(): int
    {
        return 1; // Menentukan bahwa baris pertama adalah heading
    }
}
