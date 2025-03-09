<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Authentication\Models\User;
use Modules\RoadMap\Database\Seeders\CareerSeeder;
use Modules\RoadMap\Database\Seeders\QuestionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CareerSeeder::class,
            QuestionSeeder::class,
        ]);
    }
}
