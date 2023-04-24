<div>

    <header class="flex justify-between px-16 py-6">
        <h1 class="text-4xl font-bold leading-7 text-darkgreen sm:leading-9">Question Banks</h1>
        <div class="flex gap-6">
            
        </div>
    </header>
    <div class="px-8 py-12 space-y-8 bg-gray-100 lg:px-16">


        <div x-data="{ tab: 'records' }">
            <div>
                <nav class="flex space-x-4" aria-label="Tabs">
                    <a href="#"
                        x-on:click.prevent="tab = 'scripts'" 
                        class="px-3 py-2 text-sm font-medium text-gray-500 rounded-md hover:text-gray-700">
                        Scripts</a>
                    <a href="#"
                        x-on:click.prevent="tab = 'records'"
                        class="px-3 py-2 text-sm font-medium text-gray-800 bg-gray-200 rounded-md">Records</a>
                </nav>
            </div>

            <div class="mt-8">
                <div x-show="tab == 'records'">
                    @livewire('question-bank.question-bank-records')
                </div>
                <div x-show="tab == 'scripts'" x-cloak>
                    @livewire('question-bank.question-bank-scripts')
                </div>
            </div>
        </div>

    </div>
</div>
