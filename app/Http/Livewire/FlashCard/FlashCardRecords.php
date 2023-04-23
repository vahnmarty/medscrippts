<?php

namespace App\Http\Livewire\FlashCard;

use Auth;
use App\Models\Script;
use Livewire\Component;
use App\Models\Category;
use App\Models\FlashCard;
use App\Models\FlashCardRecord;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\ComponentContainer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;

class FlashCardRecords extends Component implements HasTable
{
    use InteractsWithTable;
    
    public function render()
    {
        return view('livewire.flash-card.flash-card-records');
    }

    public function mount()
    {
        $this->max = 20;
    }

    protected function getTableQuery() 
    {
        return FlashCardRecord::where('user_id', Auth::id());
    } 

    protected function getTableHeaderActions()
    {
        return [
            Action::make('Generate Flash Card')
                ->mountUsing(fn (ComponentContainer $form, $record) => $form->fill([
                    'max' => 20
                ]))
                ->form([
                    Select::make('categories')
                        ->required()
                        ->multiple()
                        ->options(Category::has('flashcards')->get()->pluck('name', 'id')),
                    TextInput::make('max')
                        ->numeric()
                        ->required()
                ])
                ->action(function(array $data){
                    $record = FlashCardRecord::create(['user_id' => Auth::id()]);
                    $record->categories()->attach($data['categories']);
                    $ids = FlashCard::whereIn('category_id', $data['categories'])->inRandomOrder()->limit($data['max'])->pluck('id')->toArray();
                    $record->items()->attach($ids);

                    return redirect()->route('flashcard.play', $record->id);
                })
                ->button()
            ];
    }

    protected function getTableColumns(): array 
    {
        return [
            TextColumn::make('created_at')->label('Date Created')->dateTime('m/d/Y'),
            TextColumn::make('categories.name'),
            TextColumn::make('items_count')->label('Cards')->counts('items'),
            TextColumn::make('confidence'),
            TextColumn::make('reviewed')
        ];
    }

    protected function getTableActions()
    {
        return [
            Action::make('retake')
                ->url(fn (FlashCardRecord $record): string => route('flashcard.play', $record->id))
                ->button()
        ];

    }
}
