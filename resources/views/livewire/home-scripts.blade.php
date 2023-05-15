<div>

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

            <div class="grid gap-8 mt-8 lg:grid-cols-3">
                @foreach ($categories as $categoryItem)
                    <button wire:key="selectcategory-{{ $categoryItem['id'] }}" type="button"
                        wire:click="selectCategory(`{{ $categoryItem['id'] }}`)" class="flex hover:bg-gray-100">
                        <div
                            class="flex items-center justify-center flex-shrink-0 w-10 h-10 mr-1 bg-gray-100 rounded-md">
                            <img src="{{ asset('storage/' . $categoryItem['image']) }}" class="w-8 h-8" alt="">
                        </div>
                        <div class="text-left">
                            <h5 class="font-bold text-darkgreen">{{ $categoryItem['name'] }}</h5>
                            <p class="text-sm text-gray-700">{{ $categoryItem['user_scripts_count'] ?? 0 }} Scripts</p>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </x-modal-lg>

    <header class="flex justify-between px-6 py-3 bg-white lg:px-16 lg:py-6">
        <div class="flex items-center gap-6">
            <button x-data x-on:click="$dispatch('openmodal-categories')" type="button"
                class="p-2 border border-gray-200 rounded-full shadow-lg text-darkgreen hover:text-gray-900 bg-gray-50">
                <x-heroicon-s-view-grid class="flex-shrink-0 w-8 h-8" />
            </button>
            <h1 class="text-xl font-bold leading-7 text-darkgreen sm:leading-9 lg:text-3xl">
                {{ $category->name }}
            </h1>
        </div>
    </header>

    <div class="px-2 py-6 bg-gray-100 lg:py-12 lg:px-16">

        

        @if (count($scripts))
            <section>
                <div x-data="{}">
                    <div id="slider" class="">
                        @foreach ($scripts as $index => $script)
                            <div wire:key="script-{{ $index }}" x-data="{ open: false }" class="relative mx-1">
                                <div class="hidden lg:block">
                                    <div class="flex justify-between">
                                        <div>
                                            <h2 class="text-xl font-bold text-darkgreen">{{ $script->title }}</h2>
                        
                                            <div class="mt-3">
                                                <nav class="flex -mb-px space-x-4" aria-label="Tabs">
                        
                                                    <div class="flex text-sm font-medium text-indigo-600 whitespace-nowrap">
                                                        Last Viewed
                                                        <span
                                                            class="ml-1 hidden rounded-full py-0.5 px-2.5 text-xs font-medium text-indigo-600 md:inline-block">
                                                            {{ $script->viewed_at?->format('F d Y') }}
                                                        </span>
                                                    </div>
                        
                                                    <div
                                                        class="flex px-2 text-sm font-medium text-gray-600 border-l border-gray-300 whitespace-nowrap">
                                                        Viewed:
                                                        <span
                                                            class="ml-1 hidden rounded-full py-0.5 px-2.5 text-xs font-medium text-gray-600 md:inline-block">
                                                            {{ $script->views }}
                                                        </span>
                                                    </div>
                                                    <div
                                                        class="flex px-2 text-sm font-medium text-gray-600 border-l border-gray-300 whitespace-nowrap">
                                                        Cards:
                                                        <span
                                                            class="ml-1 hidden rounded-full py-0.5 px-2.5 text-xs font-medium text-gray-600 md:inline-block">
                                                            {{ $script->flashcards_count ?? '0' }}
                                                        </span>
                                                    </div>
                                                    <div
                                                        class="flex px-2 text-sm font-medium text-gray-600 border-l border-gray-300 whitespace-nowrap">
                                                        QBanks:
                                                        <span
                                                            class="ml-1 hidden rounded-full py-0.5 px-2.5 text-xs font-medium text-gray-600 md:inline-block">
                                                            {{ $script->qbanks_count ?? '0' }}
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
                                    @livewire('scripts.script-document', ['id' => $script['id']], key('document-' . $script->id))
                                </div>
                                @livewire('scripts.script-card', ['id' => $script['id']], key('card-' . $script->id))
                            </div>
                        @endforeach
                    </div>

                    <div class="items-center justify-between block mt-8 lg:flex">
                        @foreach($scripts as $script)
                        <div class="hidden gap-8 p-4 bg-white rounded-md lg:flex">
                            <div>
                                <strong class="font-semibold text-gray-900">{{ $script->views }}</strong>
                                <span class="ml-2 text-xs text-gray-700">Views</span>
                            </div>
                            <div>
                                <strong class="font-semibold text-gray-900">{{ $script->viewed_at ? $script->viewed_at->format('M d, Y') : date('M d, Y') }}</strong>
                                <span class="ml-2 text-xs text-gray-700">Last Viewed</span>
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

