<?php

namespace App\Models;

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

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category')
            ->using('App\Models\BookCategory');
    }
}
