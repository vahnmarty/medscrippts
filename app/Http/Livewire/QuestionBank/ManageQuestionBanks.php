<?php

namespace App\Http\Livewire\QuestionBank;

use Auth;
use Livewire\Component;
use App\Models\FlashCard;
use App\Models\QuestionBank;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;

class ManageQuestionBanks extends Component implements HasTable
{
    use InteractsWithTable;
    
    public function render()
    {
        return view('livewire.question-bank.manage-question-banks');
    }

    protected function getTableQuery() 
    {
        return QuestionBank::where('user_id', Auth::id());
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
            TextColumn::make('items_count')->label('Questions')->counts('items'),
            TextColumn::make('prev_score')
                ->getStateUsing( function (QuestionBank $record){
                return $record->records()->first()?->score;
             }),
            TextColumn::make('records_count')->label('Times Taken')->counts('records'),
        ];
    }

    protected function getTableActions()
    {
        return [
            Action::make('retake')
                 ->url(fn (QuestionBank $record): string => route('qbank.play', $record->id))
                 ->color('primary')
                ->button()
        ];
    }
    
}
