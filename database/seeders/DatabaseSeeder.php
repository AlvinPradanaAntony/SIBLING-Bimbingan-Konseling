<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(MajorSeeder::class);
        $this->call(ClassSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(AchievementSeeder::class);
        $this->call(AttendanceSeeder::class);
        $this->call(JobVacancySeeder::class);
        $this->call(GuidanceSeeder::class);
        $this->call(CaseSeeder::class);
    }
}
