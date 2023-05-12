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

            @livewire('scripts.script-document', ['id' => $script['id']], key('doc-' . $script['id']))
            
        @endforeach
    </div>
</div>
