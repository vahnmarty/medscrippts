<?php

namespace App\Http\Livewire\FlashCard;

use Livewire\Component;
use App\Models\FlashCardRecord;

class FlashCardMobile extends Component
{
    public function render()
    {
        $flash_cards = FlashCardRecord::with('categories')->withCount('items')->where('user_id', auth()->id())->get();

        return view('livewire.flash-card.flash-card-mobile', compact('flash_cards'));
    }

    public function mount()
    {

    }
}
