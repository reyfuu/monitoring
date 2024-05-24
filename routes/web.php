<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use DebugBar\DebugBar;
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

Route::get('/',[LoginController::class,'index'])->name('login');
Route::post('/login-proses',[LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout',[LoginController::class, 'logout'])->name('logout');

Route::group(['prefix'=> 'mhs', 'middleware' => ['auth'],'as'=> 'mhs.'],function(){
    Route::get('/proposal',[MahasiswaController::class, 'proposal'])->name('proposal');
    Route::get('/proposal2',[MahasiswaController::class, 'proposal2'])->name('proposal2');
    Route::get('/proposal3',[MahasiswaController::class,'proposal3'])->name('proposal3');
    Route::get('/laporan',[MahasiswaController::class, 'laporan'])->name('laporan');
    Route::get('/laporan2',[MahasiswaController::class, 'laporan2'])->name('laporan2');
    Route::get('/laporan3',[MahasiswaController::class, 'laporan3'])->name('laporan3');
    Route::get('/ta',[MahasiswaController::class, 'ta'])->name('ta');
    Route::get('/ta2',[MahasiswaController::class, 'ta2'])->name('ta2');
    Route::get('/ta3',[MahasiswaController::class, 'ta3'])->name('ta3');
    Route::post('/store',[MahasiswaController::class, 'store'])->name('store');
});

Route::group(['prefix'=> 'dmn', 'middleware' => ['auth:dosen'],'as'=> 'dmn.'],function(){
    Route::get('/proposal',[DosenController::class,'proposal'])->name('proposal');
    Route::get('/proposal2',[DosenController::class,'proposal2'])->name('proposal2');
    Route::get('/proposal3',[DosenController::class,'proposal3'])->name('proposal3');
    Route::get('/laporan',[DosenController::class,'laporan'])->name('laporan');
    Route::get('/laporan2',[DosenController::class,'laporan2'])->name('laporan2');
    Route::get('/ta',[DosenController::class,'ta'])->name('ta');
    Route::get('/ta2',[DosenController::class,'ta2'])->name('ta2');
    Route::get('/ta3',[DosenController::class,'ta3'])->name('ta3');
});

Route::group(['prefix'=> 'admin', 'middleware' => ['auth:admin'],'as'=> 'admin.'],function(){


    Route::get('/home',[HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/user',[HomeController::class, 'index'])->name('index');

    Route::get('/create',[HomeController::class, 'create'])->name('create');
    Route::get('/create2',[HomeController::class, 'create2'])->name('create2');
    Route::get('/create3',[HomeController::class, 'create3'])->name('create3');
    Route::get('/edit/{id}',[HomeController::class, 'edit'])->name('edit');
    Route::get('/edit2/{id}',[HomeController::class, 'edit2'])->name('edit2');
    Route::put('/update/{id}',[HomeController::class, 'update'])->name('update');
    Route::put('/update2/{id}',[HomeController::class, 'update2'])->name('update2');
    
    Route::post('/store',[HomeController::class, 'store'])->name('store');
    Route::delete('/delete/{id}',[HomeController::class, 'delete'])->name('delete');
    Route::delete('/delete2/{id}',[HomeController::class, 'delete2'])->name('delete2');
});




