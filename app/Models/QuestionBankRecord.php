<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBankRecord extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'question_bank_record_categories');
    }

    public function items()
    {
        return $this->belongsToMany(QuestionBank::class, 'question_bank_record_items');
    }

    public function getCategoriesName()
    {
        return implode(', ', $this->categories()->pluck('name')->toArray());
    }
}
