<div>
    <div class="relative">
        <h3 class="text-lg font-bold text-darkgreen">Create Script</h3>
        <p class="mt-2 text-gray-700">Enter your notes here.</p>
        <form wire:submit.prevent="save" class="mt-8">

            {{ $this->form }}


            <div class="flex justify-end mt-8">
                <button type="submit" class="btn-primary">Save</button>
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
