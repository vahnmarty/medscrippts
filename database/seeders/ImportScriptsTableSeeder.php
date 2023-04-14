<?php

namespace Database\Seeders;

use App\Models\Script;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ImportScriptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = database_path('imports/scripts.csv');

        $handle = fopen($file, 'r');

        // Skip the first line
        fgetcsv($handle);

        // Loop through the remaining lines
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $title = $data[0];
            $pediatric_adult = $data[1];
            $category_name = $data[2] ?? '';
            $path = $data[3] ?? '' ;
            $epi = $data[4] ?? '' ;
            $signs = $data[5] ?? '' ;
            $diagnosis = $data[6] ?? '';
            $treatments = $data[7] ?? '';
            $link = $data[8] ?? '';
            $image_url = $data[9] ?? null;

            $category = $category_name ? Category::where('name', $category_name)->first() : null;

            $script = Script::firstOrCreate(
                [ 'title' => $title  ] ,
                [
                    'category_id' => $category?->id,
                    'pathophysiology' => $path,
                    'epidemiology' => $epi,
                    'signs' => $signs,
                    'diagnosis' => $diagnosis,
                    'treatments' => $treatments,
                    'notes' => ''
                ]
            );

            if($script)
            {
                if($link){
                    $script->links()->firstOrCreate(['url' => $link]);
                }
                

                if($image_url){
                    $script->images()->firstOrCreate([
                        'url' => $image_url,
                        'filename' => basename($image_url)
                    ]);
                }
                
            }
        }
    }
}
