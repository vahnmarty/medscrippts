<?php

namespace App\Http\Livewire\FlashCard;

use Auth;
use Livewire\Component;
use App\Models\Category;
use App\Models\FlashCard;
use App\Models\FlashCardRecord;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;

class FlashCardMobile extends Component implements HasForms
{
    use InteractsWithForms;

    public $categories = [], $max = 20;
    
    public function render()
    {
        $flash_cards = FlashCardRecord::with('categories')->withCount('items')->where('user_id', auth()->id())->get();

        return view('livewire.flash-card.flash-card-mobile', compact('flash_cards'));
    }

    public function mount()
    {

    }

    public function getFormSchema()
    {
        return [
            Select::make('categories')
                ->required()
                ->multiple()
                ->options(Category::has('flashcards')->get()->pluck('name', 'id')),
            TextInput::make('max')
                ->maxValue(30)
                ->numeric()
                ->disabled()
                ->required()
        ];
    }

    public function save()
    {
        $data = $this->form->getState();
        
        $record = FlashCardRecord::create(['user_id' => Auth::id()]);
        $record->categories()->attach($data['categories']);
        $ids = FlashCard::whereIn('category_id', $data['categories'])->inRandomOrder()->limit($data['max'])->pluck('id')->toArray();
        $record->items()->attach($ids);

        return redirect()->route('flashcard.play', $record->id);
    }
}
