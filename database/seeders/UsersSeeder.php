<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if ($this->command->confirm('truncate first ?', true)) {
            User::truncate();
        }

        User::create([
            'name' => 'Admin',
            'email' => 'admin@deka.dev',
            'password' => bcrypt('qweasdzxc'),
            'email_verified_at' => now(),
        ]);
    }
}
