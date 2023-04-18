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

        <div class="flex justify-between">
            <h1 class="text-xl font-bold text-primary">Setup Payment</h1>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 underline group hover:bg-gray-200">
                  <span>Logout</span>
              </button>
          </form>
        </div>

        <div class="p-6 mt-8 bg-gray-100 border rounded-md">
            <form action="{{ url('subscription/intent') }}" method="POST">
                @csrf
                <div>
                    <label>Card Name</label>
                    <input id="card-holder-name" value="My Card" type="text" class="w-full mt-2 border border-gray-300 rounded-md" placeholder="e.g. default" >
                </div>
     
                <!-- Stripe Elements Placeholder -->
                <div class="mt-4">
                    <label>Card Details</label>
                    <div id="card-element" class="px-2 py-4 mt-2 bg-white border border-gray-300 rounded-md"></div>
                </div>
                
                <div class="flex justify-center mt-8">
                    <button type="button" id="card-button" class="w-full btn-primary" data-secret="{{ $intent->client_secret }}">
                        Continue
                    </button>
                </div>
            </form>
        </div>
    </x-authentication-card>


    @push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    
    <script>
        const stripe = Stripe("{{ config('cashier.key') }}");
    
        const elements = stripe.elements();
        const cardElement = elements.create('card', {
            hidePostalCode: true,
        });
    
        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;
        
        cardButton.addEventListener('click', async (e) => {
            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );
        
            if (error) {
                alert(error.message);
                // Display "error.message" to the user...
            } else {
                console.log(setupIntent);
                savePaymentMethod(setupIntent);
                // The card has been verified successfully...
            }
        });

        function savePaymentMethod(intent)
        {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch("{!! route('subscription.payment') !!}", {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-Token': token,
                },
                body: JSON.stringify({
                  payment_id: intent.payment_method,
                }),
              })
                .then((response) => {
                  if (response.ok) {
                    // Subscription successful
                    console.log('Subscription successful!');

                    window.location.href = "{!! route('subscription.index') !!}";
                  } else {
                    // Subscription failed
                    console.error('Subscription failed.');
                  }
                })
                .catch((error) => {
                  console.error('Error subscribing to plan:', error);
                });
        }
    </script>
    @endpush
</x-auth-layout>
