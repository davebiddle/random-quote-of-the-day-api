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
<<<<<<< HEAD
=======
        $this->call(UserSeeder::class);
>>>>>>> feature/add-quotes-api
        $this->call(QuoteSeeder::class);
    }
}
