<?php

use App\Http\Controllers\CommentController;
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
    Route::get('/upload',[MahasiswaController::class,'upload'])->name('upload');
    Route::get('/proposal3',[MahasiswaController::class,'proposal3'])->name('proposal3');
    Route::get('/editProposal/{id}',[MahasiswaController::class, 'editProposal'])->name('editProposal');
    Route::get('/viewProposal/{id}',[MahasiswaController::class,'viewProposal'])->name('viewProposal');
    Route::get('/editTa/{id}',[MahasiswaController::class, 'editTa'])->name('editTA');
    Route::get('/magang',[MahasiswaController::class,'magang'])->name('magang');

    Route::get('/laporan',[MahasiswaController::class, 'laporan'])->name('laporan');
    Route::put('/laporan2/{id}',[MahasiswaController::class, 'laporan2'])->name('laporan2');
    Route::get('/syarat',[MahasiswaController::class, 'syarat'])->name('syarat');
    ROute::get('home',[MahasiswaController::class, 'home'])->name('home');

    Route::get('/ta',[MahasiswaController::class, 'ta'])->name('ta');
    Route::get('/ta2',[MahasiswaController::class, 'ta2'])->name('ta2');
    Route::get('/ta3',[MahasiswaController::class, 'ta3'])->name('ta3');

    Route::get('/magang',[MahasiswaController::class, 'magang'])->name('magang');


    Route::get('/bimbingan',[MahasiswaController::class, 'bimbingan'])->name('bimbingan');
    Route::get('/create',[MahasiswaController::class, 'create'])->name('create');
    Route::get('/edit/{id}',[MahasiswaController::class, 'edit'])->name('edit');
    Route::put('/update2/{id}',[MahasiswaController::class, 'update2'])->name('update2');

    Route::get('/bimbingan2',[MahasiswaController::class, 'bimbingan2'])->name('bimbingan2');

    Route::get('/chat',[MahasiswaController::class,'chat'])->name('chat');
    Route::get('/fetchChat',[MahasiswaController::class,'fetchMessages'])->name('fetchMessages');
    Route::post('/message',[MahasiswaController::class,'message'])->name('message');
    Route::get('/check-new-messages',[MahasiswaController::class,'new-messages'])->name('new-messages');
    Route::post('/store',[MahasiswaController::class, 'store'])->name('store');
    Route::put('/store2',[MahasiswaController::class, 'store2'])->name('store2');
    Route::post('/store3',[MahasiswaController::class, 'store3'])->name('store3');
    Route::post('/store4',[MahasiswaController::class, 'store4'])->name('store4');
    Route::post('/store5',[MahasiswaController::class, 'store5'])->name('store5');
    Route::put('/store5',[MahasiswaController::class],'store5')->name('putstore');
    Route::post('/store6',[MahasiswaController::class, 'store6'])->name('store6');
    Route::post('/storeMagang',[MahasiswaController::class,'storeMagang'])->name('storeMagang');
    Route::put('/storeMagang',[MahasiswaController::class,'storeMagang'])->name('putMagang');
    Route::post('/storeIpk',[MahasiswaController::class,'storeIpk'])->name('storeIpk');
    Route::put('/storeIpk',[MahasiswaController::class,'storeIpk'])->name('putIpk');
    Route::post('/comment',[MahasiswaController::class,'comment'])->name('comment');
    Route::get('/mark-as-read/{id}', [MahasiswaController::class, 'markAsRead'])->name('markAsRead');

    Route::post('/update',[MahasiswaController::class, 'update'])->name('update');
    Route::put('/update3/{id}',[MahasiswaController::class, 'update3'])->name('update3');
    Route::put('/update4/{id}',[MahasiswaController::class, 'update4'])->name('update4');

    Route::delete('/delete/{id}',[MahasiswaController::class, 'delete'])->name('delete');

});

