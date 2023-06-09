<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scripts()
    {
        return $this->hasMany(Script::class);
    }

    public function masterScripts()
    {
        return $this->hasMany(Script::class)->whereNull('user_id');
    }

    public function userScripts()
    {
        return $this->hasMany(Script::class)->where('user_id', auth()->id());
    }

    public function questions()
    {
        return $this->hasMany(QuestionBank::class);
    }

    public function flashcards()
    {
        return $this->hasMany(FlashCard::class);
    }
}
