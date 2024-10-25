<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\User;
use Faker\Provider\Base;

class JobVacancyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        return view('data_loker', [
            'job_vacancies' => JobVacancy::with([ 'user'])->get(),
            'users' => User::all(),
            'active' => 'job_vacancy'
        ]);
    }

    public function landing()
    {
        $job_vacancies = JobVacancy::orderBy('updated_at', 'desc')->take(3)->get();
        return view('landing', compact('job_vacancies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'position' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'dateline_date' => 'required|date',
            'pamphlet' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|string|max:255',
        ]);

        if ($request->hasFile('pamphlet')) {
            $file = $request->file('pamphlet');
            $path = $file->store('pamphlets', 'public');
            $filename = basename($path);
        }

        $jobVacancy = new JobVacancy();
        $jobVacancy->position = $request->input('position');
        $jobVacancy->company_name = $request->input('company_name');
        $jobVacancy->description = $request->input('description');
        $jobVacancy->location = $request->input('location');
        $jobVacancy->salary = $request->input('salary');
        $jobVacancy->dateline_date = $request->input('dateline_date');
        $jobVacancy->pamphlet = $filename;
        $jobVacancy->user_id = $request->input('user_id');
        $jobVacancy->save();

        return redirect()->route('jobVacancy.index')->with('success', 'Jurusan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'position' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'dateline_date' => 'required|date',
            'pamphlet' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|string|max:255',
        ]);

        if ($request->hasFile('pamphlet')) {
            $file = $request->file('pamphlet');
            $path = $file->store('pamphlets', 'public');
            $filename = basename($path);
        }

        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->position = $request->input('position');
        $jobVacancy->company_name = $request->input('company_name');
        $jobVacancy->description = $request->input('description');
        $jobVacancy->location = $request->input('location');
        $jobVacancy->salary = $request->input('salary');
        $jobVacancy->dateline_date = $request->input('dateline_date');
        // $jobVacancy->pamphlet = $filename;
        if ($request->hasFile('pamphlet')) {
            // Hapus pamflet lama jika ada
            if ($jobVacancy->pamphlet) {
                Storage::disk('public')->delete('pamphlets/' . $jobVacancy->pamphlet);
            }

            // Simpan pamflet baru
            $file = $request->file('pamphlet');
            $path = $file->store('pamphlets', 'public');
            $jobVacancy->pamphlet = basename($path); // Menyimpan nama file pamflet baru
        }
        $jobVacancy->user_id = $request->input('user_id');
        $jobVacancy->save();

        return redirect()->route('jobVacancy.index')->with('success', 'Jurusan berhasil diubah!');
    }
    // Menyimpan perubahan jurusan ke database
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'position' => 'required|string|max:255',
    //         'company_name' => 'required|string|max:255',
    //         'description' => 'required',
    //         'location' => 'required|string|max:255',
    //         'salary' => 'required|string|max:255',
    //         'dateline_date' => 'required|date',
    //         'pamphlet' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'user_id' => 'required|string|max:255',
    //     ]);

    //     if ($request->hasFile('pamphlet')) {
    //         $file = $request->file('pamphlet');
    //         $path = $file->store('pamphlets', 'public');
    //         $filename = basename($path);
    //     }

    //     $jobVacancy = JobVacancy::findOrFail($id);
    //     $jobVacancy->position = $request->input('position');
    //     $jobVacancy->company_name = $request->input('company_name');
    //     $jobVacancy->description = $request->input('description');
    //     $jobVacancy->location = $request->input('location');
    //     $jobVacancy->salary = $request->input('salary');
    //     $jobVacancy->dateline_date = $request->input('dateline_date');
    //     $jobVacancy->pamphlet = $filename;
    //     $jobVacancy->user_id = $request->input('user_id');
    //     $jobVacancy->save();

    //     return redirect()->route('jobVacancy.index', $jobVacancy->id)->with('success', 'Jurusan berhasil diupdate!');
    // }

    // Fungsi untuk menghapus jurusan
    public function destroy($id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();

        // Redirect atau menampilkan pesan sukses
        return redirect()->route('jobVacancy.index')->with('success', 'Jurusan berhasil dihapus!');
    }
}
