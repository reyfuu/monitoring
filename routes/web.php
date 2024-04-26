<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',[LoginController::class, 'index'])->name('login');
Route::post('/login-proses',[LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout',[HomeController::class, 'logout'])->name('logout');

Route::get('/proposal',[MahasiswaController::class, 'proposal'])->name('proposal');
Route::get('/progress',[MahasiswaController::class, 'progress'])->name('progress');

Route::group(['prefix'=> 'admin', 'middleware' => ['auth'],'as'=> 'admin.'],function(){
    Route::get('/home',[HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/user',[HomeController::class, 'index'])->name('index');

    Route::get('/create',[HomeController::class, 'create'])->name('create');
    Route::get('/edit/{id}',[HomeController::class, 'edit'])->name('edit');
    Route::put('/update/{id}',[HomeController::class, 'update'])->name('update');
    
    Route::post('/store',[HomeController::class, 'store'])->name('store');
    Route::delete('/delete/{id}',[HomeController::class, 'delete'])->name('delete');
});





