<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\Student;
use App\Models\Cases;
use App\Models\Guidance;
use App\Models\Attendance;
use App\Models\Achievement;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Ambil tanggal hari ini
        $today = Carbon::today();
        
        // Ambil tanggal pertama dan terakhir bulan ini
        $firstDayOfMonth = $today->copy()->startOfMonth();
        $lastDayOfMonth = $today->copy()->endOfMonth();
        $firstDayOfYear = $today->copy()->startOfYear();
        $lastDayOfYear = $today->copy()->endOfYear();

        // Hitung jumlah bimbingan per hari dalam bulan ini
        $months_in_year = range(1, 12);
        $guidances_per_day = [];
        $cases_per_day = [];
        $attendances_per_day = [];
        $careers_per_month = [];
        $achievements_per_month = [];
        $days_in_month = $today->daysInMonth;
        
        
        // Loop untuk setiap hari dalam bulan
        for ($i = 1; $i <= $days_in_month; $i++) {
            $date = $firstDayOfMonth->copy()->addDays($i - 1);
            
            // Hitung jumlah bimbingan
            $guidances_per_day[] = Guidance::whereDate('date', $date)->count();
            
            // Hitung jumlah kasus
            $cases_per_day[] = Cases::whereDate('date', $date)->count();
            
            // Hitung jumlah absensi
            $attendances_per_day[] = Attendance::whereDate('date', $date)->count();
        }

        // Loop untuk setiap bulan dalam tahun ini (1 hingga 12)
        for ($i = 1; $i <= 12; $i++) {
            $startOfMonth = $today->copy()->month($i)->startOfMonth();
            $endOfMonth = $today->copy()->month($i)->endOfMonth();

            // Hitung jumlah Karir per bulan
            $careers_per_month[] = JobVacancy::whereBetween('dateline_date', [$startOfMonth, $endOfMonth])->count();

            // Hitung jumlah Prestasi per bulan
            $achievements_per_month[] = Achievement::whereBetween('date', [$startOfMonth, $endOfMonth])->count();
        }   

        return view('home', [
            'job_vacancies' => JobVacancy::all(),
            'total_job_vacancies' => JobVacancy::count(),
            'cases' => Cases::all(),
            'total_cases' => Cases::count(),
            'guidances' => Guidance::all(),
            'total_guidances' => Guidance::count(),
            'active' => 'home',
            'days_in_month' => $days_in_month,
            'months_in_year' => $months_in_year,
            'guidances_per_day' => $guidances_per_day,
            'cases_per_day' => $cases_per_day,
            'attendances_per_day' => $attendances_per_day,
            'careers_per_month' => $careers_per_month,
            'achievements_per_month' => $achievements_per_month,
        ]);
    }
}
