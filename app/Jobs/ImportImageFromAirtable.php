<?php

namespace App\Jobs;

use Storage;
use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ImportImageFromAirtable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Category $category;

    public $url;

    /**
     * Create a new job instance.
     */
    public function __construct(Category $category, $url)
    {
        $this->category = $category;
        $this->url = $url;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $image_url = $this->url;
        $category = $this->category;

        
        $fileContents = file_get_contents($image_url);
        $fileName = basename($image_url);
        Storage::disk('public')->put('categories/'. $fileName, $fileContents);
        $category->image = 'categories/'. $fileName;
        $category->save();
    }
}
