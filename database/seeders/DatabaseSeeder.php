<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\EnigmaSeeder;
use Database\Seeders\ChapterSeeder;
use Database\Seeders\InitialDataSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EnigmaSeeder::class,
            ChapterSeeder::class,
            InitialDataSeeder::class,
        ]);
    }
}
