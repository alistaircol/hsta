<?php

namespace App\Http\Controllers\Api\V1\Categories;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class GetCategoriesController extends Controller
{
    public function __invoke(Request $request)
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }
}
