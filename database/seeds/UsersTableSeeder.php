<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Alistair Collins',
            'email' => 'cv@ac93.uk',
            'password' => Hash::make('password'),
            'api_token' => '123456789012345678901234567890123456789012345678901234567890',
        ]);
    }
}
