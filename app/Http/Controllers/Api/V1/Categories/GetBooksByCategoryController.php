<?php

namespace App\Http\Controllers\Api\V1\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class GetBooksByCategoryController  extends Controller
{
    public function __invoke(Request $request, Category $category)
    {
        $response = [];
        $response['category'] = $category;
        $response['books'] = $category->books()->get();
        return response()->json($response, 200);
    }
}
