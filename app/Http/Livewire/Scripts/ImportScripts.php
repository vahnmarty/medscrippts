<?php

namespace App\Http\Livewire\Scripts;

use Livewire\Component;
use App\Models\Category;
use App\Models\FlashCard;
use App\Models\QuestionBank;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Concerns\InteractsWithForms;

class ImportScripts extends Component implements HasForms
{
    use InteractsWithForms;
    
    public function render()
    {
        return view('livewire.scripts.import-scripts');
    }

    public function mount()
    {
        $this->form->fill([
            'categories' => Category::get()->pluck('id')->toArray()
        ]);
    }

    protected function getFormSchema()
    {
        return [
            CheckboxList::make('categories')
                ->options(Category::orderBy('name')->get()->pluck('name', 'id'))
                ->bulkToggleable()
                ->columns(2)
        ];
    }

    public function import()
    {
        $data = $this->form->getState();
        $selected = $data['categories'];

        $categories = Category::whereIn('id', $selected)->with('scripts')->get();

        # Import Scripts
        foreach($categories as $category)
        {
            foreach($category->scripts as $script)
            {
                $clone = $script->replicate(); 
                $clone->user_id = auth()->id();
                $clone->save();
            }
        }

        # Import Flash Cards
        $flashCards = FlashCard::whereNull('user_id')->has('cards')->get();

        foreach($flashCards as $flashCard)
        {
            $clone = $flashCard->replicate();
            $clone->user_id = auth()->id();
            $clone->save();

            $newCard = $clone;
            $newCard->categories()->attach($newCard->categories()->first()?->id);

            foreach($flashCard->cards as $card)
            {
                $duplicate = $card->replicate();
                $duplicate->flash_card_id = $newCard->id;
                $duplicate->save();
            }
        }

        # Import QBanks
        $qBanks = QuestionBank::whereNull('user_id')->has('items')->get();

        foreach($qBanks as $qBank)
        {
            $clone = $qBank->replicate();
            $clone->user_id = auth()->id();
            $clone->save();

            $newQ = $clone;
            $newQ->categories()->attach($newQ->categories()->first()?->id);

            foreach($qBank->items as $item)
            {
                $duplicate = $item->replicate();
                $duplicate->question_bank_id = $newQ->id;
                $duplicate->save();
            }
        }


        return redirect('dashboard');
    }
}
