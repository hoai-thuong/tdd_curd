<?php

use App\Http\Controllers\TaskController;
//use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'tasks'], function () {
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('/{id}/edit', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/{id}/delete', [TaskController::class, 'destroy'])->name('tasks.destroy');

    });
});
//
//Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
//Route::group(['middleware' => 'auth'], function () {
//    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
//    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
//    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
//    Route::put('/tasks/{id}/edit', [TaskController::class, 'update'])->name('tasks.update');
//    Route::delete('/tasks/{id}/delete', [TaskController::class, 'destroy'])->name('tasks.destroy');
//
//});
