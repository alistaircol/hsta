<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Books\AddBookRequest;
use App\Models\Book;

class AddBookController extends Controller
{
    public function __invoke(AddBookRequest $request)
    {
        try {
            $book = Book::addBook($request);
            return response()->json($book,201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong. Your book was not saved.'], 500);
        }
    }
}
