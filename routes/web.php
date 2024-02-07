<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\TypeExamController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CustomerController;

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


Route::get('/connexion', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');

Route::middleware(['auth'])->group(function () {

    Route::get('/deconnexion', [AuthController::class, 'logout'])->name('logout');
        
    Route::get('/', function () {
        return view('dashboard.index');
    });

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
    
    Route::get('/planning', function () {
        return view('planning.index');
    })->name('planning');

    
    #adminitratuer
    Route::get('/liste-des-administrateurs', [UserController::class, 'index'])->name('user.index');
    Route::get('/utilisateur/{id}', [UserController::class, 'add'])->name('user.add');
    Route::post('/save-user', [UserController::class, 'save'])->name('user.save');
    Route::get('/delete-user', [UserController::class, 'delete'])->name('user.delete');

    #examen
    Route::get('/liste-des-types-examens', [TypeExamController::class, 'index'])->name('type_exam.index');
    Route::get('/liste-des-examens', [TypeExamController::class, 'exams'])->name('exams.index');
    Route::post('/set-result', [TypeExamController::class, 'set_result'])->name('type_exam.result');

    #utilisateur
    Route::get('/liste-des-utilisateurs', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/delete-membre', [CustomerController::class, 'delete'])->name('customer.delete');

    Route::middleware(['admin'])->group(function () {
        Route::get('/liste-des-centres-de-santes', [BusinessController::class, 'index'])->name('business.index');
        Route::get('/centre-de-sante/{id}', [BusinessController::class, 'add'])->name('business.add');
        Route::get('/type-examen/{id}', [TypeExamController::class, 'add'])->name('type_exam.add');
        Route::post('/save-business', [BusinessController::class, 'save'])->name('business.save');
        Route::post('/save-type-exam', [TypeExamController::class, 'save'])->name('type_exam.save');
        Route::post('/save-type-exam-on-business', [TypeExamController::class, 'type_exam_on_business'])->name('type_exam_on_business.save');
        Route::get('/delete-business', [BusinessController::class, 'delete'])->name('business.delete');
        Route::get('/delete-type-exam', [TypeExamController::class, 'delete'])->name('type_exam.delete');
        Route::get('/delete-type-exam-on-business', [TypeExamController::class, 'delete_type_exam_on_business'])->name('type_exam_on_business.delete');
    });

});