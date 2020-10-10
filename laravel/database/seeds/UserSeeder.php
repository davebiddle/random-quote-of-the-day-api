<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add React API user for React frontend API token access
        DB::table('users')->insert([
            'name' => 'React',
            'email' => Str::random(10) . '@davebiddle.co.uk',
            'password' => Hash::make(Str::random(16)),
            'api_token' => Hash::make(Str::random(60)),
        ]);
    }
}
