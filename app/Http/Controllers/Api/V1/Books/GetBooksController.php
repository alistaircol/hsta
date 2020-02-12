<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Books\GetBooksRequest;
use App\Models\Book;

class GetBooksController extends Controller
{
    public function __invoke(GetBooksRequest $request)
    {
        $books = Book::with('categories');

        if ($request->has('author') && $request->input('author')) {
            $books->where('author', $request->input('author'));
        }

        if ($request->has('category') && $request->input('category')) {
            $books->whereHas('categories', function ($query) use ($request) {
                $query->where('name', $request->input('category'));
            });
        }

        $response = $books->get();

        return response()->json($response, 200);
    }
}
