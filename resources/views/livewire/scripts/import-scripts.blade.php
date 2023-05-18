<div x-data="{ }"
    x-init="$nextTick(() => {
        @this.import();
    })">

    <div>
        <div  class="fixed inset-0 bg-white z-[100]">
            <div class="flex flex-col items-center justify-center h-full space-y-8">
    
                <x-authentication-card-logo />
    
                <p class="text-3xl">Importing scripts ... </p>
    
                <iframe src="https://embed.lottiefiles.com/animation/38074"></iframe>
            </div>
        </div>
    </div>
    
    <div class="relative">
        <h3 class="text-lg font-bold text-darkgreen">Import Scripts</h3>
        <form wire:submit.prevent="import" class="mt-8">

            {{ $this->form }}

            <div class="mt-4">
                <button x-ref="importbtn" type="submit" class="btn-primary">Import</button>
            </div>
        </form>
        
    </div>
</div>

