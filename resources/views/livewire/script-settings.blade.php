<div class="fixed top-0 z-30 flex flex-col justify-between flex-shrink-0 min-h-screen p-3 bg-white w-60 [left:65px] border-r">
        
    <div>
        <div class="flex items-center gap-2 mt-8 mb-4 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
              </svg>
            <h1 class="text-xl font-bold">Categories</h1>
        </div>
<!-- 
        <div x-data="{ open: false }" class="px-3 py-2 hover:bg-gray-100">
            <button type="button" x-on:click="open = !open" class="flex items-center justify-between w-full text-sm text-gray-600">
                <span class="text-gray-600">Select Category</span>
                <x-heroicon-s-chevron-down class="w-5 h-5 text-gray-600"/>
            </button>
            <div x-show="open" x-cloak>
                @foreach($categories as $categoryItem)
                <div>{{ $categoryItem->name }}</div>
                @endforeach
            </div>
        </div>
         -->
        <div>
            <select wire:model="category_id" class="w-full text-sm text-gray-600 border border-transparent cursor-pointer">
                <option value="">Select Category</option>
                @foreach($categories as $categoryItem)
                <option>{{ $categoryItem->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select wire:model="script_id" class="w-full text-sm text-gray-600 border border-transparent cursor-pointer">
                <option value="">Select Script</option>
                @foreach($scripts as $scriptItem)
                <option>{{ $scriptItem->title }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <div class="py-2 border-t border-b border-gray-300">
            <div class="flex gap-3">
                <x-heroicon-s-book-open class="text-gray-500 w-7 h-7"/>
                <div>
                    <h3>Study Mode</h3>
                    <p class="text-sm text-gray-600">Selectively blur</p>
                </div>
            </div>
        </div>

        <div class="mt-8 space-y-3">
            @foreach($study_settings as $i => $setting )
            <div x-data="{ enable: `{{ $setting['value'] }}` }" 
                class="flex items-center justify-between">
                <p class="text-sm text-gray-500">{{ $setting['name'] }}</p>
                <button type="button" 
                    x-on:click="enable = !enable; $wire.blur('{{ $setting['key'] }}', enable)"
                    :class="enable ? 'bg-indigo-600' : 'bg-gray-200' "
                    class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false" aria-labelledby="availability-label" aria-describedby="availability-description">
                  <span aria-hidden="true" 
                   :class="{'translate-x-5': enable, 'translate-x-0': !enable }"
                    class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none ring-0"></span>
                </button>
            </div>
            @endforeach
        </div>
          
    </div>
</div>