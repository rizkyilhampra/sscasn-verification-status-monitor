<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'rizky',
            'email' => 'rizkyilhamp16@gmail.com',
            'password' => bcrypt('password'),
            'phone_number' => '628998039978',
        ]);
    }
}
