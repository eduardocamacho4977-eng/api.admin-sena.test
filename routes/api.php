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


Route::get('/apprentices', [ApprenticeController::class, 'apiIndex']);
Route::post('/apprentices', [ApprenticeController::class, 'apiStore']);

Route::get('/courses', [CourseController::class, 'apiIndex']);
Route::post('/courses', [CourseController::class, 'apiStore']);

Route::get('/teachers', [TeacherController::class, 'apiIndex']);
Route::post('/teachers', [TeacherController::class, 'apiStore']);

Route::get('/computers', [ComputerController::class, 'apiIndex']);
Route::post('/computers', [ComputerController::class, 'apiStore']);


Route::get('/training_centers', [TrainingCenterController::class, 'apiIndex']);
Route::post('/training_centers', [TrainingCenterController::class, 'apiStore']);

