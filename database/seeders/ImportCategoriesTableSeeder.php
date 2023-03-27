<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ImportCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = database_path('imports/categories.csv');

        $handle = fopen($file, 'r');

        // Skip the first line
        fgetcsv($handle);

        // Loop through the remaining lines
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $name = $data[0];
            $image = explode(' ', $data[1]);
            Category::firstOrCreate(
                [ 'name' => $name  ] ,
                [
                    'image_name' => $image[0],
                    'image_url' => preg_replace('/^\(|\)$/', '', $image[1]) //removing parenthesis
                ]
            );
        }
    }
}
