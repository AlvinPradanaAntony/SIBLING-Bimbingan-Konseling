<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\CaseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GuidanceController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\StudentAssessmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthenticationController;
use App\Models\Role;
use App\Models\Student;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::get('/', [JobVacancyController::class, 'landing'], function () {
    return view('landing');
});

Route::get('/coba', function () {
    return view('coba', ['siswa' => Student::with(['class', 'status'])->get(), 'active' => 'coba']);
});
Route::get('/settings', function () {
    return view('settings',[
        'active' => 'settings',
        'roles' => Role::all()]);
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/siswa', [StudentController::class, 'index'])->name('student.index')->middleware('permission:Lihat Siswa');
    Route::post('/siswa', [StudentController::class, 'store'])->name('student.store')->middleware('permission:Tambah Siswa');
    Route::put('/siswa/{id}', [StudentController::class, 'update'])->name('student.update')->middleware('permission:Ubah Siswa');
    Route::delete('/siswa/{id}', [StudentController::class, 'destroy'])->name('student.destroy')->middleware('permission:Hapus Siswa');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/users', [UsersController::class, 'index'])->name('user.index')->middleware('permission:Lihat User');
    Route::post('/users', [UsersController::class, 'store'])->name('user.store')->middleware('permission:Tambah User');
    Route::put('/users/{id}', [UsersController::class, 'update'])->name('user.update')->middleware('permission:Ubah User');
    Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('user.destroy')->middleware('permission:Hapus User');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/jurusan', [MajorController::class, 'index'])->name('major.index')->middleware('permission:Lihat Jurusan');
    Route::post('/jurusan', [MajorController::class, 'store'])->name('major.store')->middleware('permission:Tambah Jurusan');
    Route::put('/jurusan/{id}', [MajorController::class, 'update'])->name('major.update')->middleware('permission:Ubah Jurusan');
    Route::delete('/jurusan/{id}', [MajorController::class, 'destroy'])->name('major.destroy')->middleware('permission:Hapus Jurusan');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/kelas', [ClassController::class, 'index'])->name('class.index')->middleware('permission:Lihat Kelas');
    Route::post('/kelas', [ClassController::class, 'store'])->name('class.store')->middleware('permission:Tambah Kelas');
    Route::put('/kelas/{id}', [ClassController::class, 'update'])->name('class.update')->middleware('permission:Ubah Kelas');
    Route::delete('/kelas/{id}', [ClassController::class, 'destroy'])->name('class.destroy')->middleware('permission:Hapus Kelas');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/akses', [RoleController::class, 'index'])->name('role.index')->middleware('permission:Lihat Role');
    Route::post('/akses', [RoleController::class, 'store'])->name('role.store')->middleware('permission:Tambah Role');
    Route::put('/akses/{id}', [RoleController::class, 'update'])->name('role.update')->middleware('permission:Ubah Role');
    Route::delete('/akses/{id}', [RoleController::class, 'destroy'])->name('role.destroy')->middleware('permission:Hapus Role');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/status', [StatusController::class, 'index'])->name('status.index')->middleware('permission:Lihat Status');
    Route::post('/status', [StatusController::class, 'store'])->name('status.store')->middleware('permission:Tambah Status');
    Route::put('/status/{id}', [StatusController::class, 'update'])->name('status.update')->middleware('permission:Ubah Status');
    Route::delete('/status/{id}', [StatusController::class, 'destroy'])->name('status.destroy')->middleware('permission:Hapus Status');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/asesmen', [AssessmentController::class, 'index'])->name('assessment.index')->middleware('permission:Lihat Asesmen');
    Route::post('/asesmen', [AssessmentController::class, 'store'])->name('assessment.store')->middleware('permission:Tambah Asesmen');
    Route::put('/asesmen/{id}', [AssessmentController::class, 'update'])->name('assessment.update')->middleware('permission:Ubah Asesmen');
    Route::delete('/asesmen/{id}', [AssessmentController::class, 'destroy'])->name('assessment.destroy')->middleware('permission:Hapus Asesmen');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/bimbingan', [GuidanceController::class, 'index'])->name('guidance.index')->middleware('permission:Lihat Bimbingan');
    Route::post('/bimbingan', [GuidanceController::class, 'store'])->name('guidance.store')->middleware('permission:Tambah Bimbingan');
    Route::put('/bimbingan/{id}', [GuidanceController::class, 'update'])->name('guidance.update')->middleware('permission:Ubah Bimbingan');
    Route::delete('/bimbingan/{id}', [GuidanceController::class, 'destroy'])->name('guidance.destroy')->middleware('permission:Hapus Bimbingan');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/kasus', [CaseController::class, 'index'])->name('case.index')->middleware('permission:Lihat Kasus');
    Route::post('/kasus', [CaseController::class, 'store'])->name('case.store')->middleware('permission:Tambah Kasus');
    Route::put('/kasus/{id}', [CaseController::class, 'update'])->name('case.update')->middleware('permission:Ubah Kasus');
    Route::delete('/kasus/{id}', [CaseController::class, 'destroy'])->name('case.destroy')->middleware('permission:Hapus Kasus');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/absensi', [AttendanceController::class, 'index'])->name('attendance.index')->middleware('permission:Lihat Absensi');
    Route::post('/absensi', [AttendanceController::class, 'store'])->name('attendance.store')->middleware('permission:Tambah Absensi');
    Route::put('/absensi/{id}', [AttendanceController::class, 'update'])->name('attendance.update')->middleware('permission:Ubah Absensi');
    Route::delete('/absensi/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy')->middleware('permission:Hapus Absensi');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/loker', [JobVacancyController::class, 'index'])->name('jobVacancy.index')->middleware('permission:Lihat Loker');
    Route::post('/loker', [JobVacancyController::class, 'store'])->name('jobVacancy.store')->middleware('permission:Tambah Loker');
    Route::put('/loker/{id}', [JobVacancyController::class, 'update'])->name('jobVacancy.update')->middleware('permission:Ubah Loker');
    Route::delete('/loker/{id}', [JobVacancyController::class, 'destroy'])->name('jobVacancy.destroy')->middleware('permission:Hapus Loker');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/prestasi', [AchievementController::class, 'index'])->name('achievement.index')->middleware('permission:Lihat Prestasi');
    Route::post('/prestasi', [AchievementController::class, 'store'])->name('achievement.store')->middleware('permission:Tambah Prestasi');
    Route::put('/prestasi/{id}', [AchievementController::class, 'update'])->name('achievement.update')->middleware('permission:Ubah Prestasi');
    Route::delete('/prestasi/{id}', [AchievementController::class, 'destroy'])->name('achievement.destroy')->middleware('permission:Hapus Prestasi');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/asesmen_siswa', [StudentAssessmentController::class, 'index'])->name('student_assessment.index')->middleware('permission:Lihat Asesmen Siswa');
    Route::post('/asesmen_siswa', [StudentAssessmentController::class, 'store'])->name('student_assessment.store')->middleware('permission:Tambah Asesmen Siswa');
    Route::put('/asesmen_siswa/{id}', [StudentAssessmentController::class, 'update'])->name('student_assessment.update')->middleware('permission:Ubah Asesmen Siswa');
    Route::delete('/asesmen_siswa/{id}', [StudentAssessmentController::class, 'destroy'])->name('student_assessment.destroy')->middleware('permission:Hapus Asesmen Siswa');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/laporan', [ReportsController::class, 'index'])->name('reports.index')->middleware('permission:Lihat Laporan');
    Route::post('/laporan', [ReportsController::class, 'store'])->name('reports.store')->middleware('permission:Tambah Laporan');
    Route::put('/laporan/{id}', [ReportsController::class, 'update'])->name('reports.update')->middleware('permission:Ubah Laporan');
    Route::delete('/laporan/{id}', [ReportsController::class, 'destroy'])->name('reports.destroy')->middleware('permission:Hapus Laporan');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/autentifikasi', [AuthenticationController::class, 'index'])->name('autentifikasi.index')->middleware('permission:Lihat Autentifikasi');
    Route::post('/autentifikasi', [AuthenticationController::class, 'store'])->name('autentifikasi.store')->middleware('permission:Tambah Autentifikasi');
    Route::put('/autentifikasi/{id}', [AuthenticationController::class, 'update'])->name('autentifikasi.update')->middleware('permission:Ubah Autentifikasi');
    Route::delete('/autentifikasi/{id}', [AuthenticationController::class, 'destroy'])->name('autentifikasi.destroy')->middleware('permission:Hapus Autentifikasi');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index')->middleware('permission:Lihat Perizinan');
    Route::post('/permission', [PermissionController::class, 'store'])->name('permission.store')->middleware('permission:Tambah Perizinan');
    Route::put('/permission/{id}', [PermissionController::class, 'update'])->name('permission.update')->middleware('permission:Ubah Perizinan');
    Route::delete('/permission/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy')->middleware('permission:Hapus Perizinan');
});

require __DIR__.'/auth.php';