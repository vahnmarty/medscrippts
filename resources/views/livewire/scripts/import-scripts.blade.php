<div>
    <div class="relative">
        <h3 class="text-lg font-bold text-darkgreen">Import Scripts</h3>
        <form wire:submit.prevent="import" class="mt-8">

            {{ $this->form }}

            <div class="mt-4">
                <button type="submit" class="btn-primary">Import</button>
            </div>
        </form>
        
    </div>
</div>
