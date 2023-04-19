<?php

namespace App\Jobs;

use Log;
use Auth;
use App\Models\Script;
use App\Models\FlashCard;
use App\Models\QuestionBank;
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

        $this->generate($this->script);
    }

    private function generate(Script $script)
    {
        $max = 5;
        $prompt = "Write me {$max} items questionnaire in a JSON format,  Use key 'questions' as the parent then for the children keys: 'question', 'option1', 'option2', 'option3', 'option4' then 'option_answer' with the value of the correct option and 'answer' with the value of the correct answer, and based the questions from the article below. \n\nArticle: " . $script->getNotes();

        Log::channel('openai')->info('QBank Prompt:');
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

        Log::channel('openai')->info('QBank CHATGPT Result');
        Log::channel('openai')->info($content);

        try {
            $data = $this->parseResult($content);

            $questions = $data['questions'];
    
            $qbank = QuestionBank::create(['user_id' => $script->user_id]);
            $qbank->categories()->attach($script->category_id);
    
            foreach($questions as $item)
            {
                $qbank->items()->create([
                    'script_id' => $script->id,
                    'question' => $item['question'],
                    'option1' => $item['option1'],
                    'option2' => $item['option2'],
                    'option3' => $item['option3'],
                    'option4' => $item['option4'],
                    'option_answer' => $item['option_answer'],
                    'answer' => $item['answer'],
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
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
