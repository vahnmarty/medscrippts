
<div>
    <div class="px-4 py-12 bg-gray-100 lg:px-16">

        <section>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach($scripts as $index => $script)
                    <div wire:key="script-{{ $index }}" 
                        class="relative bg-white swiper-slide">
                        <div class="hidden md:block">
                            <div class="absolute top-5 right-5">
                                <button type="button">
                                    <x-heroicon-s-pencil class="text-gray-400 w-7 h-7 hover:text-yellow-500"/>
                                </button>
                            </div>
                            <div class="flex-shrink-0 lg:w-[64rem]  p-6 lg:p-6">
                                <header>
                                    <p class="text-orange-500">{{ $script->category->name ?? 'Uncategorized' }}</p>
                                    <h3 class="mt-2 text-xl font-semibold text-darkgreen">{{ $script->title }}</h3>
                                </header>
                                <div class="gap-6 lg:grid lg:grid-cols-2">
                                    <div class="p-3 py-4 space-y-3 lg:p-4">
                                        @foreach($settings as $setting)
                                        @php  $var = $setting['key']; @endphp
                                        <div class="flex gap-4">
                                            <div class="flex-shrink-0 w-10 text-darkgreen">{{ $setting['value'] }}</div>
                                            <button wire:click="blur(`{{ $setting['key'] }}`)" class="cursor-pointer text-sm text-gray-600 {{ $setting['blur'] ? 'blur-sm' : '' }}">{{ $script->$var }}</button>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="hidden mx-auto lg:block">
                                        @foreach($script->images as $image)
                                        <img src="{{ $image->url }}" class="max-h-[12rem] overflow-auto" alt="">
                                        @endforeach
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
                                                <div class="flex gap-4">
                                                    <div class="flex-shrink-0 w-10 text-darkgreen">Path {{ session('study-Pathophysiology') }}</div>
                                                    <p class="text-sm text-gray-600 {{ session('study.Path') == false ? 'blur-sm' : '' }}">{{ $script->pathophysiology }}</p>
                                                </div>
                                                <div class="flex gap-4">
                                                    <div class="flex-shrink-0 w-10 text-darkgreen">Epi</div>
                                                    <p class="text-sm text-gray-600 {{ session('study.Epi')  == false ? 'blur-sm' : '' }}">{{ $script->epidemiology }}</p>
                                                </div>
                                                <div class="flex gap-4">
                                                    <div class="flex-shrink-0 w-10 text-darkgreen">S/S</div>
                                                    <p class="text-sm text-gray-600 {{ session('study.SS')  == false ? 'blur-sm' : '' }}">{{ $script->signs }}</p>
                                                </div>
                                                <div class="flex gap-4">
                                                    <div class="flex-shrink-0 w-10 text-darkgreen">Dx</div>
                                                    <p class="text-sm text-gray-600 {{ session('study.Dx')  == false ? 'blur-sm' : '' }}">{{ $script->diagnostics }}</p>
                                                </div>
                                                <div class="flex gap-4">
                                                    <div class="flex-shrink-0 w-10 text-darkgreen">Tx</div>
                                                    <p class="text-sm text-gray-600 {{ session('study.Tx')  == false ? 'blur-sm' : '' }}">{{ $script->treatments }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-slate-200 absolute inset-0 h-full w-full rounded-xl bg-white px-12 text-center [transform:rotateY(180deg)] [backface-visibility:hidden]"
                                        id="back">
                                        <div>
                                            <div class="">
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
                <div class="swiper-pagination"></div>
            </div>
        </section>
    </div>
    
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

@if(true)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: "auto",
            pagination: {
              el: ".swiper-pagination",
            },
            mousewheel: {
                forceToAxis: true,
                sensitivity: 1,
            },
          });

        var mobileSwiper = new Swiper(".mobileSwiper", {
            slidesPerView: 2,
            pagination: {
              el: ".swiper-pagination",
            },
          });
    });
    
  </script>
@endif
@endpush


