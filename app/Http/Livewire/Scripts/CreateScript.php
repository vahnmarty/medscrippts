<?php

namespace App\Http\Livewire\Scripts;

use Log;
use Auth;
use App\Models\Script;
use Livewire\Component;
use App\Models\Category;
use App\Models\FlashCard;
use OpenAI\Laravel\Facades\OpenAI;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateScript extends Component implements HasForms
{
    use InteractsWithForms;

    public $title, $category_id, $pathophysiology, $epidemiology, $signs, $diagnosis, $treatments;
    
    public function render()
    {
        return view('livewire.scripts.create-script')->layout('layouts.slider');
    }

    public function mount()
    {
        $this->form->fill(Script::first()->toArray());
    }

    protected function getFormSchema()
    {
        return [
            Grid::make(2)
            ->schema([
                TextInput::make('title')
                    ->required(),
                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::orderBy('name')->get()->pluck('name', 'id'))
                    ->required(),
            ]),
            Textarea::make('pathophysiology')->label('Pathophysiology (Path)')->inlineLabel()->rows(2),
            Textarea::make('epidemiology')->label('Epidemiology (Epi)')->inlineLabel()->rows(2),
            Textarea::make('signs')->label('Signs and Symptoms (S/S)')->inlineLabel()->rows(2),
            Textarea::make('diagnosis')->label('Diagnosis (Dx)')->inlineLabel()->rows(2),
            Textarea::make('treatments')->label('Treatments (Tx)')->inlineLabel()->rows(2),
        ];
    }

    public function save()
    {
        $data = $this->form->getState();
        $data['user_id'] = auth()->id();
        $script = Script::create($data);

        $this->createAiContents($script);

        $this->emitUp('refreshScripts');

        $this->dispatchBrowserEvent('closemodal-create');
    }

    public function createAiContents(Script $script)
    {
        $this->createFlashCards($script);
        $this->createQBanks($script);
    }

    private function createFlashCards(Script $script)
    {
        $max = 5;
        $prompt = "Write me {$max} flash card questionnaires in a JSON format,  group them into 'questions' then give each item with keys 'question' and 'answer', and based the questions from the article below. \n\nArticle: " . $script->getNotes();

        $messages[] = [
            'role' => 'user', 
            'content' =>  $prompt
        ];

        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages
        ]);

        $content = $response['choices'][0]['message']['content'];

        Log::channel('openai')->info('FlashCard CHATGPT Result');
        Log::channel('openai')->info($content);

        $data = $this->parseResult($content);

        $questions = $data['questions'];

        $flashCard = FlashCard::create(['user_id' => Auth::id()]);
        $flashCard->categories()->attach($script->category_id);

        foreach($questions as $item)
        {
            $flashCard->cards()->create([
                'script_id' => $script->id,
                'question' => $item['question'],
                'answer' => $item['answer'],
            ]);
        }

    }

    private function createQBanks(Script $script)
    {

    }

    public function parseResult($content)
    {
        $json = json_encode($content);
        $decode = json_decode($json);
        $data =  json_decode(str_replace("\\\"", "\"", $decode), true);

        return $data;
    }
}

