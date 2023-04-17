<x-auth-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <div class="text-center">
            <h1 class="text-3xl font-bold text-primary">Subscribe Now</h1>
            <p class="mt-2 text-gray-600">$10/month</p>
        </div>

        <form action="{{ route('subscribe') }}" method="POST">
            @csrf
            <input type="hidden" name="plan" value="{{ $plan->stripe_id }}">
            <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="{{ config('cashier.key') }}"
                data-description="{{ $plan->name }}"
                data-amount="{{ $plan->price * 100 }}"
                data-email="{{ auth()->user()->email }}"
                data-label="Subscribe"
                data-panel-label="Subscribe Now"
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-currency="{{ config('cashier.currency') }}"
                data-locale="auto">
            </script>
        </form>
    </x-authentication-card>
</x-auth-layout>
