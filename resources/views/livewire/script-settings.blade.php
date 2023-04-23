<div x-data="{ 
        open: false, 
        count: $wire.entangle('n'),
        isDesktop: false,
        screenResponsive(){
            this.isDesktop = window.innerWidth > 720;
        }
     }"
    x-init="screenResponsive(); open = isDesktop && count"
    x-on:resize.window="screenResponsive()"
    x-on:toggle-settings.window="open = !open"
    :class="open ? 'w-72' : 'w-0'"
    x-cloak
    class="overflow-hidden transition-all duration-300 ease-in-out bg-white border-r">
        
    <div class="flex flex-col justify-between flex-shrink-0 min-h-screen p-6">
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
                <select wire:model="category_id" class="w-full text-sm text-gray-600 border border-transparent cursor-pointer hover:bg-gray-100">
                    <option value="">Select Category</option>
                    @foreach($categories as $categoryItem)
                    <option value="{{ $categoryItem->id }}">{{ $categoryItem->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model="script_id" class="w-full text-sm text-gray-600 border border-transparent cursor-pointer hover:bg-gray-100">
                    <option value="">Select Script </option>
                    @foreach($scripts as $scriptItem)
                    @if($category_id)
                        @if($category_id == $scriptItem->category_id)
                        <option value="{{ $scriptItem->id }}">{{ $scriptItem->title }}</option>
                        @endif
                    @else
                    <option value="{{ $scriptItem->id }}">Else {{ $scriptItem->title }}</option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="mt-8">
                <button x-data wire:click="$emit('createScript')"  type="button" class="w-full btn-primary btn-sm">
                    <span>Create Script</span>
                </button>
                <x-modal-lg ref="script">
                    @livewire('scripts.crud-script')
                </x-modal-lg>
            </div>
        </div>
    
        <div>
            <div class="py-2 border-t border-b border-gray-300">
                <div class="flex justify-between gap-3">
                    <div class="flex flex-shrink-0">
                        <x-heroicon-s-book-open class="w-6 h-6 text-gray-500"/>
                        <div class="ml-2">
                            <h3>Study Mode</h3>
                            <p class="text-sm text-gray-600">Selectively blur</p>
                        </div>
                    </div>
                    <div x-data="{ 
                            enable: @entangle('blurAll'),
                            toggle(){
                                this.enable = !this.enable;
                                @this.setBlurAll(this.enable);

                                this.$dispatch('blur-all', { enable: this.enable });
                            }
                         }" 
                         class="self-center">
                        <button type="button" 
                            x-on:click="toggle()"
                            :class="enable ? 'bg-indigo-600' : 'bg-gray-200' "
                            class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2" role="switch" aria-checked="false" aria-labelledby="availability-label" aria-describedby="availability-description">
                        <span aria-hidden="true" 
                        :class="{'translate-x-5': enable, 'translate-x-0': !enable }"
                            class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none ring-0"></span>
                        </button>
                    </div>
                </div>
            </div>
    
            <div class="mt-8 space-y-3">
                @foreach($study_settings as $i => $setting )
                <div x-data="{ 
                        enable: $wire.entangle('study_settings.{{ $i }}.blur'),
                        key: $wire.entangle('study_settings.{{ $i }}.key'),
                        blur(){
                            this.enable = !this.enable;
                            @this.blur(this.key, this.enable);
                            this.$dispatch('blur-' + this.key);
                        }
                    }" 
                    class="flex items-center justify-between">
                    <p class="flex-shrink-0 text-sm text-gray-500">{{ $setting['description'] }}</p>
                    <button type="button" 
                        x-on:click="blur()"
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
</div>