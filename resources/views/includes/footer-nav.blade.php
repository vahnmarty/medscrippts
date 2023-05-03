<div class="fixed bottom-0 left-0 right-0 bg-white border-t">
    <div class="flex justify-evenly">
        <a href="{{ url('scripts') }}" class="px-3 py-3 {{ request()->is('scripts') ? 'text-orange-500' : 'text-gray-500' }}">
            <x-heroicon-o-home class="w-8 h-8"/>
        </a>
        <a href="{{ url('flashcards') }}" class="px-3 py-3 {{ request()->is('flashcards*') ? 'text-orange-500' : 'text-gray-500' }}">
            <x-heroicon-o-clipboard-list class="w-8 h-8"/>
        </a>
        <a href="{{ url('qbanks/mobile') }}" class="px-3 py-3 {{ request()->is('qbanks*') ? 'text-orange-500' : 'text-gray-500' }}">
            <x-heroicon-o-view-grid class="w-8 h-8"/>
        </a>
        @if(request()->is('scripts'))
        <a href="#" x-data x-on:click.prevent="$dispatch('openmodal-studymode')" class="px-3 py-3" aria-title="Study Mode">
            <x-heroicon-o-book-open class="w-8 h-8 text-gray-500 hover:text-orange-400"/>
        </a>
        <a href="#" x-data x-on:click.prevent="$dispatch('openmodal-filter')" class="px-3 py-3" aria-title="Script Settings">
            <x-heroicon-o-filter class="w-8 h-8 text-gray-500 hover:text-orange-400"/>
        </a>
        @else
        <a href="#" disabled class="px-3 py-3 opacity-20" aria-title="Study Mode">
            <x-heroicon-o-book-open class="w-8 h-8 text-gray-500"/>
        </a>
        <a href="#" disabled class="px-3 py-3 opacity-20" aria-title="Script Settings">
            <x-heroicon-o-filter class="w-8 h-8 text-gray-500"/>
        </a>
        @endif
    </div>
</div>

<x-modal-sm ref="studymode">
    @livewire('scripts.study-mode')
</x-modal-sm>

<x-modal-sm ref="filter">
    @livewire('scripts.filter-scripts')
</x-modal-sm>