<div x-data>

    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center">
        <span>
            <button wire:click="resetPage" wire:loading.attr="disabled" rel="prev"
                class="relative inline-flex items-center w-10 h-10 p-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-full focus:shadow-outline-blue hover:text-gray-500 focus:border-blue-300 focus:outline-none active:bg-gray-100 active:text-gray-700">
                <x-heroicon-s-refresh class="w-6 h-6" />
            </button>
        </span>

        <span>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span
                    class="relative inline-flex items-center w-10 h-10 p-2 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 rounded-full cursor-default">
                    <x-heroicon-s-arrow-left class="w-6 h-6 text-gray-300" />
                </span>
            @else
                <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev"
                    class="relative inline-flex items-center w-10 h-10 p-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-full focus:shadow-outline-blue hover:text-gray-500 focus:border-blue-300 focus:outline-none active:bg-gray-100 active:text-gray-700">
                    <x-heroicon-s-arrow-left class="w-6 h-6" />
                </button>
            @endif
        </span>

        <span>
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" x-on:click="$dispatch('flipup'); console.log('flip')"
                    wire:loading.attr="disabled" rel="next"
                    class="relative inline-flex items-center w-10 h-10 p-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-full focus:shadow-outline-blue hover:text-gray-500 focus:border-blue-300 focus:outline-none active:bg-gray-100 active:text-gray-700">
                    <x-heroicon-s-arrow-right class="w-6 h-6" />
                </button>
            @else
                <span
                    class="relative inline-flex items-center w-10 h-10 p-2 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 rounded-full cursor-default">
                    <x-heroicon-s-arrow-right class="w-6 h-6 text-gray-300" />
                </span>
            @endif
        </span>
    </nav>
</div>
