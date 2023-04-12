<?php

namespace App\Http\Livewire;

use Log;
use Livewire\Component;
use App\Models\Category;
use App\Models\FlashCard;
use OpenAI\Laravel\Facades\OpenAI;

class QBank extends Component
{
    public $results = [], $index = 0;

    public function render()
    {
        return view('livewire.q-bank')->layout('layouts.slider');
    }

    public function mount($flashCardId)
    {
        $flashCard = FlashCard::with('cards')->find($flashCardId);

        $this->results = $flashCard->cards;
    }

    public function next()
    {
        $this->index++;
    }

    public function exit()
    {
        return redirect('dashboard');
    }


    
}
