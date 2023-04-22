<?php

namespace App\Http\Livewire\QuestionBank;

use Auth;
use Livewire\Component;
use App\Models\QuestionBank;
use App\Models\QuestionBankRecord;

class PlayQuestionBank extends Component
{
    public $results = [], $index = 0;

    public $end, $score, $passed, $passing_pct = 60;

    public $has_answered;

    public $qbank_record_id;

    public function render()
    {
        return view('livewire.question-bank.play-question-bank')->layout('layouts.slider');
    }

    public function mount($id)
    {
        $this->qbank_record_id = $id;
        $flashCard = QuestionBankRecord::with('items')->find($id);

        $items = $flashCard->items->toArray();
        

        $collect = collect($items)->map(function($item){
            $item['is_correct'] = null;
            $item['selected_option'] = null;
            return $item;
        })->all();

        $this->results = $collect;
        
    }

    public function next()
    {
        $this->index++;

        if(empty($this->results[$this->index])){
            $this->end = true;
            $this->complete();
        }

        $this->reset('has_answered');
    }

    public function complete()
    {
        $qbank = QuestionBankRecord::find($this->qbank_record_id);

        $score = collect($this->results)->where('is_correct', true)->count();

        $qbank->update([
            'score' => $score
        ]);

        $this->score = $score;

        $this->passed = ($score / count($this->results) * 100) >= $this->passing_pct;
    }

    public function exit()
    {
        return redirect('qbanks');
    }

    public function retake()
    {
        return redirect(request()->header('Referer'));
        
        $this->end = false;
        $this->index = 0;
        
    }

    public function selectAnswer(int $index, $option)
    {
        $item = $this->results[$index];
        $this->results[$index]['selected_option'] = $option;

        if($item['option_answer'] == $option){
            $this->results[$index]['is_correct'] = true;
        }

        $this->has_answered = true;
    }
}
