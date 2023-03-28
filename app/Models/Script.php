<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Script extends Model
{
    use HasFactory;

    protected $guarded  = [];

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
}
