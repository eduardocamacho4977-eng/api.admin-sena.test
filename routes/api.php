<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ApprenticeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\TrainingCenterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/areas', [AreaController::class, 'apiIndex']);
Route::post('/areas', [AreaController::class, 'apiStore']);
Route::get('area/{id}', [AreaController::class, 'apiShow'])->name('area.show');
Route::put('area/{id}', [AreaController::class, 'apiUpdate'])->name('area.update');
Route::delete('area/{id}', [AreaController::class, 'apiDestroy'])->name('area.destroy');

Route::get('/training_centers', [TrainingCenterController::class, 'apiIndex']);
Route::post('/training_centers', [TrainingCenterController::class, 'apiStore']);
Route::get('training_center/{id}', [TrainingCenterController::class, 'apiShow'])->name('training_center.show');
Route::put('training_center/{id}', [TrainingCenterController::class, 'apiUpdate'])->name('training_center.update');
Route::delete('training_center/{id}', [TrainingCenterController::class, 'apiDestroy'])->name('training_center.destroy');

Route::get('/computers', [ComputerController::class, 'apiIndex']);
Route::post('/computers', [ComputerController::class, 'apiStore']);
Route::get('computer/{id}', [ComputerController::class, 'apiShow'])->name('computer.show');
Route::put('computer/{id}', [ComputerController::class, 'apiUpdate'])->name('computer.update');
Route::delete('computer/{id}', [ComputerController::class, 'apiDestroy'])->name('computer.destroy');

Route::get('/teachers', [TeacherController::class, 'apiIndex']);
Route::post('/teachers', [TeacherController::class, 'apiStore']);
Route::get('teacher/{id}', [TeacherController::class, 'apiShow'])->name('teacher.show');
Route::put('teacher/{id}', [TeacherController::class, 'apiUpdate'])->name('teacher.update');
Route::delete('teacher/{id}', [TeacherController::class, 'apiDestroy'])->name('teacher.destroy');

Route::get('/courses', [CourseController::class, 'apiIndex']);
Route::post('/courses', [CourseController::class, 'apiStore']);
Route::get('course/{id}', [CourseController::class, 'apiShow'])->name('course.show');
Route::put('course/{id}', [CourseController::class, 'apiUpdate'])->name('course.update');
Route::delete('course/{id}', [CourseController::class, 'apiDestroy'])->name('course.destroy');

Route::get('/apprentices', [ApprenticeController::class, 'apiIndex']);
Route::post('/apprentices', [ApprenticeController::class, 'apiStore']);
Route::get('apprentice/{id}', [ApprenticeController::class, 'apiShow'])->name('apprentice.show');
Route::put('apprentice/{id}', [ApprenticeController::class, 'apiUpdate'])->name('apprentice.update');
Route::delete('apprentice/{id}', [ApprenticeController::class, 'apiDestroy'])->name('apprentice.destroy');




