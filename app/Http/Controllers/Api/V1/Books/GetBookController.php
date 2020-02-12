<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class GetBookController extends Controller
{
    public function __invoke(Request $request, Book $book)
    {
        $response = $book;
        $response['categories'] = $book->categories()->get();
        return response()->json($book, 200);
    }
}
