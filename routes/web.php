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
    Route::put('/laporan2/{id}',[MahasiswaController::class, 'laporan2'])->name('laporan2');

    Route::get('/ta',[MahasiswaController::class, 'ta'])->name('ta');
    Route::get('/ta2',[MahasiswaController::class, 'ta2'])->name('ta2');
    Route::get('/ta3',[MahasiswaController::class, 'ta3'])->name('ta3');


    Route::get('/bimbingan',[MahasiswaController::class, 'bimbingan'])->name('bimbingan');
    Route::get('/create',[MahasiswaController::class, 'create'])->name('create');
    Route::get('/edit/{id}',[MahasiswaController::class, 'edit'])->name('edit');
    Route::put('/update2/{id}',[MahasiswaController::class, 'update2'])->name('update2');

    Route::post('/store',[MahasiswaController::class, 'store'])->name('store');
    Route::put('/store2',[MahasiswaController::class, 'store2'])->name('store2');
    Route::post('/store3',[MahasiswaController::class, 'store3'])->name('store3');
    Route::post('/store4',[MahasiswaController::class, 'store4'])->name('store4');

    Route::post('/update',[MahasiswaController::class, 'update'])->name('update');
    Route::put('/update3/{id}',[MahasiswaController::class, 'update3'])->name('update3');
    Route::put('/update4/{id}',[MahasiswaController::class, 'update4'])->name('update4');

});

Route::group(['prefix'=> 'dmn', 'middleware' => ['auth:dosen'],'as'=> 'dmn.'],function(){
    Route::get('/proposal',[DosenController::class,'proposal'])->name('proposal');
    Route::get('/proposal2',[DosenController::class,'proposal2'])->name('proposal2');
    Route::get('/proposal3',[DosenController::class,'proposal3'])->name('proposal3');
    Route::get('/viewProposal/{id}',[DosenController::class,'viewProposal'])->name('viewProposal');

    Route::get('/laporan',[DosenController::class,'laporan'])->name('laporan');
    Route::get('/laporan2',[DosenController::class,'laporan2'])->name('laporan2');

    Route::get('/ta',[DosenController::class,'ta'])->name('ta');
    Route::get('/ta2',[DosenController::class,'ta2'])->name('ta2');
    Route::get('/ta3',[DosenController::class,'ta3'])->name('ta3');
    Route::get('/viewTa/{id}',[DosenController::class,'viewTa'])->name('viewTa');

    Route::post('/store',[DosenController::class,'store'])->name('store');
    Route::post('/store2',[DosenController::class,'store2'])->name('store2');

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




