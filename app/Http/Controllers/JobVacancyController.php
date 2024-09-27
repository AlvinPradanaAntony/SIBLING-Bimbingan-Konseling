<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\User;

class JobVacancyController extends Controller
{
    public function index()
    {
        return view('data_loker', [
            'job_vacancies' => JobVacancy::with([ 'user'])->get(),
            'users' => User::all(),
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'position' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'dateline_date' => 'required|string|max:255',
            'pamphlet' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
        ]);

        $jobVacancy = new JobVacancy();
        $jobVacancy->position = $request->input('position');
        $jobVacancy->company_name = $request->input('company_name');
        $jobVacancy->description = $request->input('description');
        $jobVacancy->location = $request->input('location');
        $jobVacancy->salary = $request->input('salary');
        $jobVacancy->dateline_date = $request->input('dateline_date');
        $jobVacancy->pamphlet = $request->input('pamphlet');
        $jobVacancy->user_id = $request->input('user_id');
        $jobVacancy->save();

        return redirect()->route('jobVacancy.index')->with('success', 'Jurusan berhasil ditambahkan!');
    }

    // Menyimpan perubahan jurusan ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'position' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'dateline_date' => 'required|string|max:255',
            'pamphlet' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
        ]);

        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->position = $request->input('position');
        $jobVacancy->company_name = $request->input('company_name');
        $jobVacancy->description = $request->input('description');
        $jobVacancy->location = $request->input('location');
        $jobVacancy->salary = $request->input('salary');
        $jobVacancy->dateline_date = $request->input('dateline_date');
        $jobVacancy->pamphlet = $request->input('pamphlet');
        $jobVacancy->user_id = $request->input('user_id');
        $jobVacancy->save();

        return redirect()->route('jobVacancy.index', $jobVacancy->id)->with('success', 'Jurusan berhasil diupdate!');
    }

    // Fungsi untuk menghapus jurusan
    public function destroy($id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();

        // Redirect atau menampilkan pesan sukses
        return redirect()->route('jobVacancy.index')->with('success', 'Jurusan berhasil dihapus!');
    }
}
