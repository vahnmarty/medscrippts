
<div>
    <div class="px-4 py-12 bg-gray-100 lg:px-16">
        <section class="">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach($scripts as $index => $script)
                    <div class="bg-white swiper-slide">
                        <div  id="script{{ $index }}">
                            <div class="flex-shrink-0 lg:w-[64rem]  p-6 lg:p-6">
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
                                    <div class="hidden mx-auto lg:block">
                                        @foreach($script->images as $image)
                                        <img src="{{ $image->url }}" class="max-h-[12rem] overflow-auto" alt="">
                                        @endforeach
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
@endpush


