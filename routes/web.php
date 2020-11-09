<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Middleware\Admin;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\OnlineHandShakeController;
use App\Http\Controllers\DownloadListLocalController;
use App\Http\Controllers\DownloadListOnlineController;
use App\Http\Controllers\Auth\LoginController;
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
    return redirect()->route('downloadListLocal.show', ['status'=>'NCND', 'keyword'=>'all-data', 'amount' => '15', 'orderby' => 'tmp_title', 'order' => 'ASC']);
})->name('home.index');

Route::prefix('userManage')->name('userManage')->middleware(['auth', 'super'])->group(function () {
    Route::get('/{keyword}/{amount}/{orderby}/{order}',[UserManageController::class, 'show'])->name('.show');
    Route::get('/export/{keyword}/{amount}/{orderby}/{order}',[UserManageController::class, 'export'])->name('.export');
    Route::post('/changePermission',[UserManageController::class, 'changePermission'])->name('.changePermission');
});

// Route::namespace('Auth')->middleware(['auth', 'super'])->group(function () {
//     Route::post('/register','LoginController@process_signup');  
// });

Route::prefix('onlineHandShake')->name('onlineHandShake')->middleware('auth')->group(function () {
    Route::post('/confirmDownload',[OnlineHandShakeController::class, 'confirmDownload'])->name('.confirmDownload');
    Route::post('/denyDownload',[OnlineHandShakeController::class, 'denyDownload'])->name('.denyDownload');
    Route::post('/updateOnlineData',[OnlineHandShakeController::class, 'updateOnlineData'])->name('.updateOnlineData');
});

Route::prefix('downloadListLocal')->name('downloadListLocal')->middleware('auth')->group(function () {
    Route::get('/{status}/{keyword}/{amount}/{orderby}/{order}',[DownloadListLocalController::class, 'index'])->name('.show');
    Route::post('/downloadActionByBatch',[DownloadListLocalController::class, 'downloadActionByBatch'])->name('.downloadActionByBatch');
    Route::get('/export/{status}/{keyword}/{amount}/{orderby}/{order}',[DownloadListLocalController::class, 'export'])->name('.export');
});

Route::prefix('sync')->name('sync')->middleware('auth')->group(function () {
    Route::get('/',[SyncController::class, 'sync']);
});

Route::prefix('downloadListOnline')->name('downloadListOnline')->middleware('auth')->group(function () {
    Route::get('/{keyword}/{amount}/{orderby}/{order}/{page}',[DownloadListOnlineController::class, 'show'])->name('.show');
    Route::get('/export/{keyword}/{amount}/{orderby}/{order}/{page}',[DownloadListOnlineController::class, 'export'])->name('.export');
});

Route::prefix('productList')->name('productList')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/{keyword}/{amount}/{orderby}/{order}/{page}',[ProductListController::class, 'show'])->name('.show');
    Route::get('/export/{keyword}/{amount}/{orderby}/{order}/{page}',[ProductListController::class, 'export'])->name('.export');
});

Route::prefix('api')->name('api')->middleware('auth')->group(function () {
    Route::get('/productList/{keyword}',[ApiController::class, 'productList'])->name('.productList');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
