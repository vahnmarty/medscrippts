<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plan = Plan::whereActive(true)->first();
        return view('subscription.index', compact('plan'));
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

    public function intent(Request $request)
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
