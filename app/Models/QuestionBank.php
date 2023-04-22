<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBank extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function script()
    {
        return $this->belongsTo(Script::class);
    }

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

    public static function stats()
    {
        $total = 0;
        $success = 0;
        $invalid_option_answer = 0;
        $invalid_answer = 0;

        foreach(self::get() as $item)
        {
            $total++;

            $options = ['option1', 'option2', 'option3', 'option4'];

            if( in_array($item->option_answer, $options)){
                $success++;
            }else{
                $invalid_option_answer++;
            }

            $correct = false;
            foreach($options as $opt)
            {   
                if($item->$opt == $item->answer )
                {
                    $correct = true;
                    break;
                }
            }

            if(!$correct){
                $invalid_answer++;
            }
        }

        return [
            'total' => $total,
            'success' => $success,
            'invalid_option_answer' => $invalid_option_answer,
            'invalid_answer' => $invalid_answer
        ];
    }
}
