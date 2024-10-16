<?php

use App\Models\Role;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CaseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GuidanceController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\AchievementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing');
});
Route::get('/coba', function () {
    return view('coba', ['siswa' => Student::with(['class', 'status'])->get()]);
});
Route::get('/settings', function () {
    return view('settings',[
        'active' => 'settings',
        'roles' => Role::all()]);
});


Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/prestasi', [AchievementController::class, 'index'])->name('achievement.index');
Route::post('/prestasi', [AchievementController::class, 'store'])->name('achievement.store');
Route::get('/prestasi/{id}/edit', [AchievementController::class, 'edit'])->name('achievement.edit');
Route::put('/prestasi/{id}', [AchievementController::class, 'update'])->name('achievement.update');
Route::delete('/prestasi/{id}', [AchievementController::class, 'destroy'])->name('achievement.destroy');

Route::get('/absensi', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/absensi', [AttendanceController::class, 'store'])->name('attendance.store');
Route::get('/absensi/{id}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
Route::put('/absensi/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
Route::delete('/absensi/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');

Route::get('/kasus', [CaseController::class, 'index'])->name('case.index');
Route::post('/kasus', [CaseController::class, 'store'])->name('case.store');
Route::get('/kasus/{id}/edit', [CaseController::class, 'edit'])->name('case.edit');
Route::put('/kasus/{id}', [CaseController::class, 'update'])->name('case.update');
Route::delete('/kasus/{id}', [CaseController::class, 'destroy'])->name('case.destroy');

Route::get('/kelas', [ClassController::class, 'index'])->name('class.index');
Route::post('/kelas', [ClassController::class, 'store'])->name('class.store');
Route::get('/kelas/{id}/edit', [ClassController::class, 'edit'])->name('class.edit');
Route::put('/kelas/{id}', [ClassController::class, 'update'])->name('class.update');
Route::delete('/kelas/{id}', [ClassController::class, 'destroy'])->name('class.destroy');

Route::get('/bimbingan', [GuidanceController::class, 'index'])->name('guidance.index');
Route::post('/bimbingan', [GuidanceController::class, 'store'])->name('guidance.store');
Route::get('/bimbingan/{id}/edit', [GuidanceController::class, 'edit'])->name('guidance.edit');
Route::put('/bimbingan/{id}', [GuidanceController::class, 'update'])->name('guidance.update');
Route::delete('/bimbingan/{id}', [GuidanceController::class, 'destroy'])->name('guidance.destroy');

Route::get('/loker', [JobVacancyController::class, 'index'])->name('jobVacancy.index');
Route::post('/loker', [JobVacancyController::class, 'store'])->name('jobVacancy.store');
Route::get('/loker/{id}/edit', [JobVacancyController::class, 'edit'])->name('jobVacancy.edit');
Route::put('/loker/{id}', [JobVacancyController::class, 'update'])->name('jobVacancy.update');
Route::delete('/loker/{id}', [JobVacancyController::class, 'destroy'])->name('jobVacancy.destroy');

Route::get('/jurusan', [MajorController::class, 'index'])->name('major.index');
Route::post('/jurusan', [MajorController::class, 'store'])->name('major.store');
Route::get('/jurusan/{id}/edit', [MajorController::class, 'edit'])->name('major.edit');
Route::put('/jurusan/{id}', [MajorController::class, 'update'])->name('major.update');
Route::delete('/jurusan/{id}', [MajorController::class, 'destroy'])->name('major.destroy');

Route::get('/akses', [RoleController::class, 'index'])->name('role.index');
Route::post('/akses', [RoleController::class, 'store'])->name('role.store');
Route::get('/akses/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
Route::put('/akses/{id}', [RoleController::class, 'update'])->name('role.update');
Route::delete('/akses/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

Route::get('/status', [StatusController::class, 'index'])->name('status.index');
Route::post('/status', [StatusController::class, 'store'])->name('status.store');
Route::get('/status/{id}/edit', [StatusController::class, 'edit'])->name('status.edit');
Route::put('/status/{id}', [StatusController::class, 'update'])->name('status.update');
Route::delete('/status/{id}', [StatusController::class, 'destroy'])->name('status.destroy');

Route::get('/siswa', [StudentController::class, 'index'])->name('student.index');
Route::post('/siswa', [StudentController::class, 'store'])->name('student.store');
Route::get('/siswa/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
Route::put('/siswa/{id}', [StudentController::class, 'update'])->name('student.update');
Route::delete('/siswa/{id}', [StudentController::class, 'destroy'])->name('student.destroy');

Route::get('/users', [UsersController::class, 'index'])->name('user.index');
Route::post('/users', [UsersController::class, 'store'])->name('user.store');
Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('user.edit');
Route::put('/users/{id}', [UsersController::class, 'update'])->name('user.update');
Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('user.destroy');

Route::get('/laporan', [ReportsController::class, 'index'])->name('reports.index');
Route::post('/laporan', [ReportsController::class, 'store'])->name('reports.store');
Route::get('/laporan/{id}/edit', [ReportsController::class, 'edit'])->name('reports.edit');
Route::put('/laporan/{id}', [ReportsController::class, 'update'])->name('reports.update');
Route::delete('/laporan/{id}', [ReportsController::class, 'destroy'])->name('reports.destroy');

// Route::get('/form', [FormsController::class, 'index'])->name('form.index');
// Route::post('/form', [FormsController::class, 'store'])->name('form.store');
// Route::get('/form/{id}/edit', [FormsController::class, 'edit'])->name('form.edit');
// Route::put('/form/{id}', [FormsController::class, 'update'])->name('form.update');
// Route::delete('/form/{id}', [FormsController::class, 'destroy'])->name('form.destroy');

// Route::get('/register', [LevelController::class, 'index'])->name('level.index');