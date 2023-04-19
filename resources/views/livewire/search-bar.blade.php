<form>
    <div x-data="{ search: '', list: $wire.entangle('lists').defer }" 
        class="relative hidden md:w-96 md:block">
        <input type="search" 
        x-model="search"  
        class="block rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-300 sm:text-sm sm:leading-6 w-96 h-10" 
        :class="search ? 'rounded-b-none' : ''"
        placeholder="Search">
        <div x-show="search" x-cloak class="absolute left-0 right-0 min-h-[1rem] max-h-[16rem] overflow-auto bg-white top-10 border z-20 rounded-md rounded-l-none rounded-r-none">
            <template x-for="(item,i) in list" :key="i">
                <div>
                    <div
                        x-on:click="$wire.select(item); search = ''" 
                        class="px-6 py-3 border-b cursor-pointer hover:bg-gray-100"  
                        x-show="item.toLowerCase().includes(search.toLowerCase())" 
                        x-text="item">
                    </div>
                </div>
            </template>
        </div>
    </div>
    <x-heroicon-s-search class="w-5 h-5 text-gray-500 md:hidden"/>
</form>