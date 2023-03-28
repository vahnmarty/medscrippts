@extends('layouts.app')

@section('content')
<div>
    <div class="px-4 py-12 bg-gray-100 lg:px-16">
        <section class="hidden lg:block">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach($scripts as $index => $script)
                    <div class="swiper-slide">
                        <div  id="script{{ $index }}">
                            <div class="flex-shrink-0 lg:w-[64rem] bg-white border rounded-md lg:p-6">
                                <header>
                                    <p class="text-orange-500">{{ $script->category->name ?? 'Uncategorized' }}</p>
                                    <h3 class="mt-2 text-xl font-semibold text-darkgreen">{{ $script->id }} {{ $script->title }}</h3>
                                </header>
                                <div class="gap-6 lg:grid lg:grid-cols-2">
                                    <div class="p-3 py-4 space-y-3 lg:p-4">
                                        <div class="flex gap-4">
                                            <div class="flex-shrink-0 w-10 text-darkgreen">Path</div>
                                            <p class="text-sm text-gray-600">{{ $script->pathophysiology }}</p>
                                        </div>
                                        <div class="flex gap-4">
                                            <div class="flex-shrink-0 w-10 text-darkgreen">Epi</div>
                                            <p class="text-sm text-gray-600">{{ $script->epidemiology }}</p>
                                        </div>
                                        <div class="flex gap-4">
                                            <div class="flex-shrink-0 w-10 text-darkgreen">S/S</div>
                                            <p class="text-sm text-gray-600">{{ $script->signs }}</p>
                                        </div>
                                        <div class="flex gap-4">
                                            <div class="flex-shrink-0 w-10 text-darkgreen">Dx</div>
                                            <p class="text-sm text-gray-600">{{ $script->diagnostics }}</p>
                                        </div>
                                        <div class="flex gap-4">
                                            <div class="flex-shrink-0 w-10 text-darkgreen">Tx</div>
                                            <p class="text-sm text-gray-600">{{ $script->treatments }}</p>
                                        </div>
                                    </div>
                                    <div class="hidden mx-auto lg:block">
                                        @foreach($script->images as $image)
                                        <img src="{{ $image->url }}" class="max-h-[12rem] overflow-auto" alt="">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
            
                            <div class="flex overflow-auto lg:gap-16 flex-nowrap" x-data="{ dragging: false, scrollLeft: 0 }" x-ref="container" @mousedown="dragging = true; startX = event.clientX; scrollLeft = $refs.container.scrollLeft" @mousemove.window="if (dragging) { $refs.container.scrollLeft = scrollLeft - (event.clientX - startX); }" @mouseup="dragging = false">
                                ...
                            </div>
                              
            
                            <div class="flex justify-center mt-8 lg:px-8">
                                <div class="flex justify-between gap-8 ">
                                    <div class="flex px-6 py-4 space-x-8 bg-white rounded-md ">
                                        <div class="inline-flex items-end">
                                            <h3 class="mr-3 text-xl font-bold text-gray-900">238</h3>
                                            <p class="text-sm text-gray-600">Views</p>
                                        </div>
                                        <div class="inline-flex items-end">
                                            <h3 class="mr-3 text-xl font-bold text-gray-900">{{ $script->updated_at->format('Y-m-d') }}</h3>
                                            <p class="text-sm text-gray-600">Last updated</p>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" x-on:click="scrollTo('#script{{ $index-1 }}')" class="p-3 bg-white rounded-full shadow-lg">
                                            <x-heroicon-s-chevron-left class="text-gray-900 w-7 h-7"/>
                                        </button>
                                        <button type="button" x-on:click="scrollTo('#script{{ $index+1 }}')" class="p-3 bg-white rounded-full shadow-lg">
                                            <x-heroicon-s-chevron-right class="text-gray-900 w-7 h-7"/>
                                        </button>
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

        <section class="lg:hidden">
            <div class="p-3 bg-white border rounded-md">
                <h3>Continue Studying</h3>

                <div class="mt-8 swiper mobileSwiper">
                    <div class="mb-16 swiper-wrapper">
                        @foreach($scripts as $script)
                        <div class="px-2 py-3 rounded-md shadow-md swiper-slide">
                            <div class="flex flex-col justify-between h-full">
                                <p class="text-gray-900">{{ $script->title }}</p>
                                <p class="text-xs text-gray-700 ">{{ $script->category?->name }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                
            </div>

            <section class="mt-8">
                <h3>Categories</h3>


                <div class="space-y-4">
                    @foreach($categories as $category)
                    <div class="p-3 mt-4 bg-white border rounded-md">
                        <div class="flex items-center gap-4">
                            @if(null)
                            <img src="{{ $category->image_url }}" class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-md" alt="">
                            @endif
                            <x-heroicon-s-lightning-bolt class="w-8 h-8 text-gray-900"/>
                            <div>
                                <h4>{{ $category->name }}</h4>
                                <p class="mt-1 text-xs text-gray-600">{{ $category->scripts_count }} cards</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

        </section>
    </div>
    
</div>
@endsection

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


