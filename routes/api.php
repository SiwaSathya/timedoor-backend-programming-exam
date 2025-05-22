<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BE\RatesController;
use App\Http\Controllers\BE\BookController;
use App\Http\Controllers\BE\AuthorController;
use App\Http\Controllers\BE\BookCategoriesController;
use App\Models\BookCategories;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::resource('rates', RatesController::class);
Route::resource('authors', AuthorController::class);
Route::resource('book_categories', BookCategoriesController::class);
Route::get('/books-index', [BookController::class, 'getBooks']);
Route::get('/get-book-by-author/{id}', [BookController::class, 'getBookByAuthorId']);
Route::get('/get-all-author', [AuthorController::class, 'getAllAuthor']);




