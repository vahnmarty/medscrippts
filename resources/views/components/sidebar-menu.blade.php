@props(['icon', 'active', 'label'])

<div x-data="{ open: false }" x-on:click.away="open = false">
    
    <button x-on:click="open = !open"  
        type="button"
        class="{{ $active ? 'border-l-4 border-orange-400 bg-gray-100 text-black' : 'text-gray-500 hover:bg-gray-100 border-l-4 border-transparent' }} group flex items-center px-2 py-2 text-sm max-h-[40px] overflow-hidden ">
        {{ $icon }}
    </button>
    <div x-show="open">{{ $slot }}</div>
</div>