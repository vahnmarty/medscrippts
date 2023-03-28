@extends('layouts.app')

@section('content')
<div>
    <div class="px-8 py-12 bg-gray-100 lg:px-16">
        <div x-data="{ 
                scrollTo(hash){
                    const container = document.getElementById('container');
                    const target = document.querySelector(hash);
                    container.scrollTo({
                        left: target.offsetLeft - container.offsetLeft,
                        behavior: 'smooth'
                      });
                } 
            }" 
            id="container" 
            class="flex overflow-auto lg:gap-16 flex-nowrap">
			
            @foreach($scripts as $index => $script)
            
            <div  id="script{{ $index }}">
                <div class="flex-shrink-0 lg:w-[64rem] bg-white border rounded-md lg:p-6">
                    <header>
                        <p class="text-orange-500">{{ $script->category->name ?? 'Uncategorized' }}</p>
                        <h3 class="mt-2 text-xl font-semibold text-darkgreen">{{ $script->id }} {{ $script->title }}</h3>
                    </header>
                    <div class="block lg:hidden">
                        <div class="group h-96 w-80 [perspective:1000px]">
                            <div class="relative h-full w-full rounded-xl shadow-xl transition-all duration-500 [transform-style:preserve-3d] group-hover:[transform:rotateY(180deg)]">
                              <div class="absolute inset-0">
                                <img class="object-cover w-full h-full shadow-xl rounded-xl shadow-black/40" src="https://images.unsplash.com/photo-1562583489-bf23ec64651d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80')" alt="" />
                              </div>
                              <div class="absolute inset-0 h-full w-full rounded-xl bg-black/80 px-12 text-center text-slate-200 [transform:rotateY(180deg)] [backface-visibility:hidden]">
                                <div class="flex flex-col items-center justify-center min-h-full">
                                  <h1 class="text-3xl font-bold">Jane Doe</h1>
                                  <p class="text-lg">Photographer & Art</p>
                                  <p class="text-base">Lorem ipsum dolor sit amet consectetur adipisicing.</p>
                                  <button class="px-2 py-1 mt-2 text-sm rounded-md bg-neutral-800 hover:bg-neutral-900">Read More</button>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                    <div class="hidden gap-6 lg:grid lg:grid-cols-2">
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
            
            @endforeach
        </div>

        
    </div>
    
</div>
@endsection


