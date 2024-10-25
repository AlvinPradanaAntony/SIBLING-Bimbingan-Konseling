<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        return view('data_siswa', [
            'students' => Student::with(['class', 'status'])->get(),
            'active' => 'student'
        ]);
    }
}
