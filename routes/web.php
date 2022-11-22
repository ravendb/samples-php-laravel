<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TasksController;
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
    return redirect('/tasks');
});


Route::get('/tasks', [TasksController::class, 'list'])
    ->name('tasks');

Route::delete('/tasks/{id}', [TaskController::class, 'delete'])
    ->where('id', '.*')
    ->name('task.delete');

Route::patch('/tasks/{id}', [TaskController::class, 'patch'])
    ->where('id', '.*')
    ->name('task.patch');
