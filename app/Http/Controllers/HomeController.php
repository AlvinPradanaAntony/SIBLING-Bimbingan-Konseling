<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\Student;
use App\Models\Cases;
use App\Models\Guidance;

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
        return view('home', [
            'job_vacancies' => JobVacancy::all(),
            'total_job_vacancies' => JobVacancy::count(),
            'cases' => Cases::all(),
            'total_cases' => Cases::count(),
            'guidances' => Guidance::all(),
            'total_guidances' => Guidance::count(),
            'active' => 'home'
        ]);
    }
}
