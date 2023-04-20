<?php

namespace App\Jobs;

use Log;
use Auth;
use App\Models\Script;
use App\Models\FlashCard;
use Illuminate\Bus\Queueable;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GenerateFlashCards implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Script $script;
    public $flashCard;

    /**
     * Create a new job instance.
     */
    public function __construct(Script $script, FlashCard $flashCard = null)
    {
        $this->script = $script;
        $this->flashCard = $flashCard;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::channel('openai')->info('Queue ChatGPT');

        $this->createFlashCards($this->script);
    }

    private function createFlashCards(Script $script)
    {
        $max = 5;
        $prompt = '
        Given the following article:

        '. $script->getNotes() .'

        Please generate a questionnaire that covers the main topics and key points discussed in the article. The questionnaire should consist of 5 questions.

        The output should be in JSON format and grouped in a key called "questions". Each item in the array should have a key called "question" and "answer".';

        Log::channel('openai')->info('Prompt:');
        Log::channel('openai')->info($prompt);

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

        $flashCard = $this->flashCard;

        if(!$flashCard){
            $flashCard = FlashCard::create(['user_id' => $script->user_id]);
            $flashCard->categories()->attach($script->category_id);
        }
        

        foreach($questions as $item)
        {
            $flashCard->cards()->create([
                'script_id' => $script->id,
                'question' => $item['question'],
                'answer' => $item['answer'],
            ]);
        }

    }

    public function parseResult($content)
    {
        $json = json_encode($content);
        $decode = json_decode($json);
        $data =  json_decode(str_replace("\\\"", "\"", $decode), true);

        return $data;
    }
}
