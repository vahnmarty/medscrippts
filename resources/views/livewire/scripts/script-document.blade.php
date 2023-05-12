<div x-data="{
        edit:false,
        pathophysiology: $wire.entangle('pathophysiology').defer,
        epidemiology: $wire.entangle('epidemiology').defer,
        signs: $wire.entangle('signs').defer,
        diagnosis: $wire.entangle('diagnosis').defer,
        treatments: $wire.entangle('treatments').defer,
        links: $wire.entangle('links').defer
    }">
    <section class="relative">
        <div class="absolute right-10 -top-7">
            <div class="flex gap-1">
                <button type="button" 
                    x-show="!edit"
                    x-on:click="edit = true"
                    class="inline-flex px-2 py-1 text-sm text-gray-900 transition-all bg-red-400 hover:bg-red-600 hover:text-white rounded-t-md">
                    <x-heroicon-s-pencil class="w-5 h-5"/>
                    Edit
                </button>
                <button type="button" 
                    x-show="edit"
                    x-cloak
                    x-on:click="edit = false"
                    class="inline-flex px-2 py-1 text-sm text-gray-900 transition-all bg-red-400 hover:bg-red-600 hover:text-white rounded-t-md">
                    <x-heroicon-s-ban class="w-5 h-5"/>
                    Cancel
                </button>
                <button 
                    x-show="!edit"
                    type="button" 
                    disabled
                    class="inline-flex px-2 py-1 text-sm text-gray-100 transition-all cursor-not-allowed opacity-30 bg-darkgreen hover:bg-darkgreen/90 hover:text-white rounded-t-md">
                    <x-heroicon-s-check class="w-5 h-5"/>
                    Save
                </button>
                <button 
                    x-show="edit"
                    x-cloak
                    type="button" 
                    x-on:click="$wire.save(); edit = false"
                    class="inline-flex px-2 py-1 text-sm text-gray-100 transition-all bg-darkgreen hover:bg-darkgreen/90 hover:text-white rounded-t-md">
                    <x-heroicon-s-check class="w-5 h-5"/>
                    Save
                </button>
            </div>
        </div>
        <div class="relative p-8 mt-12 space-y-8 bg-white border border-gray-300 rounded-md">
            
            @foreach ($settings as $setting)
                @php  $var = $setting['key']; @endphp
                <div x-data="{
                    blur: {{ $setting['blur'] }},
                    toggle() {
                        this.blur = !this.blur;
                    }
                }"
                    x-on:blur-{{ $setting['key'] }}.window="toggle()"
                    x-on:blur-all.window="blur = $event.detail.enable;"
                    class="">

                    <h4 class="text-lg font-bold text-darkgreen">{{ $setting['description'] }}</h4>

                    <div class="mt-2">
                        <button 
                        type="button"
                        x-show="!edit"
                        x-on:click="toggle()"
                        :class="blur ? 'blur-sm' : ''"
                        class="block p-1 text-sm font-light text-left text-gray-500 cursor-pointer min-h-[3rem]">
                        {{ $script->{$setting['key']} }}
                    </button>

                    <textarea wire:model.defer="{{ $setting['key'] }}" 
                        rows="1"  
                        x-show="edit" 
                        x-cloak 
                        class="p-1 min-h-[3rem] block w-full text-sm font-light text-gray-500 bg-gray-100 border-none" ></textarea>
                    </div>
                        
                </div>
            @endforeach

        </div>
    </section>

    <h2 class="mt-8 text-xl font-bold text-darkgreen">Images</h2>

    <div class="flex gap-2 p-8 mt-8 bg-white border border-gray-300 rounded-md">
        @forelse($script->images as $image)
        <div class="relative">
            <img src="{{ $image->url }}"
                class="max-h-[12rem] overflow-auto w-auto h-auto" loading="lazy"
                alt="">
            <div x-show="edit" 
                 x-cloak 
                 class="absolute top-0 right-0 z-10">
                <button type="button" x-on:click="if( confirm('Delete image?') ) { $wire.deleteImage(`{{ $image->id }}`) }">
                    <x-heroicon-s-x class="w-6 h-6 p-1 text-white bg-red-600 rounded-full hover:bg-red-900"/>
                </button>
            </div>
        </div>
        @empty
            <div class="flex items-center justify-center w-32 h-32 bg-gray-100 border border-gray-300">
                <img src="{{ asset('img/placeholder.png') }}" class="w-24 h-auto">
            </div>
        @endforelse

        <div
            x-data="{ isUploading: false, progress: 0 }"
            x-on:livewire-upload-start="isUploading = true"
            x-on:livewire-upload-finish="isUploading = false"
            x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress"
        >
            <!-- File Input -->
            <input x-show="edit" type="file" wire:model="images" multiple>
        
            <!-- Progress Bar -->
            <div x-show="isUploading">
                <progress max="100" x-bind:value="progress"></progress>
            </div>
        </div>

        <x-validation-errors/>
    </div>

    <h2 class="mt-8 text-xl font-bold text-darkgreen">Links</h2>

    <div class="relative p-8 mt-8 bg-white border border-gray-300 rounded-md">
        <div class="absolute right-10 -top-7">
            <div class="flex gap-1">
                <button type="button" 
                    x-show="!edit"
                    x-on:click="edit = true"
                    class="inline-flex px-2 py-1 text-sm text-gray-900 transition-all bg-red-400 hover:bg-red-600 hover:text-white rounded-t-md">
                    <x-heroicon-s-pencil class="w-5 h-5"/>
                    Edit
                </button>
                <button type="button" 
                    x-show="edit"
                    x-cloak
                    x-on:click="edit = false"
                    class="inline-flex px-2 py-1 text-sm text-gray-900 transition-all bg-red-400 hover:bg-red-600 hover:text-white rounded-t-md">
                    <x-heroicon-s-ban class="w-5 h-5"/>
                    Cancel
                </button>
                <button 
                    x-show="!edit"
                    type="button" 
                    disabled
                    class="inline-flex px-2 py-1 text-sm text-gray-100 transition-all cursor-not-allowed opacity-30 bg-darkgreen hover:bg-darkgreen/90 hover:text-white rounded-t-md">
                    <x-heroicon-s-check class="w-5 h-5"/>
                    Save
                </button>
                <button 
                    x-show="edit"
                    x-cloak
                    type="button" 
                    x-on:click="$wire.save(); edit = false"
                    class="inline-flex px-2 py-1 text-sm text-gray-100 transition-all bg-darkgreen hover:bg-darkgreen/90 hover:text-white rounded-t-md">
                    <x-heroicon-s-check class="w-5 h-5"/>
                    Save
                </button>
            </div>
        </div>
        
        <textarea 
            x-model="links" 
            x-show="edit" 
            x-cloak 
            class="min-h-[3rem] block w-full p-2 mt-2 text-sm font-light  bg-darkgreen/10 text-gray-900 border-none"></textarea>

        <div x-show="!edit" >

            @forelse($script->links as $link)
                <a href="{{ $link->url }}" target="_blank"
                    class="font-sans text-sm text-blue-400 whitespace-normal hover:bg-blue-50 hover:underline">
                    {{ $link->url }}
                </a>
            @empty
                <span>-</span>
            @endforelse
        </div>
    </div>
</div>