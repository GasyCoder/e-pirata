<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::where('id', '>', 0)->delete();

        // admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@pirata.fr',
            'password' => Hash::make('admin+123'),
            'email_verified_at' => now(),
        ]);
    }
}
