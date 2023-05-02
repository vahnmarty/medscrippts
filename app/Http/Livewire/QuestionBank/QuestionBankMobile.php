<?php

namespace App\Http\Livewire\QuestionBank;

use Livewire\Component;
use App\Models\QuestionBankRecord;

class QuestionBankMobile extends Component
{
    public function render()
    {
        $qbanks = QuestionBankRecord::with('categories')->withCount('items')->where('user_id', auth()->id())->get();

        return view('livewire.question-bank.question-bank-mobile', compact('qbanks'))->layout('layouts.mobile');
    }
}
