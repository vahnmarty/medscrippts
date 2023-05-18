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
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500">
                            <path fill-rule="evenodd" d="M2.25 4.125c0-1.036.84-1.875 1.875-1.875h5.25c1.036 0 1.875.84 1.875 1.875V17.25a4.5 4.5 0 11-9 0V4.125zm4.5 14.25a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25z" clip-rule="evenodd" />
                            <path d="M10.719 21.75h9.156c1.036 0 1.875-.84 1.875-1.875v-5.25c0-1.036-.84-1.875-1.875-1.875h-.14l-8.742 8.743c-.09.089-.18.175-.274.257zM12.738 17.625l6.474-6.474a1.875 1.875 0 000-2.651L15.5 4.787a1.875 1.875 0 00-2.651 0l-.1.099V17.25c0 .126-.003.251-.01.375z" />
                          </svg>
                          
                    </x-slot>
                </x-sidebar-item>

                <x-sidebar-item label="QBanks" link="{{ url('qbanks') }}" :active="request()->is('qbanks*') ">
                    <x-slot name="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500">
                            <path d="M4.913 2.658c2.075-.27 4.19-.408 6.337-.408 2.147 0 4.262.139 6.337.408 1.922.25 3.291 1.861 3.405 3.727a4.403 4.403 0 00-1.032-.211 50.89 50.89 0 00-8.42 0c-2.358.196-4.04 2.19-4.04 4.434v4.286a4.47 4.47 0 002.433 3.984L7.28 21.53A.75.75 0 016 21v-4.03a48.527 48.527 0 01-1.087-.128C2.905 16.58 1.5 14.833 1.5 12.862V6.638c0-1.97 1.405-3.718 3.413-3.979z" />
                            <path d="M15.75 7.5c-1.376 0-2.739.057-4.086.169C10.124 7.797 9 9.103 9 10.609v4.285c0 1.507 1.128 2.814 2.67 2.94 1.243.102 2.5.157 3.768.165l2.782 2.781a.75.75 0 001.28-.53v-2.39l.33-.026c1.542-.125 2.67-1.433 2.67-2.94v-4.286c0-1.505-1.125-2.811-2.664-2.94A49.392 49.392 0 0015.75 7.5z" />
                          </svg>
                          
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
