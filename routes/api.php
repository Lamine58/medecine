<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ApiController;

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

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/user', [AuthController::class, 'user']);
    Route::post('/sign-in', [AuthController::class, 'sign_in']);
    Route::post('/send-code', [AuthController::class, 'send_code']);
    Route::post('/verify-code', [AuthController::class, 'verify_code']);
    Route::post('/customer-data', [ApiController::class, 'customer_data']);
    Route::get('/exam-center', [ApiController::class, 'exam_center']);
    Route::get('/exam-customer', [ApiController::class, 'exam_customer']);
    Route::post('/add-exam', [ApiController::class, 'add_exam']);
    Route::post('/add-exam-card', [ApiController::class, 'add_exam_card']);
});
