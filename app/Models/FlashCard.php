<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashCard extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function cards()
    {
        return $this->hasMany(FlashCardItem::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'flash_card_categories');
    }
}
