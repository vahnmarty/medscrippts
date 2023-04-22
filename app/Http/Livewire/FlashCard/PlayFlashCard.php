<?php

namespace App\Http\Livewire\FlashCard;

use Livewire\Component;
use App\Models\FlashCard;
use App\Models\FlashCardRecord;

class PlayFlashCard extends Component
{
    public $results = [], $index = 0;

    public $end;

    public $flash_card_record_id;

    public function render()
    {
        return view('livewire.flash-card.play-flash-card')->layout('layouts.slider');
    }

    public function mount($id)
    {
        $this->flash_card_record_id = $id;
        $flashCard = FlashCardRecord::with('items')->findOrFail($id);

        $this->results = $flashCard->items;
    }

    public function next()
    {
        $this->index++;

        if(empty($this->results[$this->index])){
            $this->end = true;

            $flashCard = FlashCardRecord::find($this->flash_card_record_id);
            $flashCard->reviewed = $flashCard->reviewed+1;
            $flashCard->save();
        }
    }

    public function exit()
    {
        return redirect('flashcards');
    }

    public function retake()
    {
        $this->end = false;
        $this->index = 0;
        
    }
}
