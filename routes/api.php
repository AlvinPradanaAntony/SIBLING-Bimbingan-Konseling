<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/prestasi', [AchievementController::class, 'index'])->name('achievement.index');
Route::post('/prestasi', [AchievementController::class, 'store'])->name('achievement.store');
Route::get('/prestasi/{id}/edit', [AchievementController::class, 'edit'])->name('achievement.edit');
Route::put('/prestasi/{id}', [AchievementController::class, 'update'])->name('achievement.update');
Route::delete('/prestasi/{id}', [AchievementController::class, 'destroy'])->name('achievement.destroy');