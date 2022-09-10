<?php

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
    //return view('welcome');
    return redirect('/students');
});
Route::post('/students/status/update', [App\Http\Controllers\StudentController::class, 'updateStatus'])->name('students.status.update');
Route::get('/students/create', [App\Http\Controllers\StudentController::class, 'create'])->name('students.create');
Route::get('/students', [App\Http\Controllers\StudentController::class, 'index'])->name('students.index');
Route::post('/students', [App\Http\Controllers\StudentController::class, 'store'])->name('students.store');
Route::get('/students/{student}', [App\Http\Controllers\StudentController::class, 'show'])->name('students.show');
Route::get('/students/{student}/edit', [App\Http\Controllers\StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{student}', [App\Http\Controllers\StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{student}', [App\Http\Controllers\StudentController::class, 'destroy'])->name('students.destroy');

