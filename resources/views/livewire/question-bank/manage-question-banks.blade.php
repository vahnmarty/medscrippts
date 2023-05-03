<div>

    <header class="flex justify-between px-16 py-6">
        <h1 class="text-4xl font-bold leading-7 text-darkgreen sm:leading-9">Question Banks</h1>
        <div class="flex gap-6">
            
        </div>
    </header>
    <div class="px-8 py-6 space-y-8 bg-gray-100 lg:px-16">


        <div x-data="{ tab: 'records' }">

            <div class="mt-8">
                <div x-show="tab == 'records'">
                    @livewire('question-bank.question-bank-records')
                </div>
            </div>
        </div>

    </div>
</div>
