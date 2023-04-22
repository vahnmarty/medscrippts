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
use App\Http\Livewire\QuestionBank\QuestionBankScripts;

class QuestionBankScripts extends Component implements HasTable
{
    use InteractsWithTable;
    
    public function render()
    {
        return view('livewire.question-bank.question-bank-scripts');
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
            TextColumn::make('script.title'),
            TextColumn::make('question')
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
