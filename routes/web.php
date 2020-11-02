<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OnlineHandShakeController;
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

Route::get('/', function () {
    return redirect()->route('data', ['status'=>'all', 'keyword'=>'all-data', 'amount' => '15', 'orderby' => 'tmp_title', 'order' => 'ASC']);
})->name('home.index');
Route::post('/confirmDownload',[OnlineHandShakeController::class, 'confirmDownload'])->name('confirmDownload');
Route::get('/{status}/{keyword}/{amount}/{orderby}/{order}',[HomeController::class, 'index'])->name('data');
Route::get('/sync',[SyncController::class, 'sync'])->name('sync');
