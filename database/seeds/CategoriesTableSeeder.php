<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'id' => '79e1b005-931c-42ab-915a-4fbd11ab7d7b',
            'category_id' => 1,
            'name' => 'PHP',
        ]);
        DB::table('categories')->insert([
            'id' => '2aed6d5c-f90c-492f-8303-8d7389bcdf2b',
            'name' => 'Javascript',
        ]);
        DB::table('categories')->insert([
            'id' => '34fa301d-f144-4f3e-928f-fef75fff039e',
            'name' => 'Linux',
        ]);

    }
}
