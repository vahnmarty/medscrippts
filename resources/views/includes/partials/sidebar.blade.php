<div class="hidden min-h-screen transition-all duration-300 ease-in-out bg-white border-r lg:block md:overflow-hidden ">
    <div class="flex flex-col flex-grow min-h-screen py-5 overflow-y-auto">
        <div class="flex justify-center">
            <div class="flex items-center bg-transparent rounded-md">
                <button x-on:click="$store.sidebarExpanded.toggle()" type="button">
                    <img class="flex-shrink-0 w-auto h-8" src="{{ site_logo() }}" alt="{{ settings('name') }}">
                </button>
            </div>
        </div>

        <nav class="flex flex-col flex-1 mt-5 overflow-y-auto divide-y divide-gray-300" aria-label="Sidebar">
            <div class="flex-1 space-y-1">

                <x-sidebar-item label="Home" link="{{ url('dashboard') }}" :active="request()->is('dashboard*') ">
                    <x-slot name="icon">
                        <x-heroicon-s-home class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                    </x-slot>
                </x-sidebar-item>

                <a x-data
                    x-on:click.prevent="$dispatch('toggle-settings')"
                    href="#"
                    class="text-gray-500 hover:bg-gray-100 border-l-4 border-transparent group flex items-center px-2 py-2 text-sm max-h-[40px] overflow-hidden">
                    <x-heroicon-s-cog class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                </a>

                @if(null)
                <button x-data
                    x-on:click="$dispatch('openmodal-qbank')"
                    class="text-gray-500 hover:bg-gray-100 border-l-4 border-transparent group flex items-center px-2 py-2 text-sm max-h-[40px] overflow-hidden"
                    aria-current="page">
                    <x-heroicon-s-question-mark-circle class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                </button>

               
                <x-modal-sm ref="qbank">
                    <div class="py-4">
                        @livewire('question-generator')
                    </div>
                </x-modal-sm>
                @endif

                <x-sidebar-item label="Flash Cards" link="{{ url('flashcards') }}" :active="request()->is('flashcards*') ">
                    <x-slot name="icon">
                        <x-heroicon-s-clipboard-list class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                    </x-slot>
                </x-sidebar-item>

                <x-sidebar-item label="QBanks" link="{{ url('qbanks') }}" :active="request()->is('qbanks*') ">
                    <x-slot name="icon">
                        <x-heroicon-s-question-mark-circle class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                    </x-slot>
                </x-sidebar-item>




            </div>


            <div class="flex flex-shrink-0 pt-6 pb-5 mt-6">
                <div class="flex-shrink-0 w-full space-y-1">

                    <a href="https://docs.medscrippts.com"
                        target="_blank"
                        class="text-gray-500 hover:bg-gray-100 border-l-4 border-transparent group flex items-center px-2 py-2 text-sm max-h-[40px] overflow-hidden">
                        <x-heroicon-s-chat-alt-2 class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                    </a>

                    <a href="{{ url('billing-portal') }}"
                        target="_blank"
                        class="text-gray-500 hover:bg-gray-100 border-l-4 border-transparent group flex items-center px-2 py-2 text-sm max-h-[40px] overflow-hidden">
                        <x-heroicon-s-cash class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                    </a>

                </div>
            </div>
        </nav>
    </div>
</div>
