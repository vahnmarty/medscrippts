<div class="block min-h-screen transition-all duration-300 ease-in-out bg-white border-r md:overflow-hidden ">
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

                <x-sidebar-menu label="Script" link="{{ url('script') }}" :active="request()->is('script*') ">
                    <x-slot name="icon">
                        <x-heroicon-s-academic-cap class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                    </x-slot>
                    <div>
                        @livewire('script-settings')
                    </div>
                </x-sidebar-menu>


            </div>


            <div class="flex flex-shrink-0 pt-6 pb-5 mt-6">
                <div class="flex-shrink-0 w-full space-y-1">

                    
                    <x-sidebar-item label="Support" link="{{ route('support') }}" :active="request()->is('support*') ">
                        <x-slot name="icon">
                            <x-heroicon-s-chat-alt-2 class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                        </x-slot>
                    </x-sidebar-item>

                </div>
            </div>
        </nav>
    </div>
</div>
