<?php

namespace App\Http\Livewire;

use Auth;
use App\Models\Plan;
use Livewire\Component;
use Laravel\Cashier\Coupon;

class SubscriptionCheckout extends Component
{
    public $plan;

    public $subtotal = 0, $discount = 0, $total = 0;

    public $coupon, $is_coupon_valid;
    
    public function render()
    {
        $plans = Plan::active()->fromEnv()->get();
        $intent = Auth::user()->createSetupIntent();

        $this->calculate();

        return view('livewire.subscription-checkout', compact('plans', 'intent'))->layout('layouts.auth');
    }

    public function mount()
    {
        if(Auth::user()->hasSubscribed()){
            return redirect('billing-portal');
        }   
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

            try {

                if($this->coupon){
                    $promotionCode = $user->findPromotionCode($this->coupon);

                    $subscribed = $user->newSubscription('default', $plan->stripe_plan)
                        ->withCoupon($promotionCode?->id)
                        ->create($intent['payment_method'],[
                            'email' => $user->email
                        ]);
                }
                else{
                    $subscribed = $user->newSubscription('default', $plan->stripe_plan)
                        ->create($intent['payment_method'],[
                            'email' => $user->email
                        ]);                    
                }
                

                

                return redirect('scripts');
            } catch (\Throwable $th) {

                $this->addError('payment', $th->getMessage());
            }
            

           
        }
        
    }

    public function validateCoupon()
    {
        $promoCode = $this->validatePromocode($this->coupon);

        if (!$promoCode) {
            $this->addError('coupon', 'Invalid promo code.');
        }

        $coupon = $promoCode->coupon;
        

        if($coupon->percent_off){
            $percent_off = $coupon->percent_off / 100;

            $this->discount = $this->subtotal * $percent_off;
        }
        elseif($coupon->amount_off)
        {
            $this->discount = $coupon->amount_off;
        }

        $this->is_coupon_valid = true;

        $this->calculate();

        if($this->total <= 0)
        {
            $this->expressCheckout();
        }
    }

    public function calculate()
    {
        $this->total = $this->subtotal - $this->discount;
    }

    public function expressCheckout()
    {
        $plan = Plan::find($this->plan);

        $user = Auth::user();

        if($plan && $user)
        {
            try {

                if($this->coupon){
                    $promotionCode = $user->findPromotionCode($this->coupon);

                    $subscribed = $user->newSubscription('default', $plan->stripe_plan)
                        ->withPromotionCode($promotionCode?->id)
                        ->create();
                }

                return redirect('scripts');
            } catch (\Throwable $th) {

                $this->addError('payment', $th->getMessage());
            }
        }
    }

    private function validatePromocode($code)
    {
        try {
            $promoCodes = \Cache::remember('stripe-cache-promocodes', 600, function () {
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                return \Stripe\PromotionCode::all(["active"=>true]);
            });
            foreach ($promoCodes->data as $promoCode) {
                if ($code==$promoCode->code) {
                    // valid
                    return $promoCode;
                }
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updatedPlan()
    {
        $plan = Plan::find($this->plan);

        $this->subtotal = $plan->price;
    }
}
