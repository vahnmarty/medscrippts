<div class="lg:hidden">
    <div x-data="{ flip: false, edit: false }" 
        x-on:edit-card.window="edit = !edit"
        x-on:flipup.window="flip = false"
        x-on:flipback.window="flip = true"
        class="group h-[32rem] w-full [-webkit-perspective:1000px]">
        <div :class="flip ? 'rotate-y-180' : ''"
            class="relative w-full h-full transition-all duration-500 rounded-xl transform-3d">

            <div aria-title="Front" class="absolute inset-0 [backface-visibility:hidden] p-4 pb-20 overflow-auto bg-white">
                <div>
                    <header class="text-left">
                        <div>
                            <p class="text-orange-500">
                                {{ $script->category->name ?? 'Uncategorized' }}</p>
                            <h3 class="mt-2 text-xl font-semibold text-darkgreen">
                                {{ $script->title }}</h3>
                        </div>
                    </header>
                    <div class="gap-6 lg:grid lg:grid-cols-2">
                        <div class="p-0 py-4 space-y-2 divide-y divide-gray-100 lg:p-4">
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
                                    class="flex items-start gap-2 pt-4 lg:gap-4">

                                    <div class="flex-shrink-0 w-10 text-darkgreen">
                                        {{ $setting['value'] }}
                                    </div>

                                    <button 
                                        x-show="!edit"
                                        type="button" x-on:click="toggle()"
                                        :class="blur ? 'blur-sm' : ''"
                                        class="block text-sm font-light text-left text-gray-500 cursor-pointer">{{ $script->$var }}</button>

                                    <textarea rows="1"  x-show="edit" x-cloak class="min-h-[3rem] block w-full p-0 text-sm font-light text-gray-500 bg-gray-100 border-none" >{{ $script->$var }}</textarea>
                                        
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 right-0 bg-white [backface-visibility:hidden]">
                <div class="w-full h-2 bg-gray-700/10 backdrop-blur-xl"></div>
                <div class="px-4 py-4">
                    <div class="flex justify-between">
                        <div class="flex items-center">
                            <button type="button"
                                x-show="!edit"
                                x-on:click="edit = !edit"
                                class="rounded-md bg-blue-100 px-3 py-1.5 text-sm text-blue-500">Edit</button>
                            <button type="button"
                                x-show="edit"
                                x-cloak
                                x-on:click="$wire.save('');edit = !edit"
                                class="btn-sm btn-primary">Save</button>
                            <button type="button"
                                x-show="edit"
                                x-cloak
                                x-on:click="edit = !edit"
                                class="flex items-center justify-center p-1 ml-2 rounded-full bg-red-50">
                                <x-heroicon-s-ban class="w-6 h-6 text-red-700"/>
                            </button>
                        </div>
                        <button type="button" x-on:click="flip = !flip">
                            <x-heroicon-s-switch-horizontal
                                class="w-6 h-6 text-gray-400" />
                        </button>
                    </div>
                </div>
            </div>
            <div aria-title="Back" 
                class="text-slate-200 absolute inset-0 h-full w-full rounded-xl bg-white p-4 rotate-y-180 [backface-visibility:hidden] lg:text-center overflow-auto pb-20 ">
                <div>
                    <header class="text-left">
                        <div>
                            <p class="text-orange-500">
                                {{ $script->category->name ?? 'Uncategorized' }}</p>
                            <h3 class="mt-2 text-xl font-semibold text-darkgreen">
                                {{ $script->title }}</h3>
                        </div>
                    </header>
                    <div class="pb-2 border-b border-dashed">

                        <h3 class="mt-8">Links</h3>
                        <div class="p-2 mt-2 bg-gray-100">
                            @forelse($script->links as $link)
                                <a href="{{ $link->url }}" target="_blank"
                                    class="font-sans text-sm text-blue-400 word-break">
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
                                    class="max-h-[12rem] overflow-auto w-32 h-auto" >
                            @endforelse
                        </div>
                    </div>
                    
                </div>
                
            </div>

            <div class="absolute bottom-0 left-0 right-0 px-4 py-4 bg-white [backface-visibility:hidden] rotate-y-180">
                <div class="flex justify-between">
                    <button type="button"
                        class="rounded-md bg-blue-100 px-3 py-1.5 text-sm text-blue-500">Edit</button>
                    <button type="button" x-on:click="flip = !flip">
                        <x-heroicon-s-switch-horizontal
                            class="w-6 h-6 text-gray-400" />
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>