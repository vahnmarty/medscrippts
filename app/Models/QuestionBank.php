<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBank extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(QuestionBankItem::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'question_bank_categories');
    }

    public function records()
    {
        return $this->hasMany(QuestionBankRecord::class);
    }
}
