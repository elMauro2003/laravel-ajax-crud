<?php

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

Route::get('/', function () {
    return view('welcome');
});


// RUTAS DEL CRUD
Route::get('/crud/index', [App\Http\Controllers\ProductoController::class, 'index'])->name('crud.index');
Route::post('/crud/create', [App\Http\Controllers\ProductoController::class, 'store'])->name('crud.create');
Route::put('/crud/update/{id}', [App\Http\Controllers\ProductoController::class, 'update'])->name('crud.update');
Route::delete('/crud/destroy/{id}', [App\Http\Controllers\ProductoController::class, 'destroy'])->name('crud.destroy');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
