<?php

namespace App\Http\Livewire;

use App\Models\Plan;
use Livewire\Component;
use Auth;

class SubscriptionCheckout extends Component
{
    public $plan;
    
    public function render()
    {
        $plans = Plan::active()->fromEnv()->get();
        $intent = Auth::user()->createSetupIntent();

        return view('livewire.subscription-checkout', compact('plans', 'intent'))->layout('layouts.auth');
    }

    public function mount()
    {
        
    }

    public function checkout($intent)
    {
        $plan = Plan::find($this->plan);

        $user = Auth::user();

        if($plan && $user)
        {
            $user->addPaymentMethod($intent['payment_method']);

            if (!$user->hasDefaultPaymentMethod()) {
                $user->updateDefaultPaymentMethod($intent['payment_method']);
            }

            
            $subscribed = $user->newSubscription('default', $plan->stripe_plan)
                ->create($intent['payment_method'],[
                    'email' => $user->email
                ]);

            return redirect('scripts');
        }
        
    }
}
