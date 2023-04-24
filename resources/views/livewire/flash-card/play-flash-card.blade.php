<div class="min-h-screen py-4 bg-gray-100 h-100">

    <button type="button" 
        wire:click="exit"
        class="fixed z-50 p-2 text-gray-900 duration-300 ease-in-out bg-gray-300 rounded-full top-3 right-10 hover:bg-red-500 hover:text-white">
        <x-heroicon-s-x class="w-4 h-4 "/>
    </button>

    <div class="px-8 pb-32 mx-auto max-w-7xl">
        <div class="mt-16">
            <div>

                @if($end)

                <section class="max-w-3xl px-4 mx-auto">
                    <div class="flex justify-center">
                        <x-heroicon-s-puzzle class="w-16 h-16 text-gray-400"/>

                        
                    </div>
                    <div class="p-6 mx-auto mt-3 bg-white border rounded-md">
                        <div class="grid items-center grid-cols-2 gap-10">
                            <div class="flex justify-end gap-2">
                                <x-heroicon-s-check-circle class="w-6 h-6 text-green-500"/>
                                <span>Completed</span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">{{ count($results) }} Flash Cards</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="mt-3 font-bold text-darkgreen">Summary</h3>

                    <div class="p-6 mt-6 space-y-5 bg-white border rounded-md">
                        @foreach($results as $item)
                        <div>
                            <p>Q: {{ $item['question'] }}</p>
                            <div class="text-sm text-orange-500">{{ $item['answer'] }}</div>
                        </div>
                        @endforeach
                    </div>
                </section>

                @else
                <section class="max-w-3xl px-4 mx-auto">

                    @foreach($results as $result)
                    <div wire:key="quiz-{{ $loop->index }}">
                        @if($index == $loop->index)
                        <div x-data="{ flip: false }" 
                            class="group w-full h-[20rem] [perspective:1000px] ">
                            <div
                                x-on:click="flip = !flip; $dispatch('next')"
                                :class="flip ? '[transform:rotateY(180deg)]' : ''"
                                class="relative bg-white h-full w-full rounded-xl shadow-xl transition-all duration-500 [transform-style:preserve-3d]">
                                <div class="absolute inset-0 p-4">
                                    <div class="flex flex-col items-center justify-center w-full h-full">
                                        <h1 class="text-3xl font-bold text-center">{{ $result['question'] }}</h1>
                                    </div>
                                </div>
                                <div class="text-slate-200 absolute inset-0 h-full w-full rounded-xl bg-white px-12 [transform:rotateY(180deg)] [backface-visibility:hidden]">
                                    <div class="relative">

                                        <div class="absolute top-0 left-0 right-0">
                                            <h3 class="mt-8 text-xl font-bold text-center">{{ $result['question'] }}</h3>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center justify-center w-full h-full text-center">

                                        <p class="mt-16 text-2xl text-orange-400">{{ $result['answer'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-center">
                            {{ $index+1 }}/{{ count($results )}}
                        </div>
                        @endif
                    </div>
                    @endforeach
                </section>
                @endif
            </div>
        </div>
    </div>
    <footer class="fixed bottom-0 left-0 right-0 z-20 py-6 bg-white border-t">
        <div class="max-w-4xl px-6 mx-auto">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-darkgreen">Flash Card</h3>

                <div class="h-16">
                    @if($end)
                <button  wire:click="retake" type="button" class="btn-primary">Retake</button>
                @else
                <div x-data="{ open: false }"
                    x-on:next.window="open = true">
                    <button x-show="open" x-on:click="open = false" wire:click="next" type="button" class="btn-primary">Next</button>
                </div>
                @endif
                </div>
            </div>
        </div>
    </footer>
</div>