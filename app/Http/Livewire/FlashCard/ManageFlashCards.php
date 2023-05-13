<?php

namespace App\Http\Livewire\FlashCard;

use Auth;
use Livewire\Component;
use App\Models\Category;
use App\Models\FlashCard;
use App\Models\FlashCardRecord;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use App\Http\Livewire\Traits\AgentLayoutTrait;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ManageFlashCards extends Component  implements HasForms
{
    use InteractsWithForms;

    public $flash_cards = [];

    public $categories = [], $max = 20;

    public $widget_decks = 0, $widget_generated = 0, $widget_reviewed = 0;
    
    public function render()
    {
        return view('livewire.flash-card.manage-flash-cards');
    }

    public function mount()
    {
        $this->flash_cards = FlashCardRecord::withCount('items')->where('user_id', auth()->id())->get();

        $this->widget_decks = count($this->flash_cards);
        $this->widget_generated = FlashCard::where('user_id', auth()->id())->count();
        $this->widget_reviewed = FlashCardRecord::where('user_id', auth()->id())->sum('reviewed');
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
                ->minValue(5)
                ->numeric()
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
