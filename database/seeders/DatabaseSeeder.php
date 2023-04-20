<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ImportCategoriesTableSeeder::class);
        $this->call(ImportScriptsTableSeeder::class);
        $this->call(PlansTableSeeder::class);
        $this->call(GenerateScriptQuizSeeder::class);
    }
}
