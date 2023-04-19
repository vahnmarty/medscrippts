<?php

namespace App\Http\Livewire\FlashCard;

use Auth;
use Livewire\Component;
use App\Models\FlashCard;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;

class ManageFlashCards extends Component implements HasTable
{
    use InteractsWithTable;
    
    public function render()
    {
        return view('livewire.flash-card.manage-flash-cards');
    }

    protected function getTableQuery() 
    {
        return FlashCard::where('user_id', Auth::id());
    } 

    protected function getTableHeaderActions()
    {
        return [
            Action::make('Create Flash Card')
                ->form([
                    TextInput::make('max')->numeric()->required()
                ])
                ->action(function(array $data){
                    dd($data);
                    
                })
            ];
    }

    protected function getTableColumns(): array 
    {
        return [
            TextColumn::make('created_at')->label('Date Created')->dateTime('m/d/Y'),
            TextColumn::make('categories.name'),
            TextColumn::make('cards_count')->label('Cards')->counts('cards'),
            TextColumn::make('confidence'),
            TextColumn::make('reviews'),
        ];
    }

    protected function getTableActions()
    {
        return [
            Action::make('retake')
                 ->url(fn (FlashCard $record): string => route('flashcard.play', $record->id))
                 ->color('primary')
                ->button()
        ];
    }
    
}
