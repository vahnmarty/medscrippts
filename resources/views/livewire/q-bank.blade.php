<div class="min-h-screen py-4 bg-gray-100 h-100">

    <button type="button" 
        wire:click="exit"
        class="fixed z-50 p-2 text-gray-900 duration-300 ease-in-out bg-gray-300 rounded-full top-3 right-10 hover:bg-red-500 hover:text-white">
        <x-heroicon-s-x class="w-4 h-4 "/>
    </button>

    <div class="px-8 pb-32 mx-auto max-w-7xl">
        <div class="mt-16">
            <div>
                <section class="max-w-3xl px-4 mx-auto">

                    @foreach($results as $result)
                    <div wire:key="quiz-{{ $loop->index }}">
                        @if($index == $loop->index)
                        <div x-data="{ flip: false }" 
                            class="group w-full h-[16rem] [perspective:1000px] ">
                            <div
                                x-on:click="flip = !flip; $dispatch('next')"
                                :class="flip ? '[transform:rotateY(180deg)]' : ''"
                                class="relative bg-white h-full w-full rounded-xl shadow-xl transition-all duration-500 [transform-style:preserve-3d]">
                                <div class="absolute inset-0 p-4">
                                    <div class="flex flex-col items-center justify-center w-full h-full">
                                        <h1 class="text-3xl font-bold">{{ $result['question'] }}</h1>
                                    </div>
                                </div>
                                <div class="text-slate-200 absolute inset-0 h-full w-full rounded-xl bg-white px-12 text-center [transform:rotateY(180deg)] [backface-visibility:hidden]">
                                    <div class="flex flex-col items-center justify-center w-full h-full">
                                        <p class="text-xl text-orange-400">{{ $result['answer'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </section>
            </div>
        </div>
    </div>
    <footer class="fixed bottom-0 left-0 right-0 z-20 py-6 bg-white border-t">
        <div class="max-w-4xl px-6 mx-auto">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-darkgreen">QBank</h3>
                <div x-data="{ open: false }"
                    x-on:next.window="open = true">
                    <button x-show="open" x-on:click="open = false" wire:click="next" type="button" class="btn-primary">Next</button>
                </div>
            </div>
        </div>
    </footer>
</div>