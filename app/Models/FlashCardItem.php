<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashCardItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function flashcard()
    {
        return $this->belongsTo(FlashCard::class);
    }
}
