<div class="min-h-screen px-6 py-16 bg-gray-100">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between text-center">
            <div></div>
            <h1 class="text-3xl font-bold text-primary">Subscription</h1>
            <div class="self-end">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 underline group hover:bg-gray-200">
                        <x-heroicon-s-logout  class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"/>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
        <section class="mt-16">
            <div class="grid grid-cols-1 gap-3 mx-auto mt-10 isolate lg:mx-0 sm:grid-cols-2 lg:gap-8">
                <div x-data="{ plan: $wire.entangle('plan') }">
                    <h3 class="mb-2 text-lg font-bold text-darkgreen">Select Plan</h3>
                    <div class="space-y-3">
                        @foreach ($plans as $plan)
                            <label 
                                :class="plan == `{{ $plan->id }}` ? 'border-green-300 border-2' : '' "
                                class="block p-6 bg-white border border-gray-200 rounded-sm cursor-pointer hover:border-green-300 hover:bg-green-100">
                                <div class="flex justify-between gap-8">
                                    <div class="flex items-start flex-1 gap-2">
                                        <input type="radio" class="mt-1" x-model="plan" value="{{ $plan->id }}">
                                        <div>
                                            <h3 class="font-bold text-darkgreen">{{ $plan->name }}</h3>
                                            <p class="text-sm">{{ $plan->description }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <h2 class="text-2xl font-bold text-gray-900">${{ $plan->price }}</h2>
                                        @if ($plan->per)
                                            <span>/{{ $plan->per }}</span>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        @endforeach

                        <h3 class="mb-2 text-lg font-bold text-darkgreen">Coupon</h3>
                        <div class="p-6 bg-white rounded-sm ring-1 ring-gray-200">
                            <input wire:model.defer="coupon" type="text" class="block w-full px-2 py-4 mt-2 bg-white border border-gray-300 rounded-md" placeholder="Enter Promo Code">


                            <button type="button" wire:click="validateCoupon" class="mt-2 btn-primary btn-sm">Validate</button>

                            @error('coupon') <span class="text-red-700 error">{{ $message }}</span> @enderror

                            @if($is_coupon_valid)
                            <span class="text-green-700">Valid Promo Code</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="mb-2 text-lg font-bold text-darkgreen">Enter Payment</h3>
                    <div class="p-6 bg-white rounded-sm ring-1 ring-gray-200">
                        <form>
                            <div class="pb-3 mb-3 border-b border-b-dashed">
                                <div class="flex items-center justify-between">
                                    <p>Sub-Total:</p>
                                    <p class="">${{ number_format($subtotal, 2) }}</p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <p>Discount:</p>
                                    <p class="">${{ number_format($discount, 2) }}</p>
                                </div>
                                <div class="flex items-center justify-between mt-1 text-lg">
                                    <p class="font-bold">Total:</p>
                                    <p class="font-bold text-red-700">${{ number_format($total, 2) }}</p>
                                </div>
                            </div>
                            <section wire:ignore>
                                
                                <div>
                                    <label>Card Details</label>
                                    <div id="card-element"
                                        class="px-2 py-4 mt-2 bg-white border border-gray-300 rounded-md">
                                    </div>
                                </div>
                                
                            </section>
                            @error('payment') <span class="text-red-700 error">{{ $message }}</span> @enderror

                            <div class="flex justify-center mt-8">
                                <button type="button" id="card-button" class="w-full btn-primary"
                                    data-secret="{{ $intent->client_secret }}">
                                    <x-loading/>
                                    Checkout
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>


@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        document.addEventListener('livewire:load', function() {
            initStripe();
        });

        function initStripe() {
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
                const {
                    setupIntent,
                    error
                } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                //name: cardHolderName.value
                            }
                        }
                    }
                );

                if (error) {
                    alert(error.message);
                } else {
                    @this.checkout(setupIntent);
                }
            });
        }


        function savePaymentMethod(intent) {
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
