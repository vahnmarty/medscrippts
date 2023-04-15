
<div>

    @foreach($scripts as $index => $script)
    <div wire:key="modal-{{ $index }}">
        <x-modal-xl ref="edit-{{ $index }}">
            @livewire('scripts.edit-script', ['id' => $script->id ])
        </x-modal-xl>
    </div>
    @endforeach
        
    <div class="px-8 py-12 bg-gray-100 lg:px-16">
        

        @if(count($scripts))
        <section>
            <div x-data="{ }">
                <div id="slider">
                    @foreach($scripts as $index => $script)
                    <div wire:key="script-{{ $index }}" 
                            x-data="{ open: false }"
                            class="relative bg-white">
                            
                        <div class="hidden md:block">
                            <div class="absolute top-5 right-5">
                                <button x-on:click="$dispatch('openmodal-edit-{{ $index }}')" type="button" aria-label="Edit Script">
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
                                        <div class="py-8">
                                            <header class="text-left">
                                                <p class="text-orange-500">{{ $script->category->name ?? 'Uncategorized' }}</p>
                                                <h3 class="mt-2 text-xl font-semibold text-darkgreen">{{ $script->title }}</h3>
                                            </header>
                                            <div class="flex flex-col items-center justify-center h-full gap-8 mt-8 space-x-8">
                                                <div>
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
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @else
        <section class="py-16 bg-gray-200">
            <div class="text-center">
                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No scripts</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new scripts.</p>
                <div class="mt-6">
                  <button type="button" class="inline-flex items-center px-3 py-2 text-sm text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Create Script
                  </button>
                  <button type="button" class="inline-flex items-center px-3 py-2 ml-6 text-sm text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Import  Scripts
                  </button>
                </div>
              </div>
              
        </section>
        @endif
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


