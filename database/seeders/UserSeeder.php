<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default credentials
        \App\Models\User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@mantanprogrammer.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$2fMPnKiTvwBQqJM0pMtVN.toJ4kBymCopvuYk4iwL6gPyIXln6T3u', // password
                'gender' => 'male',
                'active' => 1,
                'remember_token' => Str::random(10)
            ]
        ]);

        // Fake users
        User::factory()->times(9)->create();
    }
}
