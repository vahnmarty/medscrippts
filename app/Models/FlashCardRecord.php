<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashCardRecord extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'flash_card_record_categories');
    }

    public function items()
    {
        return $this->belongsToMany(FlashCard::class, 'flash_card_record_items');
    }

}
