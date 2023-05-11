<div class="bg-gray-100">


    <x-modal-lg ref="categories">
        <div>
            <div>
                <div class="flex">
                    <x-heroicon-s-view-grid class="flex-shrink-0 w-6 h-6 text-gray-500 lg:h-8 lg:w-8" />
                    <div class="ml-2">
                        <h3 class="text-lg text-darkgreen">Categories</h3>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-8 mt-8">
                @foreach ($categories as $categoryItem)
                    <button wire:key="selectcategory-{{ $categoryItem['id'] }}" type="button"
                        wire:click="selectCategory(`{{ $categoryItem['id'] }}`)" class="flex hover:bg-gray-100">
                        <div
                            class="flex items-center justify-center flex-shrink-0 w-10 h-10 mr-1 bg-gray-100 rounded-md">
                            <img src="{{ asset('storage/' . $categoryItem['image']) }}" class="w-8 h-8" alt="">
                        </div>
                        <div class="text-left">
                            <h5 class="font-bold text-darkgreen">{{ $categoryItem['name'] }}</h5>
                            <p class="text-sm text-gray-700">{{ $categoryItem['scripts_count'] ?? 0 }} Scripts</p>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </x-modal-lg>

    <header class="flex justify-between px-6 py-3 bg-white lg:px-16 lg:py-6">
        <div class="flex items-center gap-6">
            <button x-data x-on:click="$dispatch('openmodal-categories')" type="button"
                class="text-darkgreen hover:text-gray-900">
                <x-heroicon-s-view-grid class="flex-shrink-0 w-8 h-8" />
            </button>
            <h1 class="text-xl font-bold leading-7 text-darkgreen sm:leading-9 lg:text-3xl">
                {{ $category->name }}
            </h1>
        </div>

        <div>

        </div>
    </header>

    <div class="px-6 py-12 bg-gray-100 lg:px-16">

        @foreach ($scripts as $script)
            <div class="flex justify-between">
                <div>
                    <h2 class="text-xl font-bold text-darkgreen">{{ $script->title }}</h2>

                    <div class="mt-3">
                        <nav class="flex -mb-px space-x-4" aria-label="Tabs">

                            <div class="flex text-sm font-medium text-indigo-600 whitespace-nowrap">
                                Last Viewed
                                <span
                                    class="ml-1 hidden rounded-full py-0.5 px-2.5 text-xs font-medium text-indigo-600 md:inline-block">
                                    {{ $script->updated_at->format('F d Y') }}
                                </span>
                            </div>

                            <div
                                class="flex px-2 text-sm font-medium text-gray-600 border-l border-gray-300 whitespace-nowrap">
                                Viewed
                                <span
                                    class="ml-1 hidden rounded-full py-0.5 px-2.5 text-xs font-medium text-gray-600 md:inline-block">
                                    #
                                </span>
                            </div>
                            <div
                                class="flex px-2 text-sm font-medium text-gray-600 border-l border-gray-300 whitespace-nowrap">
                                Cards
                                <span
                                    class="ml-1 hidden rounded-full py-0.5 px-2.5 text-xs font-medium text-gray-600 md:inline-block">
                                    #
                                </span>
                            </div>
                            <div
                                class="flex px-2 text-sm font-medium text-gray-600 border-l border-gray-300 whitespace-nowrap">
                                QBanks
                                <span
                                    class="ml-1 hidden rounded-full py-0.5 px-2.5 text-xs font-medium text-gray-600 md:inline-block">
                                    #
                                </span>
                            </div>
                        </nav>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between gap-3 lg:justify-start">

                        {{ $scripts->links('includes.pagination.custom-paginator') }}
                    </div>
    
                    <div class="mt-2 text-xs">Page {{ $scripts->currentPage() }} of {{ $scripts->lastPage() }}</div>
                </div>
            </div>

        


            <section x-data="{ edit: false }">
                <div class="p-8 mt-8 space-y-2 bg-white border border-gray-300 rounded-md">
                    <div x-data="{
                        model: '{{ $script->pathophysiology }}', 
                        active: false,
                        open: false,
                        draft: false,
                    }">
                        <div class="flex justify-between">
                            <div class="flex">
                                <h4 class="text-lg font-bold text-darkgreen">Pathophysiology</h4>
                            </div>
                            <div>
                                <span x-show="draft" class="self-end mb-1 mr-2 text-xs italic text-gray-500">Draft</span>
                                <button 
                                    x-show="draft" 
                                    x-on:click="$wire.save(`{{ $script->id }}`, 'pathophysiology', model); draft = false; open = false"
                                    type="button" 
                                    class="px-2 py-1 text-xs text-white rounded-md bg-darkgreen/80 hover:bg-darkgreen">Save</button>
                            </div>
                        </div>
                        <textarea 
                            x-model="model" 
                            x-on:input="open = true; draft = true;" 
                            x-on:click.away="open = false;"
                            rows="3" 
                            class="block p-2.5 -mx-2 w-full text-sm text-gray-900 bg-white rounded-lg border border-white focus:ring-gray-300 focus:border-gray-300 dark:bg-gray-700 dark:border-gray-300 dark:placeholder-gray-300 dark:text-white dark:focus:ring-gray-300 dark:focus:border-gray-300 focus:bg-gray-100 hover:bg-gray-100">{{ $script->pathophysiology }}</textarea>
                    </div>
                    <div x-data="{
                        model: '{{ $script->epidemiology }}', 
                        active: false,
                        open: false,
                        draft: false,
                    }">
                        <div class="flex justify-between">
                            <div class="flex">
                                <h4 class="text-lg font-bold text-darkgreen">Epidemiology</h4>
                            </div>
                            <div>
                                <span x-show="draft" class="self-end mb-1 mr-2 text-xs italic text-gray-500">Draft</span>
                                <button 
                                    x-show="draft" 
                                    x-on:click="$wire.save(`{{ $script->id }}`, 'epidemiology', model); draft = false; open = false"
                                    type="button" 
                                    class="px-2 py-1 text-xs text-white rounded-md bg-darkgreen/80 hover:bg-darkgreen">Save</button>
                            </div>
                        </div>
                        <textarea 
                            x-model="model" 
                            x-on:input="open = true; draft = true;" 
                            x-on:click.away="open = false;"
                            rows="3" 
                            class="block p-2.5 -mx-2 w-full text-sm text-gray-900 bg-white rounded-lg border border-white focus:ring-gray-300 focus:border-gray-300 dark:bg-gray-700 dark:border-gray-300 dark:placeholder-gray-300 dark:text-white dark:focus:ring-gray-300 dark:focus:border-gray-300 focus:bg-gray-100 hover:bg-gray-100">{{ $script->pathophysiology }}</textarea>
                    </div>
                    <div x-data="{
                        model: '{{ $script->signs }}', 
                        active: false,
                        open: false,
                        draft: false,
                    }">
                        <div class="flex justify-between">
                            <div class="flex">
                                <h4 class="text-lg font-bold text-darkgreen">Signs and Symptoms</h4>
                            </div>
                            <div>
                                <span x-show="draft" class="self-end mb-1 mr-2 text-xs italic text-gray-500">Draft</span>
                                <button 
                                    x-show="draft" 
                                    x-on:click="$wire.save(`{{ $script->id }}`, 'signs', model); draft = false; open = false"
                                    type="button" 
                                    class="px-2 py-1 text-xs text-white rounded-md bg-darkgreen/80 hover:bg-darkgreen">Save</button>
                            </div>
                        </div>
                        <textarea 
                            x-model="model" 
                            x-on:input="open = true; draft = true;" 
                            x-on:click.away="open = false;"
                            rows="3" 
                            class="block p-2.5 -mx-2 w-full text-sm text-gray-900 bg-white rounded-lg border border-white focus:ring-gray-300 focus:border-gray-300 dark:bg-gray-700 dark:border-gray-300 dark:placeholder-gray-300 dark:text-white dark:focus:ring-gray-300 dark:focus:border-gray-300 focus:bg-gray-100 hover:bg-gray-100">{{ $script->signs }}</textarea>
                    </div>
                    <div x-data="{
                        model: '{{ $script->diagnosis }}', 
                        active: false,
                        open: false,
                        draft: false,
                    }">
                        <div class="flex justify-between">
                            <div class="flex">
                                <h4 class="text-lg font-bold text-darkgreen">Diagnosis</h4>
                            </div>
                            <div>
                                <span x-show="draft" class="self-end mb-1 mr-2 text-xs italic text-gray-500">Draft</span>
                                <button 
                                    x-show="draft" 
                                    x-on:click="$wire.save(`{{ $script->id }}`, 'diagnosis', model); draft = false; open = false"
                                    type="button" 
                                    class="px-2 py-1 text-xs text-white rounded-md bg-darkgreen/80 hover:bg-darkgreen">Save</button>
                            </div>
                        </div>
                        <textarea 
                            x-model="model" 
                            x-on:input="open = true; draft = true;" 
                            x-on:click.away="open = false;"
                            rows="3" 
                            class="block p-2.5 -mx-2 w-full text-sm text-gray-900 bg-white rounded-lg border border-white focus:ring-gray-300 focus:border-gray-300 dark:bg-gray-700 dark:border-gray-300 dark:placeholder-gray-300 dark:text-white dark:focus:ring-gray-300 dark:focus:border-gray-300 focus:bg-gray-100 hover:bg-gray-100">{{ $script->diagnosis }}</textarea>
                    </div>
                    <div x-data="{
                        model: '{{ $script->treatments }}', 
                        active: false,
                        open: false,
                        draft: false,
                    }">
                        <div class="flex justify-between">
                            <div class="flex">
                                <h4 class="text-lg font-bold text-darkgreen">Treatments</h4>
                            </div>
                            <div>
                                <span x-show="draft" class="self-end mb-1 mr-2 text-xs italic text-gray-500">Draft</span>
                                <button 
                                    x-show="draft" 
                                    x-on:click="$wire.save(`{{ $script->id }}`, 'treatments', model); draft = false; open = false"
                                    type="button" 
                                    class="px-2 py-1 text-xs text-white rounded-md bg-darkgreen/80 hover:bg-darkgreen">Save</button>
                            </div>
                        </div>
                        <textarea 
                            x-model="model" 
                            x-on:input="open = true; draft = true;" 
                            x-on:click.away="open = false;"
                            rows="3" 
                            class="block p-2.5 -mx-2 w-full text-sm text-gray-900 bg-white rounded-lg border border-white focus:ring-gray-300 focus:border-gray-300 dark:bg-gray-700 dark:border-gray-300 dark:placeholder-gray-300 dark:text-white dark:focus:ring-gray-300 dark:focus:border-gray-300 focus:bg-gray-100 hover:bg-gray-100">{{ $script->treatments }}</textarea>
                    </div>
                </div>
            </section>

            <h2 class="mt-8 text-xl font-bold text-darkgreen">Images</h2>

            <div class="pt-8 mt-8 border-t">
                @forelse($script->images as $image)
                    <img src="{{ $image->url }}" class="max-h-[12rem] overflow-auto" loading="lazy" alt="">
                @empty
                    <div class="flex items-center justify-center w-32 h-32 bg-gray-100 border border-gray-300">
                        <img src="{{ asset('img/placeholder.png') }}" class="w-24 h-auto">
                    </div>
                @endforelse
            </div>

            <h2 class="mt-8 text-xl font-bold text-darkgreen">Links</h2>

            <div class="px-2 py-1 mt-8 bg-gray-200 border-t">

                @forelse($script->links as $link)
                    <a href="{{ $link->url }}" target="_blank"
                        class="font-sans text-sm text-blue-400 whitespace-normal">
                        {{ $link->url }}
                    </a>
                @empty
                    <span>-</span>
                @endforelse
            </div>
        @endforeach
    </div>
</div>
