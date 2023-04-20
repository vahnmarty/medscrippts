<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FlashCard;
use App\Jobs\GenerateQBanks;
use App\Models\QuestionBank;
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
            $flashCard = FlashCard::firstOrCreate();
            $flashCard->categories()->attach($category->id);

            $qbank = QuestionBank::firstOrCreate();
            $qbank->categories()->attach($category->id);


            foreach($category->scripts as $script)
            {
                GenerateFlashCards::dispatch($script, $flashCard);
                GenerateQBanks::dispatch($script, $qbank);
            }
        }
    }
}
