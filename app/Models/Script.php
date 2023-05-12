<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Script extends Model
{
    use HasFactory;

    protected $guarded  = [];

    protected $casts = [
        'viewed_at' => 'datetime'
    ];

    public function links(): MorphMany
    {
        return $this->morphMany(Link::class, 'linkable');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function flashcards()
    {
        return $this->hasMany(FlashCard::class);
    }

    public function qbanks()
    {
        return $this->hasMany(QuestionBank::class);
    }

    public function getNotes()
    {
        $string = '';

        $string.= "{$this->title} from category {$this->category->name}";

        $string.= ". pathophysiology: {$this->pathophysiology}; epidemiology: {$this->epidemiology}; signs and symptoms: {$this->signs}; diagnosis: {$this->diagnosis}; treatments: {$this->treatments}.";

        return $string;
    }
}
