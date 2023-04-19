<?php

namespace App\Http\Livewire\QuestionBank;

use Livewire\Component;
use App\Models\QuestionBank;

class PlayQuestionBank extends Component
{
    public $results = [], $index = 0;

    public $end;

    public $flash_card_id;

    public function render()
    {
        return view('livewire.question-bank.play-question-bank')->layout('layouts.slider');
    }

    public function mount($id)
    {
        $this->flash_card_id = $id;
        $flashCard = QuestionBank::with('items')->find($id);

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

            $flashCard = FlashCard::find($this->flash_card_id);
            $flashCard->reviews = $flashCard->reviews+1;
            $flashCard->save();
        }
    }

    public function exit()
    {
        return redirect('dashboard');
    }

    public function retake()
    {
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
    }
}
