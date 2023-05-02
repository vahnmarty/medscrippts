<?php

namespace App\Http\Livewire\QuestionBank;

use Auth;
use Livewire\Component;
use Jenssegers\Agent\Agent;

class ManageQuestionBanks extends Component
{
    
    public function render()
    {
        return view('livewire.question-bank.manage-question-banks');
    }

    public function mount()
    {
        $agent = new Agent();

        if($agent->isMobile())
        {
            return redirect('qbanks/mobile');
        }
    }
    
}
