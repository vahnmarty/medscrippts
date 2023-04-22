<?php

namespace App\Http\Livewire\FlashCard;

use Auth;
use Livewire\Component;
use App\Models\FlashCard;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Concerns\InteractsWithTable;

class FlashCardScripts extends Component implements HasTable
{
    use InteractsWithTable;
    
    public function render()
    {
        return view('livewire.flash-card.flash-card-scripts');
    }

    public function mount()
    {
        
    }

    protected function getTableQuery() 
    {
        return FlashCard::where('user_id', Auth::id());
    } 

    protected function getTableHeaderActions()
    {
        return [
            CreateAction::make()
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
            TextColumn::make('script.title'),
            TextColumn::make('question')
                ->label('Content')
                ->description(fn (FlashCard $record): string => $record->answer)->wrap()
        ];
    }

    protected function getTableActions()
    {
        return [
            ActionGroup::make([
                EditAction::make()
                    ->button(),
                DeleteAction::make()
                    ->button(),
            ])
           
            // Action::make('retake')
            //      ->url(fn (FlashCard $record): string => route('flashcard.play', $record->id))
            //      ->color('primary')
            //     ->button()
        ];
    }
    
}
