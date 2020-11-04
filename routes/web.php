<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\DownloadListController;
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
Route::post('login', [LoginController::class, 'authenticate']);

Route::get('/', function () {
    return redirect()->route('data', ['status'=>'all', 'keyword'=>'all-data', 'amount' => '15', 'orderby' => 'tmp_title', 'order' => 'ASC']);
})->name('home.index');

Route::post('/confirmDownload',[OnlineHandShakeController::class, 'confirmDownload'])->name('confirmDownload');
Route::post('/denyDownload',[OnlineHandShakeController::class, 'denyDownload'])->name('denyDownload');

Route::get('/downloadTmp/{status}/{keyword}/{amount}/{orderby}/{order}',[HomeController::class, 'index'])->name('data');

Route::get('/sync',[SyncController::class, 'sync'])->name('sync');

Route::get('/downloadList/{keyword}/{amount}/{orderby}/{order}/{page}',[DownloadListController::class, 'show'])->name('downloadList.show');
Route::post('/downloadActionByBatch',[DownloadListController::class, 'downloadActionByBatch'])->name('downloadList.downloadActionByBatch');

Route::get('/productList/{keyword}/{amount}/{orderby}/{order}/{page}',[ProductListController::class, 'show'])->name('productList.show');

Route::get('/api/productList/{keyword}',[ApiController::class, 'productList'])->name('api.productList');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
