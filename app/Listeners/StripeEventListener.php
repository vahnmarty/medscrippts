<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Cashier\Events\WebhookReceived;
use App\Models\User;
use Log;

class StripeEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'checkout.session.completed') {

            Log::info($event->payload['data']);
            
            try {
                $data = $event->payload['data'];
                $customer = $data['object']['customer'];

                $user = User::where('stripe_id', $customer)->first();
                $user->subscribed_lifetime = true;
                $user->stripe_webhook = json_encode($data);
                $user->save();

            
            } catch (\Throwable $th) {

                Log::error($th);
            }
            

        }
    }
}
