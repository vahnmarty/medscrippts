<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Jobs\GenerateQBanks;
use Illuminate\Database\Seeder;
use App\Jobs\GenerateFlashCards;
use App\Jobs\GenerateFlashCardsForCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GenerateScriptQuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::has('scripts')->get();

        foreach($categories as $category)
        {
            foreach($category->scripts as $script)
            {
                GenerateFlashCards::dispatch($script);
                GenerateQBanks::dispatch($script);
            }
        }
    }
}
