<?php

namespace App\Models;

use App\Http\Requests\Api\V1\Books\AddBookRequest;
use Illuminate\Support\Facades\DB;

class Book extends UuidModel
{
    protected $table = 'books';
    protected $fillable = [
        'isbn',
        'title',
        'author',
        'price_amount',
        'price_currency',
    ];

    /**
     * For retrieving books categories when fetching book info
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category')
            ->using('App\Models\BookCategory');
    }

    /**
     * For adding book to categories when adding new books.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function category()
    {
        return $this->hasMany('App\Models\BookCategory');
    }

    /**
     * @param AddBookRequest $request
     * @return Book|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public static function addBook(AddBookRequest $request)
    {
        $categories = Category::whereIn('name', $request->input('category'))->get();

        try {
            DB::beginTransaction();

            $book = new self();
            $book->isbn = $request->input('isbn');
            $book->title = $request->input('title');
            $book->author = $request->input('author');
            $book->price_amount = $request->input('price_amount');
            $book->price_currency = $request->input('price_currency');
            $book->save();

            // Add the books categories
            $book_category = [];
            foreach ($categories as $category) {
                $book_category[] = [
                    'category_id' => $category->id,
                ];
            }
            $book->category()->createMany($book_category);

            $book_id = $book->id;
            $book = self::with('categories')->where('id', $book_id)->get();

            DB::commit();

            return $book;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