Route::group(['prefix'=> 'dmn', 'middleware' => ['auth:dosen'],'as'=> 'dmn.'],function(){
    Route::get('/proposal',[DosenController::class,'proposal'])->name('proposal');
    Route::get('/proposal/{id}',[DosenController::class,'rekapp'])->name('rekapp');
    Route::get('/proposal4',[DosenController::class,'proposal4'])->name('proposal4');
    Route::get('/proposal2',[DosenController::class,'proposal2'])->name('proposal2');
    Route::get('/proposal3',[DosenController::class,'proposal3'])->name('proposal3');
    Route::get('/dashboard',[DosenController::class,'dashboard'])->name('dashboard');
    Route::get('/bimbingan',[DosenController::class,'dbimbingan'])->name('dbimbingan');
    Route::get('/bimbingan/{id}',[DosenController::class,'bimbingan'])->name('bimbingan');
    Route::get('/bimbingan2',[DosenController::class,'dbimbingan2'])->name('dbimbingan2');
    Route::get('/bimbingan2/{id}',[DosenController::class,'bimbingan2'])->name('bimbingan2');
    Route::get('/bimbingan2/{id}/detail',[DosenController::class,'detailb2'])->name('detailb2');
    Route::get('/bimbingan2/{id}/edit',[DosenController::class,'edit2'])->name('edit2');
    Route::get('/dashboardm',[DosenController::class,'dashboardm'])->name('dashboardm');
    Route::get('/bimbingan/{id}/detail',[DosenController::class, 'detailb'])->name('detailb');
    Route::get('/bimbingan/{id}/edit',[DosenController::class,'edit'])->name('edit');
    Route::get('/persetujuan/{id}',[DosenController::class,'setujubp'])->name('setujubp');
    Route::get('/persetujuan2/{id}',[DosenController::class,'setujup'])->name('setujup');
    Route::get('/persetujuan3/{id}',[DosenController::class,'setujut'])->name('setujut');
    Route::get('/persetujuan4/{id}',[DosenController::class,'setujubt'])->name('setujubt');
    Route::get('/chat',[DosenController::class,'chat'])->name('chat');
    Route::get('/chat/{id}',[DosenController::class,'getchat'])->name('getchat');
    Route::get('/fetchChat/{npm}',[DosenController::class,'fetchMessages'])->name('fetchMessages');
    Route::post('/message',[DosenController::class,'message'])->name('message');
    Route::get('/mark-as-read/{id}', [DosenController::class, 'markAsRead'])->name('markAsRead');
   

    Route::get('/laporan',[DosenController::class,'laporan'])->name('laporan');
    Route::put('/laporan2',[DosenController::class,'laporan2'])->name('laporan2');

    Route::get('/ta',[DosenController::class,'ta'])->name('ta');
    Route::get('/ta/{id}',[DosenController::class,'rekapt'])->name('rekapt');
    Route::get('/ta2',[DosenController::class,'ta2'])->name('ta2');
    Route::get('/ta3',[DosenController::class,'ta3'])->name('ta3');
    Route::get('/viewTa/{id}',[DosenController::class,'viewTa'])->name('viewTa');

    Route::post('/store',[DosenController::class,'store'])->name('store');
    Route::post('/store2',[DosenController::class,'store2'])->name('store2');
    Route::post('/update',[DosenController::class,'update'])->name('update');
    Route::put('/update2',[DosenController::class,'update2'])->name('update2');
    Route::put('/update3',[DosenController::class,'update3'])->name('update3');
    Route::put('/update4',[DosenController::class,'update4'])->name('update4');

});

Route::group(['prefix'=> 'admin', 'middleware' => ['auth:admin'],'as'=> 'admin.'],function(){


    Route::get('/home',[HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/user',[HomeController::class, 'index'])->name('index');
    Route::get('/ta',[HomeController::class, 'ta'])->name('ta');
    Route::get('/syarat',[HomeController::class, 'syarat'])->name('syarat');
    Route::get('/syarat/{id}',[HomeController::class, 'syarat2'])->name('syarat2');
    Route::get('/viewSyarat/{id}',[HomeController::class,'viewSyarat'])->name('viewSyarat');
    Route::put('/update3',[HomeController::class, 'update3'])->name('update3');
    Route::get('/bimbingan/{id}',[HomeController::class,'bimbingan'])->name('bimbingan');
    Route::get('/bimbingan2/{id}',[HomeController::class,'bimbingan2'])->name('bimbingan2');

    Route::get('/mahasiswa',[HomeController::class, 'mahasiswa'])->name('mahasiswa');
    Route::get('/domen',[HomeController::class, 'domen'])->name('domen');
    Route::get('/create',[HomeController::class, 'create'])->name('create');
    Route::get('/create2',[HomeController::class, 'create2'])->name('create2');
    Route::get('/create3',[HomeController::class, 'create3'])->name('create3');
    Route::get('/edit/{id}',[HomeController::class, 'edit'])->name('edit');
    Route::get('/edit2/{id}',[HomeController::class, 'edit2'])->name('edit2');
    Route::put('/update/{id}',[HomeController::class, 'update'])->name('update');
    Route::put('/update2/{id}',[HomeController::class, 'update2'])->name('update2');
    
    Route::post('/store',[HomeController::class, 'store'])->name('store');
    Route::post('/store2',[HomeController::class,'store2'])->name('store2');
    Route::delete('/delete/{id}',[HomeController::class, 'delete'])->name('delete');
    Route::delete('/delete2/{id}',[HomeController::class, 'delete2'])->name('delete2');
});




