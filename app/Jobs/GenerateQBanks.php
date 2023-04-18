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

class GenerateQBanks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Script $script;

    /**
     * Create a new job instance.
     */
    public function __construct(Script $script)
    {
        $this->script = $script;
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
        $prompt = "Write me {$max} items questionnaire in a JSON format,  group them into 'questions' then give each item with keys 'question' and 'answer', and based the questions from the article below. \n\nArticle: " . $script->getNotes();

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

        $flashCard = FlashCard::create(['user_id' => $script->user_id]);
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

    public function parseResult($content)
    {
        $json = json_encode($content);
        $decode = json_decode($json);
        $data =  json_decode(str_replace("\\\"", "\"", $decode), true);

        return $data;
    }
}
