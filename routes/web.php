<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function() {
    return view('welcome', ['title' => 'Welcome Laravel']);
});

Route::resource('product', ProductController::class);

// Auth Controller route
Route::get('register', [AuthController::class, 'register'])->name('auth.register');
Route::get('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('customRegister', [AuthController::class, 'customRegister'])->name('custom.register');
Route::post('customLogin', [AuthController::class, 'customLogin'])->name('custom.login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');