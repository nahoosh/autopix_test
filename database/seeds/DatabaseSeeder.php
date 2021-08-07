<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'name' => 'Test User',
            'email' => 'test@3sixtyfactory.com',
            'password' => Hash::make('test12345'),
        ]);
    }
}
