@props(['variable', 'title'])

<div x-data="{
    model: $wire.entangle($variable), 
    active: false,
    open: false,
    draft: false,
}">
    <div class="flex justify-between">
        <div class="flex">
            <h4 class="text-lg font-bold text-darkgreen">{{ $title }}</h4>
        </div>
        <div>
            <span x-show="draft" class="self-end mb-1 mr-2 text-xs italic text-gray-500">Draft</span>
            <button x-show="draft" type="button" class="px-2 py-1 text-xs text-white rounded-md bg-darkgreen/80 hover:bg-darkgreen">Save</button>
        </div>
    </div>
    <textarea 
        x-model="model" 
        x-on:input="open = true; draft = true" 
        x-on:click.away="open = false;"
        rows="3" 
        class="block p-2.5 -mx-2 w-full text-sm text-gray-900 bg-white rounded-lg border border-white focus:ring-gray-300 focus:border-gray-300 dark:bg-gray-700 dark:border-gray-300 dark:placeholder-gray-300 dark:text-white dark:focus:ring-gray-300 dark:focus:border-gray-300 focus:bg-gray-100 hover:bg-gray-100">{{ $script->pathophysiology }}</textarea>
</div>