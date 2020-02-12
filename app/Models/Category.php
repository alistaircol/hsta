<?php

namespace App\Models;

class Category extends UuidModel
{
    protected $table = 'categories';
    protected $fillable = [
        'name',
    ];

    public function books()
    {
        return $this->belongsToMany('App\Models\Book')
            ->using('App\Models\BookCategory');
    }
}
