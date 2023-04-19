<?php

namespace App\Http\Livewire\FlashCard;

use Livewire\Component;
use App\Models\FlashCard;

class PlayFlashCard extends Component
{
    public $results = [], $index = 0;

    public $end;

    public $flash_card_id;

    public function render()
    {
        return view('livewire.flash-card.play-flash-card')->layout('layouts.slider');
    }

    public function mount($id)
    {
        $this->flash_card_id = $id;
        $flashCard = FlashCard::with('cards')->find($id);

        $this->results = $flashCard->cards;
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
}
