<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Plan;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class SubscriptionController extends Controller
{
    public function start(Request $request)
    {
        if(Auth::user()->subscribed()){
            return redirect('billing-portal');
        }
        
        $plans = Plan::active()->fromEnv()->get();

        return view('subscription.start', compact('plans', 'request'));
    }

    public function selectPlan()
    {
        $user = Auth::user();

        $plans = Plan::get();

        return view('subscription.index', compact('plans'));
    }

    public function index()
    {
        $user = Auth::user();

        if (!$user->hasDefaultPaymentMethod()) {
            return redirect()->route('subscription.create');
        }

        # The stripe way in getting the plans
        // $stripe = Cashier::stripe();
        // $plans = $stripe->products->all();

        $plans = Plan::get();

        return view('subscription.index', compact('plans'));
    }

    public function subscribe(Request $request)
    {
        $user = Auth::user();

        $paymentMethod = $user->defaultPaymentMethod();

        $plan = Plan::where('stripe_plan', $request->plan_id)->first();

        $subscribed = $user->newSubscription('default', $plan->stripe_plan)->createAndSendInvoice();

        if($subscribed){
            return redirect('scripts');
        }
    }

    public function create(Request $request)
    {
        return view('subscription.intent', [
            'intent' => Auth::user()->createSetupIntent()
        ]);
    }

    public function payment(Request $request)
    {
        $user = Auth::user();
        $user->addPaymentMethod($request->payment_id);

        if (!$user->hasDefaultPaymentMethod()) {
            $user->updateDefaultPaymentMethod($request->payment_id);
        }

        // $user->newSubscription(
        //     'default', 'price_monthly'
        // )->create($request->payment_id);

        return response()->json([
            'success' => true,
            'message' => 'Successfully subscribed'
        ], 200);
    }
}
