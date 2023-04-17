<x-auth-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-slot name="extraTop">
            <div class="max-w-lg mt-8 overflow-hidden">
                <nav aria-label="Progress">
                    <ol role="list" class="flex space-x-8 space-y-0 gap-7 justify-evenly">
                      <li class="md:flex-1">
                        <!-- Completed Step -->
                        <a href="#" class="flex flex-col py-2 pl-4 border-l-4 border-indigo-600 group hover:border-indigo-800 md:border-l-0 md:border-t-4 md:pb-0 md:pl-0 md:pt-4">
                          <span class="text-sm font-medium text-indigo-600 group-hover:text-indigo-800">Step 1</span>
                          <div class="text-sm font-medium">Payment</div>
                        </a>
                      </li>
                  
                  
                      <li class="md:flex-1">
                        <!-- Completed Step -->
                        <a href="#" class="flex flex-col py-2 pl-4 border-l-4 border-indigo-600 group hover:border-indigo-800 md:border-l-0 md:border-t-4 md:pb-0 md:pl-0 md:pt-4">
                          <span class="text-sm font-medium text-indigo-600 group-hover:text-indigo-800">Step 1</span>
                          <div class="text-sm font-medium">Confirmation</div>
                        </a>
                      </li>
                    </ol>
                  </nav>
            </div>
              
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <div class="text-left">
            <h1 class="text-xl font-bold text-primary">Confirm Subscription</h1>
        </div>

        <div class="mt-8">
            <form method="POST" action="{{ route('subscription.create') }}">
                @csrf
                <input type="hidden" name="plan_id" value="{{ $plan->stripe_plan }}">
                <div class="flex flex-col justify-between p-8 bg-white rounded-3xl ring-1 ring-gray-200 xl:p-10 lg:z-10 lg:rounded-b-none">
                    <div>
                      <div class="flex items-center justify-between gap-x-4">
                        <h3 id="tier-startup" class="text-lg font-semibold leading-8 text-indigo-600">Standard</h3>
            
                        <p class="rounded-full bg-indigo-600/10 px-2.5 py-1 text-xs font-semibold leading-5 text-indigo-600">
                            Most Popular
                        </p>
                      </div>
                      <p class="flex items-baseline mt-6 gap-x-1">
                        <span class="text-4xl font-bold tracking-tight text-gray-900">$10</span>
                        <span class="text-sm font-semibold leading-6 text-gray-600">/month</span>
                      </p>
                      <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600">
                        <li class="flex gap-x-3">
                          <svg class="flex-none w-5 h-6 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                          </svg>
                          Unlimited scripts
                        </li>
            
                        <li class="flex gap-x-3">
                          <svg class="flex-none w-5 h-6 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                          </svg>
                          Unlimited Flashcards
                        </li>
            
                        <li class="flex gap-x-3">
                          <svg class="flex-none w-5 h-6 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                          </svg>
                          Unlimited Question banks
                        </li>
            
                        <li class="flex gap-x-3">
                          <svg class="flex-none w-5 h-6 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                          </svg>
                          AI Contents
                        </li>
                      </ul>
                    </div>
                    <button type="submit" aria-describedby="tier-startup" class="block px-3 py-2 mt-8 text-sm font-semibold leading-6 text-center text-white bg-indigo-600 rounded-md shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 hover:bg-indigo-500">
                        Subscribe Now
                    </button>
                  </div>
            </form>
        </div>
    </x-authentication-card>


    @push('scripts')
    <script src="https://js.stripe.com/v3/"></script>

    @endpush
</x-auth-layout>
