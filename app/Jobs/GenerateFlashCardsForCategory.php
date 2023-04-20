<?php

namespace App\Jobs;

use Log;
use App\Models\Category;
use App\Models\FlashCard;
use Illuminate\Bus\Queueable;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GenerateFlashCardsForCategory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Category $category;

    /**
     * Create a new job instance.
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->generate($this->category);
    }

    private function generate(Category $category)
    {
        $notes = '';

        foreach($category->scripts as $script)
        {
            $notes.= $script->getNotes();
        }

        $prompt = '
        Given the following article:

        Category: '. $category->name .'

        '. $notes.'

        Please generate a questionnaire that covers the main topics and key points discussed in the article. The questionnaire should consist of 20 questions.

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

        Log::channel('openai')->info('FlashCards CHATGPT Result');
        Log::channel('openai')->info($content);

        $data = parse_json_result($content);

        $questions = $data['questions'];

        $flashCard = FlashCard::create();
        $flashCard->categories()->attach($category->id);

        foreach($questions as $item)
        {
            $flashCard->cards()->create([
                'script_id' => $script->id,
                'question' => $item['question'],
                'answer' => $item['answer'],
            ]);
        }

    }

    
}
