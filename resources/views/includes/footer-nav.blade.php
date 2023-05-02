<div class="fixed bottom-0 left-0 right-0 bg-white border-t">
    <div class="flex justify-evenly">
        <a href="{{ url('scripts') }}" class="px-3 py-3">
            <x-heroicon-o-home class="w-8 h-8 text-gray-500 hover:text-orange-400"/>
        </a>
        <a href="{{ url('flashcards') }}" class="px-3 py-3">
            <x-heroicon-o-clipboard-list class="w-8 h-8 text-gray-500 hover:text-orange-400"/>
        </a>
        <a href="{{ url('qbanks/mobile') }}" class="px-3 py-3">
            <x-heroicon-o-view-grid class="w-8 h-8 text-gray-500 hover:text-orange-400"/>
        </a>
        <a href="#" x-data x-on:click.prevent="$dispatch('openmodal-studymode')" class="px-3 py-3" aria-title="Study Mode">
            <x-heroicon-o-book-open class="w-8 h-8 text-gray-500 hover:text-orange-400"/>
        </a>
        <a href="#" class="px-3 py-3" aria-title="Script Settings">
            <x-heroicon-o-filter class="w-8 h-8 text-gray-500 hover:text-orange-400"/>
        </a>
    </div>
</div>

<x-modal-sm ref="studymode">
    @livewire('scripts.study-mode')
</x-modal-sm>