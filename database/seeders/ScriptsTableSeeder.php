<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ScriptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cardiology = Category::where('name', 'Cardiology')->first();

        $script = Script::firstOrCreate(
            [
                'title' => "Crohn's Disease"
            ],
            [
                'pathophysiology' => 'Transmural Inflamatory disorder of the tract',
                'epidemiology' => 'Epi',
                'signs' => 'Signs',
                'diagnostics' => 'Testing & Diagnostics',
                'notes' => ''
            ]
        );
    }
}
