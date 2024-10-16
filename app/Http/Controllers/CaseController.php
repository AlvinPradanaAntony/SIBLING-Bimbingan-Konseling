<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cases;
use App\Models\Student;
use App\Models\User;

class CaseController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    
    public function index(){
        return view('data_kasus', [
            'cases' => Cases::with(['student', 'user'])->get(),
            'students' => Student::all(),
            'users' => User::all(),
            'active' => 'case'
        ]);
    }
}
