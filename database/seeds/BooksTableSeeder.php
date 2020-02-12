<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            'id' => '3d75c4a7-bbd5-425f-9ffc-b9487e7b627f',
            'isbn' => '9781491918661',
            'title' => 'Learning PHP, MySQL & JavaScript: With jQuery, CSS & HTML5',
            'author' => 'Robin Nixon',
            'price_amount' => 9.99,
            'price_currency' => 'GBP',
        ]);
        DB::table('book_category')->insert([
            'book_id' => '3d75c4a7-bbd5-425f-9ffc-b9487e7b627f',
            'category_id' => Category::where('name', 'PHP')->first()->id,
        ]);
        DB::table('book_category')->insert([
            'book_id' => '3d75c4a7-bbd5-425f-9ffc-b9487e7b627f',
            'category_id' => Category::where('name', 'Javascript')->first()->id,
        ]);


        DB::table('books')->insert([
            'id' => '35c54504-fb78-4973-8944-b64cd463cbd5',
            'isbn' => '9780596804848',
            'title' => 'Ubuntu: Up and Running: A Power User\'s Desktop Guide',
            'author' => 'Robin Nixon',
            'price_amount' => 12.99,
            'price_currency' => 'GBP',
        ]);
        DB::table('book_category')->insert([
            'book_id' => '35c54504-fb78-4973-8944-b64cd463cbd5',
            'category_id' => Category::where('name', 'Linux')->first()->id,
        ]);

        DB::table('books')->insert([
            'id' => '3058004c-83f5-4223-849c-ed02e0d2ff05',
            'isbn' => '9781118999875',
            'title' => 'Linux Bible',
            'author' => 'Christopher Negus',
            'price_amount' => 19.99,
            'price_currency' => 'GBP',
        ]);
        DB::table('book_category')->insert([
            'book_id' => '3058004c-83f5-4223-849c-ed02e0d2ff05',
            'category_id' => Category::where('name', 'Linux')->first()->id,
        ]);

        DB::table('books')->insert([
            'id' => 'e6ae70ca-9018-4471-b821-566931d0da3e',
            'isbn' => '9780596517748',
            'title' => 'JavaScript: The Good Parts',
            'author' => 'Douglas Crockford',
            'price_amount' => 8.99,
            'price_currency' => 'GBP',
        ]);
        DB::table('book_category')->insert([
            'book_id' => 'e6ae70ca-9018-4471-b821-566931d0da3e',
            'category_id' => Category::where('name', 'Javascript')->first()->id,
        ]);
    }
}
