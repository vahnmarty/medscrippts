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
        $this->generate($this->script);
    }

    private function generate(Script $script)
    {
        $max = 5;
        $system_prompt = 'From the provided notes, Please generate 5 items of multiple choice questions with 4 answer choices, one correct and 3 incorrect. The output should be in JSON format and grouped in a key called "questions". Each item must have these keys: "question", "option1", "option2", "option3", "option4". And add a key called "option_answer" with option number of the correct answer, so it must be ["option1", "option2", "option3", "option4"].';

        $user_prompt = $script->getNotes();

        $messages[] = [
            'role' => 'system', 
            'content' =>  $system_prompt
        ];
        $messages[] = [
            'role' => 'user', 
            'content' =>  $user_prompt
        ];

        Log::channel('openai')->info($messages);

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

            foreach($questions as $item)
            {

                // Check if option answer is option1,2,3,4

                // Check if 'answer' is from the list of the options
                QuestionBank::create([
                    'script_id' => $script->id,
                    'category_id' => $script->category_id,
                    'question' => $item['question'],
                    'option1' => $item['option1'],
                    'option2' => $item['option2'],
                    'option3' => $item['option3'],
                    'option4' => $item['option4'],
                    'option_answer' => $item['option_answer'],
                    //'answer' => $item['answer'],
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
