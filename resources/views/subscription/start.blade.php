<x-auth-layout>

    <div class="min-h-screen py-16 bg-gray-100">
        <div class="max-w-2xl mx-auto">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-primary">Select Plan</h1>
            </div>

            <div>
                @if ($request->checkout )

                    @if($request->checkout == 'cancelled')
                    <div class="mb-4 text-sm font-medium text-red-600">
                        Your payment has been cancelled.
                    </div>
                    @endif
                @endif
            </div>
            <div>

                <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600 xl:mt-10">
                    <li class="flex gap-x-3">
                        <svg class="flex-none w-5 h-6 text-indigo-600" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        <strong>Starter Library:</strong> 299 premade scripts written around step 2 board level content
                    </li>

                    <li class="flex gap-x-3">
                        <svg class="flex-none w-5 h-6 text-indigo-600" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        <strong>Flash cards:</strong> AI generated flash card bank
                    </li>

                    <li class="flex gap-x-3">
                        <svg class="flex-none w-5 h-6 text-indigo-600" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        <strong>Qbank:</strong> AI generated, adaptable multiple choice bank with over 1200 questions
                    </li>

                    <li class="flex gap-x-3">
                        <svg class="flex-none w-5 h-6 text-indigo-600" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        <strong>Blur Mode:</strong> auto blur your cards to selectively test your knowledge
                    </li>
                </ul>
            </div>
            <div class="grid max-w-md grid-cols-1 gap-8 mx-auto mt-10 isolate lg:mx-0 lg:max-w-none lg:grid-cols-2">
                @foreach ($plans as $plan)
                    <form action="" class="text-center" method="POST">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->stripe_plan }}">
                        <div class="p-8 bg-white rounded-3xl ring-1 ring-gray-200 xl:p-10">
                            <h3 id="tier-freelancer" class="text-lg font-semibold leading-8 text-gray-900">
                                {{ $plan->name }}
                            </h3>
                            <p class="mt-4 text-center">
                                <!-- Price, update based on frequency toggle state -->
                                <span class="text-5xl font-bold tracking-wider text-center text-gray-900">${{ $plan->price }}</span>
    
                                <!-- Payment frequency, update based on frequency toggle state -->
                                @if ($plan->per)
                                <span class="text-sm font-semibold leading-6 text-gray-600">/{{ $plan->per }}</span>
                                @endif
                            </p>
                            <div class="mt-8">
                                <a href="{{ url('subscription-checkout', $plan->stripe_plan) }}"class="block text-center btn-primary">Select Plan</a>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    </div>


    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
        
    @endpush
</x-auth-layout>
