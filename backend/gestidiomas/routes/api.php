<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\TeacherSpecialtyController;
use App\Http\Controllers\AppointmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::resource('students', StudentController::class);

    Route::resource('teachers', TeacherController::class);
    Route::get('/teachers/{teacherId}/specialties', [TeacherSpecialtyController::class, 'listSpecialties']);
    Route::post('/teachers/{teacherId}/specialties', [TeacherSpecialtyController::class, 'assignSpecialty']);
    Route::delete('/teachers/{teacherId}/specialties/{specialtyId}', [TeacherSpecialtyController::class, 'removeSpecialty']);

    Route::resource('specialties', SpecialtyController::class);

    Route::prefix('appointments')->group(function () {
        Route::get('/', [AppointmentController::class, 'index']); 
        Route::post('/', [AppointmentController::class, 'create']); 
        Route::put('/{id}', [AppointmentController::class, 'update']); 
        Route::delete('/{id}', [AppointmentController::class, 'cancel']); 
        Route::get('/student/{studentId}', [AppointmentController::class, 'listByStudent']); 
    });
    

});

