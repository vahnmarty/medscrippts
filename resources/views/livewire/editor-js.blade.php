<div>

    <div class="px-2 py-6 bg-gray-100 lg:py-12 lg:px-16">

        <div class="hidden bg-white lg:block">
            <div class="absolute top-5 right-5">
                <button wire:click="$emit('editScript', {{ $script->id }})" type="button"
                    aria-label="Edit Script">
                    <x-heroicon-s-pencil class="text-gray-400 h-7 w-7 hover:text-yellow-500" />
                </button>
            </div>
            <div class="flex-shrink-0 p-6 lg:min-h-[27rem] lg:p-6">
                <header>
                    <p class="text-orange-500">
                        {{ $script->category->name ?? 'Uncategorized' }}</p>
                    

                    <div x-data="{ 
                            content: '', 
                            active: false,
                            open: false,
                        }" class="inline-flex items-center ">
                        <h3 x-on:blur="content = $event.target.innerHTML; active = true" 
                            x-on:click="open = true; active = true"
                            x-on:click.away="active = false"
                            contenteditable 
                            class="mt-2 text-xl font-semibold outline-none text-darkgreen focus:bg-gray-200 hover:bg-gray-100">
                            {{ $title }}
                        </h3>
                        <a href="#" 
                            wire:click.prevent="autoSave('title')" 
                            x-show="open" 
                            x-on:click.prevent="open = false; active = false"
                            :class="active ? 'text-green-500' : 'text-green-200' " 
                            class="ml-8 hover:text-green-500">
                            <x-heroicon-s-check-circle class="w-8 h-8 "/>
                        </a>
                    </div>
                </header>
                <div class="gap-6 lg:grid lg:grid-cols-2">
                    <div class="p-3 py-4 space-y-3 lg:p-4">
                        
                    </div>
                    <div class="hidden lg:block">
                        <h3>Links</h3>
                        <div class="p-2 mt-2 bg-gray-100">
                            @forelse($script->links as $link)
                                <a href="{{ $link->url }}" target="_blank"
                                    class="font-sans text-sm text-blue-400 whitespace-normal ">
                                    {{ $link->url }}
                                </a>
                            @empty
                                <span>-</span>
                            @endforelse
                        </div>
                        <h3 class="mt-8">Images</h3>
                        <div class="mt-2">
                            @forelse($script->images as $image)
                                <img src="{{ $image->url }}"
                                    class="max-h-[12rem] overflow-auto" loading="lazy"
                                    alt="">
                            @empty
                                <img src="{{ asset('img/placeholder.png') }}"
                                    class="max-h-[12rem] overflow-auto w-32 h-32">
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    
</div>

@push('scripts')

@endpush
