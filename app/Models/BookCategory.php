<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BookCategory extends Pivot
{
    protected $table = 'book_category';
}
