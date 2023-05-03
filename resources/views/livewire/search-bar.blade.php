<div>
    <form>
        <div x-data="{
            search: '',
            list: $wire.entangle('lists').defer
        }" class="relative hidden md:w-96 lg:block">

            <input type="search" x-model="search"
                class="block h-10 w-96 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-300 sm:text-sm sm:leading-6"
                :class="search ? 'rounded-b-none' : ''" placeholder="Search">

            <div x-show="search" x-cloak
                class="absolute left-0 right-0 top-10 z-20 max-h-[16rem] min-h-[1rem] overflow-auto rounded-md rounded-l-none rounded-r-none border bg-white">

                <template x-for="(item,i) in list" :key="i">
                    <div>
                        <div x-on:click="$wire.select(i); search = ''"
                            class="px-6 py-3 border-b cursor-pointer hover:bg-gray-100"
                            x-show="item.toLowerCase().includes(search.toLowerCase())" x-text="item + ' ' + i">
                        </div>
                    </div>
                </template>

            </div>
        </div>

    </form>



    <div class="lg:hidden">
        <button x-data x-on:click="$dispatch('openmodal-searchbar')" type="button">
            <x-heroicon-s-search class="w-5 h-5 text-gray-500 md:hidden" />
        </button>

        <x-modal-sm ref="searchbar">
            <div x-data="{
                search: '',
                list: $wire.entangle('lists').defer
            }">
                <div class="flex">
                    <x-heroicon-s-search class="flex-shrink-0 w-6 h-6 text-gray-500 lg:h-8 lg:w-8" />
                    <div class="ml-2">
                        <h3 class="text-lg text-darkgreen">Search</h3>
                    </div>
                </div>

                <div class="mt-8" class="relative">
                    <input type="search" x-model="search"
                        class="block h-10 w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-300 sm:text-sm sm:leading-6"
                        :class="search ? 'rounded-b-none' : ''" placeholder="Enter keywords">

                    <div
                        class="mt-4 max-h-[26rem] min-h-[26rem] overflow-auto rounded-md rounded-l-none rounded-r-none border bg-white">

                        <template x-for="(item,i) in list" :key="i">
                            <div>
                                <div x-on:click="$wire.select(i); search = ''; $dispatch('closemodal-searchbar') "
                                    class="px-6 py-3 border-b cursor-pointer hover:bg-gray-100"
                                    x-show="item.toLowerCase().includes(search.toLowerCase())" x-text="item + ' ' + i">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </x-modal-sm>
    </div>
</div>
