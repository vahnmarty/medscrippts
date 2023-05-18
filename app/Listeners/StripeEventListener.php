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
            
            try {
                $data = $event->payload['data'];
                $customer = $data['object']['customer'];

                Log::info('Customer: ' . $customer);

                $user = User::where('stripe_id', $customer)->first();

                Log::info('User: ' . $user->id);

                $user->newSubscription('default', 'price_monthly');

                Log::info('Subscription! default');

            
            } catch (\Throwable $th) {

                Log::error($th);
            }
            

        }
    }
}
