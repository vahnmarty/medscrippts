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

    public $qBank;

    /**
     * Create a new job instance.
     */
    public function __construct(Script $script, QuestionBank $qBank = null)
    {
        $this->script = $script;
        $this->qBank = $qBank;
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
        $prompt = '
        Given the following article:

        '. $script->getNotes() .'

        Please generate a multiple-choice type questionnaire that covers the main topics and key points discussed in the article. The questionnaire should consist of 5 questions.

        The output should be in JSON format and grouped in a key called "questions". Each item in the array should have a key called "question", "option1", "option2", "option3", "option4" then  and "option_answer" with the value of the correct option and "answer" with the value of the correct answer.';

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

            $qBank = $this->qBank;

            if(!$qBank)
            {
                $qbank = QuestionBank::create(['user_id' => $script->user_id]);
                $qbank->categories()->attach($script->category_id);
            }
    
            
    
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
