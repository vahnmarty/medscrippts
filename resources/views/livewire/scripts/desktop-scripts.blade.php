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
            <h3 class="mt-2 text-xl font-semibold text-darkgreen">{{ $script->title }}
            </h3>
        </header>
        <div class="gap-6 lg:grid lg:grid-cols-2">
            <div class="p-3 py-4 space-y-3 lg:p-4">
                @foreach ($settings as $setting)
                    <div x-data="{
                        blur: {{ $setting['blur'] }},
                        toggle() {
                            this.blur = !this.blur;
                        }
                    }"
                        x-on:blur-{{ $setting['key'] }}.window="toggle()"
                        x-on:blur-all.window="blur = $event.detail.enable;"
                        class="flex gap-4">
                        <div class="flex-shrink-0 w-10 text-darkgreen">
                            {{ $setting['value'] }}</div>
                        <button type="button" x-on:click="toggle()"
                            :class="{ 'blur-sm' : blur }"
                            class="text-sm text-left text-gray-500 cursor-pointer">{{ $script->{$setting['key']} }}</button>
                    </div>
                @endforeach
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