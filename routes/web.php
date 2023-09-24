<?php

use App\Http\Controllers\BookController;
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



Route::get('/',[BookController::class,'index']);
Route::get('/show',[BookController::class,'fetchAll'])->name('show');
Route::post('/store',[BookController::class,'store'])->name('store');
Route::get('/edit',[BookController::class,'edit'])->name('edit');
Route::post('/update',[BookController::class,'update'])->name('update');
Route::get('/delete',[BookController::class,'delete'])->name('delete');