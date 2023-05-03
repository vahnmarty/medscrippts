<?php

namespace App\Http\Livewire\FlashCard;

use Auth;
use Livewire\Component;
use App\Models\FlashCard;
use App\Models\FlashCardRecord;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use App\Http\Livewire\Traits\AgentLayoutTrait;
use Filament\Tables\Concerns\InteractsWithTable;

class ManageFlashCards extends Component 
{
    use AgentLayoutTrait;

    public $flash_cards = [];
    
    public function render()
    {
        return view('livewire.flash-card.manage-flash-cards');
    }

    public function mount()
    {
        $this->flash_cards = FlashCardRecord::get();
    }
    
}
