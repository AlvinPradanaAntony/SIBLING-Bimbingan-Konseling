<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    // Menampilkan semua akses
    public function index()
    {
        return view('assessment', [
            'active' => 'assessment'
        ]);
    }

    public function store(Request $request)
    {
       
    }

    public function update(Request $request, $id)
    {
      
    }

    public function destroy($id)
    {
    
    }
}
