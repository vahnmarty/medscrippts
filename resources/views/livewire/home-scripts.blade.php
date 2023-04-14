
<div>
    <div class="px-4 py-12 bg-gray-100 lg:px-16">
        <section>
            <div x-data="{ }">
                <div id="slider">
                    @foreach($scripts as $index => $script)
                    <div wire:key="script-{{ $index }}" 
                            x-data="{ open: false }"
                            class="relative bg-white">
                        <div class="hidden md:block">
                            <div class="absolute top-5 right-5">
                                <button type="button">
                                    <x-heroicon-s-pencil class="text-gray-400 w-7 h-7 hover:text-yellow-500"/>
                                </button>
                            </div>
                            <div class="flex-shrink-0 lg:w-[64rem]  p-6 lg:p-6">
                                <header>
                                    <p class="text-orange-500">{{ $index+1 }} - {{ $script->category->name ?? 'Uncategorized' }}</p>
                                    <h3 class="mt-2 text-xl font-semibold text-darkgreen">{{ $script->title }}</h3>
                                </header>
                                <div class="gap-6 lg:grid lg:grid-cols-2">
                                    <div class="p-3 py-4 space-y-3 lg:p-4">
                                        @foreach($settings as $setting)
                                        @php  $var = $setting['key']; @endphp
                                        <div x-data="{ 
                                                blur: {{ $setting['blur'] }}, 
                                                toggle(){
                                                    this.blur = !this.blur;
                                                }
                                            }"
                                            x-on:blur-{{ $setting['key'] }}.window="toggle()"
                                            x-on:blur-all.window="blur = $event.detail.enable;"
                                            class="flex gap-4">
                                            <div class="flex-shrink-0 w-10 text-darkgreen">{{ $setting['value'] }}</div>
                                            <button type="button"
                                                x-on:click="toggle()"
                                                :class="blur ? 'blur-sm'  : ''"
                                                class="text-sm text-gray-600 cursor-pointer">{{ $script->$var }}</button>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="hidden mx-auto lg:block">
                                        @if(count($script->images))
                                        @foreach($script->images as $image)
                                        <img src="{{ $image->url }}" class="max-h-[12rem] overflow-auto" alt="">
                                        @endforeach
                                        @else
                                        <img src="{{ asset('img/question.jpg') }}" class="max-h-[12rem] " alt="">
                                        @endif
                                    </div>
                                </div>
                            </div>
            
                        </div>
                        <div class="md:hidden">
                            <div x-data="{ flip: false }" class="group w-full h-[34rem] [perspective:1000px]">
                                <div
                                    x-on:click="flip = !flip"
                                    :class="flip ? '[transform:rotateY(180deg)]' : ''"
                                    class="relative h-full w-full rounded-xl shadow-xl transition-all duration-500 [transform-style:preserve-3d]">
                                    <div class="absolute inset-0 p-4" id="front">
                                        <header>
                                            <p class="text-orange-500">{{ $script->category->name ?? 'Uncategorized' }}</p>
                                            <h3 class="mt-2 text-xl font-semibold text-darkgreen">{{ $script->title }}</h3>
                                        </header>
                                        <div class="gap-6 lg:grid lg:grid-cols-2">
                                            <div class="p-3 py-4 space-y-3 lg:p-4">
                                                @foreach($settings as $setting)
                                                @php  $var = $setting['key']; @endphp
                                                <div x-data="{ 
                                                        blur: {{ $setting['blur'] }}, 
                                                        toggle(){
                                                            this.blur = !this.blur;
                                                        }
                                                    }"
                                                    x-on:blur-{{ $setting['key'] }}.window="toggle()"
                                                    x-on:blur-all.window="blur = $event.detail.enable;"
                                                    class="flex gap-4">
                                                    <div class="flex-shrink-0 w-10 text-darkgreen">{{ $setting['value'] }}</div>
                                                    <button type="button"
                                                        x-on:click="toggle()"
                                                        :class="blur ? 'blur-sm'  : ''"
                                                        class="text-sm text-gray-600 cursor-pointer">{{ $script->$var }}</button>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-slate-200 absolute inset-0 h-full w-full rounded-xl bg-white px-12 text-center [transform:rotateY(180deg)] [backface-visibility:hidden]"
                                        id="back">
                                        <div class="flex flex-col items-center justify-center h-full">
                                            <div class="my-auto">
                                                @foreach($script->images as $image)
                                                <img src="{{ $image->url }}" class="max-h-[12rem] overflow-auto" alt="">
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    
</div>

@push('scripts')
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>

    window.addEventListener('reboot-slider', event=>{
        $('#slider').slick('unslick');
        slider();
    });

    slider();
    
    function slider(){
        $('#slider').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
          });

        console.log('init slider');
    }
    
</script>
@endpush


