<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Book\BookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// book route
Route::ApiResource('books', 'Book\BookController');

// author route
Route::ApiResource('authors', 'Author\AuthorController');

// Adding slug to url
// Route::post('/books', [BookController::class, 'store']);
// Route::patch('/books/{book}-{slug}', [BookController::class, 'update']);
// Route::delete('/books/{book}-{slug}', [BookController::class, 'destroy']);

// checkout route
Route::post('checkout/{book}', 'CheckOut\CheckOutController@store');

// checkIn route
Route::post('checkin/{book}', 'CheckIN\CheckInController@store');

// login route
// Route::post('login', 'Login\LoginController@index');