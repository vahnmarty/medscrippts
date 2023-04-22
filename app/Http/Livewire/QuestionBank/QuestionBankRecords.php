<?php

namespace App\Http\Livewire\QuestionBank;

use Auth;
use Livewire\Component;
use App\Models\Category;
use App\Models\FlashCard;
use App\Models\QuestionBank;
use App\Models\QuestionBankRecord;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\ComponentContainer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;
use App\Http\Livewire\QuestionBank\QuestionBankScripts;

class QuestionBankRecords extends Component implements HasTable
{
    use InteractsWithTable;
    
    public function render()
    {
        return view('livewire.question-bank.question-bank-records');
    }

    protected function getTableQuery() 
    {
        return QuestionBankRecord::where('user_id', Auth::id());
    } 

    protected function getTableHeaderActions()
    {
        return [
            Action::make('Generate QBank')  
                ->label('QBank Generator')
                ->mountUsing(fn (ComponentContainer $form, $record) => $form->fill([
                    'max' => 20
                ]))
                ->form([
                    Select::make('categories')
                        ->required()
                        ->multiple()
                        ->options(Category::get()->pluck('name', 'id')),
                    TextInput::make('max')
                        ->numeric()
                        ->required()
                ])
                ->action(function(array $data){
                    $record = QuestionBankRecord::create([
                            'user_id' => Auth::id(),
                        ]);
                    $record->categories()->attach($data['categories']);
                    $ids = QuestionBank::whereIn('category_id', $data['categories'])->inRandomOrder()->limit($data['max'])->pluck('id')->toArray();
                    $record->items()->attach($ids);

                    return redirect()->route('qbank.play', $record->id);
                })
                ->button()
            ];
    }

    protected function getTableColumns(): array 
    {
        return [
            TextColumn::make('created_at')->label('Date Created')->dateTime('m/d/Y'),
            TextColumn::make('categories.name'),
            TextColumn::make('items_count')->label('Items')->counts('items'),
            TextColumn::make('score'),
        ];
    }

    protected function getTableActions()
    {
        return [
            Action::make('retake')
                 ->url(fn (QuestionBankRecord $record): string => route('qbank.play', $record->id))
                 ->color('primary')
                ->button()
        ];
    }
    
}
