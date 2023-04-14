<?php

namespace App\Http\Livewire;

use Log;
use Livewire\Component;
use App\Models\Category;
use App\Models\FlashCard;
use OpenAI\Laravel\Facades\OpenAI;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;

class QuestionGenerator extends Component implements HasForms
{
    use InteractsWithForms;
    
    public $categories = [];

    public $category, $n = 20;

    public $request_time;

    public function render()
    {
        return view('livewire.question-generator');
    }

    public function mount()
    {
        
    }

    protected function getFormSchema()
    {
        return [
            Select::make('category')
                ->multiple()
                ->label('Select Category(s)')
                ->options(Category::get()->pluck('name', 'id')),
            TextInput::make('n')
                ->label('Max')
                ->disabled()
                ->numeric()
        ];
    }

    public function generate()
    {
        $this->validate();
        
        $startTime = microtime(true);

        $data = $this->createPrompt();
        
        $prompt = 'Write me a 20 questionnaires from this Array: "' . json_encode($data). '". Then Display the result as JSON Format, group them to "questions" then give each item  with keys "question" and "answer" . Make sure the answer is brief and straightforward, just a phrase or maybe a single word. You can also make the question as fill in the blanks.';

        $messages[] = [
            'role' => 'user', 
            'content' =>  $prompt
        ];

        //Log::channel('openai')->info(json_encode($messages));

        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages
        ]);

        // OpenAI returns choices array, so select the first one
        $content = $response['choices'][0]['message']['content'];


        Log::channel('openai')->info('CHATGPT Result');
        Log::channel('openai')->info($content);


        try {
            $data = $this->parseResult ($content);

            $this->results = $data['questions'];

            $endTime = microtime(true);

            $this->request_time = round(($endTime - $startTime) * 1000, 2);
            
            $flashCard = $this->createFlashCard();

            return redirect()->route('qbank', $flashCard->id);

        } catch (\Throwable $th) {
            if(config('app.debug')){
                throw $th;
            }else{
                $this->alert('error', 'Error parsing your data. Please try to update your content.');
            }
            
        }
        
    }

    public function createPrompt()
    {

        $form = $this->form->getState();
        $data = [];
        $categories = Category::whereIn('id', $form['category'])->with('scripts')->get();

        foreach($categories as $category)
        {
            $scripts = $category->scripts()->select('title', 'pathophysiology')->get()->toArray();
            $data[] = [
                'category' => $category->name,
                'scripts' => $scripts
            ];
        }

        return $data;
    }

    public function parseResult($content)
    {
        // $content is a text result, so convert it into a json
        $json = json_encode($content);

        $decode = json_decode($json);

        // this is to delete unnecessary strings
        $data =  json_decode(str_replace("\\\"", "\"", $decode), true);

        return $data;
    }

    public function createFlashCard()
    {
        $flashCard = FlashCard::create([
            'category_id' => $this->category,
            'user_id' => auth()->id()
        ]);

        foreach($this->results as $result)
        {
            $flashCard->cards()->create([
                'question' => $result['question'],
                'answer' => $result['answer']
            ]);
        }

        return $flashCard;
    }
}
