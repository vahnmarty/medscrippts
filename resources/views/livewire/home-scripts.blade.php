<div>

    <div class="px-2 py-6 bg-gray-100 lg:py-12 lg:px-16">


        @if (count($scripts))
            <section>
                <div x-data="{}">
                    <div id="slider" class="">
                        @foreach ($scripts as $index => $script)
                            <div wire:key="script-{{ $index }}" x-data="{ open: false }" class="relative mx-1">

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
                                                            class="max-h-[12rem] overflow-auto" loading="lazy"
                                                            alt="">
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="lg:hidden">
                                    <div x-data="{ flip: false }" x-on:flipup.window="flip = false"
                                        x-on:flipback.window="flip = true"
                                        class="group h-[32rem] w-full [perspective:1000px]">
                                        <div :class="flip ? '[transform:rotateY(180deg)]' : ''"
                                            class="relative h-full w-full rounded-xl transition-all duration-500 [transform-style:preserve-3d]">
                                            <div class="absolute inset-0 p-4 pb-20 overflow-auto bg-white">
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
                                                                    class="flex gap-2 pt-4 lg:gap-4">
                                                                    <div class="flex-shrink-0 w-10 text-darkgreen">
                                                                        {{ $setting['value'] }}</div>
                                                                    <button type="button" x-on:click="toggle()"
                                                                        :class="blur ? 'blur-sm' : ''"
                                                                        class="text-sm font-light text-left text-gray-500 cursor-pointer">{{ $script->$var }}</button>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="absolute bottom-0 left-0 right-0 bg-white">
                                                <div class="w-full h-2 bg-gray-700/10 backdrop-blur-xl"></div>
                                                <div class="px-4 py-4">
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
                                            <div
                                                class="text-slate-200 absolute inset-0 h-full w-full rounded-xl bg-white p-4 [transform:rotateY(180deg)] [backface-visibility:hidden] lg:text-center">
                                                <div>
                                                    <header class="text-left">
                                                        <div>
                                                            <p class="text-orange-500">
                                                                {{ $script->category->name ?? 'Uncategorized' }}</p>
                                                            <h3 class="mt-2 text-xl font-semibold text-darkgreen">
                                                                {{ $script->title }}</h3>
                                                        </div>
                                                    </header>
                                                    <div>

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
                                                                    class="max-h-[12rem] overflow-auto" loading="lazy"
                                                                    alt="">
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="absolute bottom-0 left-0 right-0 px-4 py-4 bg-white">
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
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="items-center justify-between block mt-8 lg:flex">
                        @foreach($scripts as $script)
                        <div class="flex hidden gap-8 p-4 bg-white rounded-md lg:block">
                            <div>
                                <strong class="font-semibold text-gray-900">0</strong>
                                <span class="ml-2 text-xs text-gray-700">Views</span>
                            </div>
                            <div>
                                <strong class="font-semibold text-gray-900">{{ $script->updated_at->format('M d, Y')}}</strong>
                                <span class="ml-2 text-xs text-gray-700">Last Updated</span>
                            </div>
                        </div>
                        @endforeach
                        <div class="flex items-center justify-between gap-3 lg:justify-start">
                            <span>Page {{ $scripts->currentPage() }} of {{ $scripts->lastPage() }}</span>

                            {{ $scripts->links('includes.pagination.custom-paginator') }}
                        </div>
                    </div>


                </div>
            </section>
        @else
            <section class="py-16 bg-gray-200">
                <div class="text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No scripts</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new scripts.</p>
                    <div class="mt-6">
                        <button x-data wire:click="$emit('createScript')" type="button"
                            class="inline-flex btn-primary">
                            <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path
                                    d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Create Script
                        </button>
                        <button x-data x-on:click="$dispatch('openmodal-import')" type="button"
                            class="inline-flex ml-4 btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="-ml-0.5 mr-1.5 h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                            </svg>

                            Import Scripts
                        </button>
                    </div>
                </div>

            </section>

            <x-modal-sm ref="import">
                @livewire('scripts.import-scripts')
            </x-modal-sm>
        @endif
    </div>


</div>

@push('scripts')
@endpush
