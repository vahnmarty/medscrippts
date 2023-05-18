<?php

namespace App\Http\Livewire\QuestionBank;

use Auth;
use Livewire\Component;
use App\Models\Category;
use App\Models\QuestionBank;
use App\Models\QuestionBankRecord;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;

class QuestionBankMobile extends Component implements HasForms
{
    use InteractsWithForms;

    public $categories = [], $max= 20;
    
    public function render()
    {
        $qbanks = QuestionBankRecord::with('categories')->withCount('items')->where('user_id', auth()->id())->get();

        return view('livewire.question-bank.question-bank-mobile', compact('qbanks'))->layout('layouts.mobile');
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
        
        $record = QuestionBankRecord::create(['user_id' => Auth::id()]);
        $record->categories()->attach($data['categories']);
        $ids = QuestionBank::whereIn('category_id', $data['categories'])->inRandomOrder()->limit($data['max'])->pluck('id')->toArray();
        $record->items()->attach($ids);

        return redirect()->route('qbank.play', $record->id);
    }
}
