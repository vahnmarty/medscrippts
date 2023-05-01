<div>
    <div class="py-2 border-gray-300">
        <div>
            <div class="flex">
                <x-heroicon-s-book-open class="flex-shrink-0 w-6 h-6 text-gray-500"/>
                <div class="ml-2">
                    <h3 class="text-lg text-darkgreen">Study Mode</h3>
                </div>
            </div>
            <p class="text-sm text-gray-700">Scripts can be blurred, and then revealed by clicking them. Select which sections you would like to blur!</p>
            
        </div>

        <div class="flex justify-between gap-3 mt-8">
            <h3>Blur All</h3>
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

    <div class="pt-4 mt-0 space-y-6 border-t">
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