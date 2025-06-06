<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CompletedTaskController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\UserController;

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

// タスク管理システム
Route::get('/', [AuthController::class, 'index'])->name('front.index');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user/register', [UserController::class, 'index']);
Route::post('/user/register', [UserController::class, 'register']);

// 認可処理
Route::middleware(['auth'])->group(function () {
    Route::prefix('/task')->group(function () {
        Route::get('/list', [TaskController::class, 'list']);
        Route::post('/register', [TaskController::class, 'register']);
        Route::get('/detail/{task_id}', [TaskController::class, 'detail'])->whereNumber('task_id')->name('detail');
        Route::get('/edit/{task_id}', [TaskController::class, 'edit'])->whereNumber('task_id')->name('edit');
        Route::put('/edit/{task_id}', [TaskController::class, 'editSave'])->whereNumber('task_id')->name('edit_save');       
        Route::delete('/delete/{task_id}', [TaskController::class, 'delete'])->whereNumber('task_id')->name('delete');
        Route::post('/complete/{task_id}', [TaskController::class, 'complete'])->whereNumber('task_id')->name('complete');
        Route::get('/csv/download', [TaskController::class, 'csvDownload']);
    });
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/completed_tasks/list', [CompletedTaskController::class, 'list']);

});
// 管理画面
Route::prefix('/admin')->group(function () {
    Route::get('', [AdminAuthController::class, 'index'])->name('admin.index');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/top', [AdminHomeController::class, 'top'])->name('admin.top');
        Route::get('/logout', [AdminAuthController::class, 'logout']);
        Route::get('/user/list', [AdminUserController::class, 'list'])->name('admin.user.list');
    });
});

// テスト用
Route::get('/welcome', [WelcomeController::class, 'index']);
Route::get('/welcome/second', [WelcomeController::class, 'second']);
// form入力テスト用
Route::get('/test', [TestController::class, 'index']);
Route::post('/test/input', [TestController::class, 'input']);