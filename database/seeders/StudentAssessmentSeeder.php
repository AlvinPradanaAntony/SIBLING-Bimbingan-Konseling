<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\StudentAssessment;

class StudentAssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $studentIds = [1, 2, 3];
        $assessmentIds = range(1, 50); // Misalkan ada 50 assessment

        foreach ($studentIds as $studentId) {
            foreach ($assessmentIds as $assessmentId) {
                StudentAssessment::create([
                    'student_id' => $studentId,
                    'assessment_id' => $assessmentId,
                    'answer' => rand(0, 1) // Mengisi dengan 0 atau 1 secara acak
                ]);
            }
        }
    }
}
