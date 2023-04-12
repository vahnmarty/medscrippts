<div>
    <div class="relative">
        <h3 class="text-lg font-bold text-darkgreen">Flash Cards</h3>
        <p class="mt-2 text-gray-700">Our app uses NLP pathways to autogenerate flash cards based on your content. Most of the time this works great, but questions are not reviewed, so our apologies if our AI gets confused.</p>
        <form wire:submit.prevent="generate" class="mt-8">

            <div class="grid grid-cols-4 col-span-3 gap-6">
                <fieldset class="col-span-2">
                    <legend>Category</legend>
                    <select wire:model.defer="category" class="w-full mt-2 border-gray-300 rounded-md">
                        <option value="">-- Select --</option>
                        @foreach($categories as $categoryItem)
                        <option value="{{ $categoryItem->id }}">{{ $categoryItem->name }}</option>
                        @endforeach
                    </select>
                </fieldset>
                <fieldset>
                    <legend>No.:</legend>
                    <input wire:model.defer="n" type="number"  class="mt-2 border-gray-300 rounded-md">
                </fieldset>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn-primary">Generate QBank</button>
            </div>
        </form>

        <div wire:loading>
            <div class="absolute inset-0 z-10 -m-10 bg-white/80">
                <div class="flex flex-col items-center justify-center w-full h-full">
                    <img src="{{ asset('img/chatgpt.svg') }}" class="w-16 h-16 animate-spin">
                </div>
            </div>
        </div>
    </div>
</div>
