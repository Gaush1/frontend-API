<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
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

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/user', function (Request $request) {
//         return $request->user();
//     });
//     Route::post('/logout', [AuthController::class, 'logout']);
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
   
});

Route::post('/register-doctor', [AuthController::class, 'registerDoctor']); 
Route::post('/login-doctor', [AuthController::class, 'loginDoctor']);
Route::post('/register-patient', [AuthController::class, 'registerPatient']);
Route::post('/login-patient', [AuthController::class, 'loginPatient']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/appointments', [AppointmentController::class, 'store']);
Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);
