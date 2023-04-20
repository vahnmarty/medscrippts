<?php

namespace Database\Seeders;

use Storage;
use App\Models\Category;
use App\Services\Airtable;
use Illuminate\Database\Seeder;
use App\Jobs\ImportImageFromAirtable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ImportCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        foreach($this->getCategories() as $item)
        {
            $category = Category::firstOrCreate([ 
                'name' => $item['fields']['Name'] 
            ]);

            foreach($item['fields']['image'] as $image)
            {
                $image_url = $image['url'];

                if (filter_var($image_url, FILTER_VALIDATE_URL)) {
                    ImportImageFromAirtable::dispatch($category, $image_url);
                }
            }
            
        }
    }


    public function fromCsv(): void
    {
        $file = database_path('imports/categories-airtable.csv');

        $handle = fopen($file, 'r');

        // Skip the first line
        fgetcsv($handle);

        // Loop through the remaining lines
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $name = $data[0];
            $image = explode(' ', $data[1]);
            $image_url = preg_replace('/^\(|\)$/', '', $image[1]);

            $category = Category::firstOrCreate([ 'name' => $name]);

            if (filter_var($image_url, FILTER_VALIDATE_URL)) {
                $fileContents = file_get_contents($image_url);
                $fileName = basename($image_url);

                Storage::disk('public')->put('categories/'. $fileName, $fileContents);

                $category->image = 'categories/'. $fileName;
                $category->save();
            } 
        }
    }

    public function getCategories()
    {
        return (new Airtable)->getCategories()['records'];
    }
}
