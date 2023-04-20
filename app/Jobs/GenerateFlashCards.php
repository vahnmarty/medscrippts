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
        $this->generate($this->script);
    }

    private function generate(Script $script)
    {
        $max = 5;
        $system_prompt = 'Please generate a questionnaire that covers the main topics and key points discussed in the article. The questionnaire should consist of '. $max.' questions.

        The output should be in JSON format and grouped in a key called "questions". Each item in the array should have a key called "question" and "answer".';

        $messages[] = [
            'role' => 'system', 
            'content' =>  $system_prompt
        ];

        $user_prompt = $script->getNotes();

        $messages[] = [
            'role' => 'user', 
            'content' =>  $user_prompt
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

        foreach($questions as $item)
        {
            FlashCard::create([
                'script_id' => $script->id,
                'category_id' => $script->category_id,
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
