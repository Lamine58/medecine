<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\Auth\AuthController;

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

    #utilisateur
    Route::get('/liste-des-administrateurs', [UserController::class, 'index'])->name('user.index');
    Route::get('/utilisateur/{id}', [UserController::class, 'add'])->name('user.add');
    Route::post('/save-user', [UserController::class, 'save'])->name('user.save');
    Route::get('/delete-user', [UserController::class, 'delete'])->name('user.delete');

    Route::middleware(['admin'])->group(function () {
        Route::get('/liste-des-centres-de-santes', [BusinessController::class, 'index'])->name('business.index');
        Route::get('/centre-de-sante/{id}', [BusinessController::class, 'add'])->name('business.add');
        Route::post('/save-business', [BusinessController::class, 'save'])->name('business.save');
        Route::get('/delete-business', [BusinessController::class, 'delete'])->name('business.delete');
    });

});