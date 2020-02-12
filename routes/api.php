<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// version api calls
Route::prefix('v1')->namespace('Api\V1')->middleware(['auth:api'])->group(function () {

    Route::prefix('books')->group(function () {
        // Search for books
        Route::post('/', 'Books\GetBooksController');
        // Get all details about a specific book
        Route::get('/{book}', 'Books\GetBookController');

        // Add a book
        Route::put('/', 'Books\AddBookController');
    });

    Route::prefix('categories')->group(function () {
        // list all categories
        Route::get('/', 'Categories\GetCategoriesController');

        // list all books within a category
        Route::get('/{category}', 'Categories\GetBooksByCategoryController');
    });
});
