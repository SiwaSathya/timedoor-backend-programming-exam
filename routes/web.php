<?php

use App\Http\Controllers\FE\RatesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FE\BookController;
use App\Http\Controllers\FE\AuthorController;

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





Route::get('/', [BookController::class, 'index']);
Route::get('/top-authors', [AuthorController::class, 'topAuthors']);
Route::get('/rating-author-book',[RatesController::class, 'index']);
