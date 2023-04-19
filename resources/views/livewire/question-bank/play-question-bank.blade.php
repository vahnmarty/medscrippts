<div class="min-h-screen py-4 bg-gray-100 h-100">

    <button type="button" 
        wire:click="exit"
        class="fixed z-50 p-2 text-gray-900 duration-300 ease-in-out bg-gray-300 rounded-full top-3 right-10 hover:bg-red-500 hover:text-white">
        <x-heroicon-s-x class="w-4 h-4 "/>
    </button>

    <div class="px-8 pb-32 mx-auto max-w-7xl">
        <div class="mt-16">
            <div>


                

                <section class="max-w-xl px-4 mx-auto">

                    @foreach($results as $q => $result)
                    <div wire:key="quiz-{{ $loop->index }}">
                        @if($index == $loop->index)
                        <div>
                            <h3 class="text-xl font-bold text-darkgreen">{{ $result['question'] }}</h3>

                            <div class="mt-8 space-y-2">
                                @foreach(range(1,4) as $i)
                                <button wire:key="q{{ $q}}-option-{{ $i }}" 
                                    type="button" 
                                    wire:click="selectAnswer({{ $q }}, `{{ 'option' . $i}}` )"
                                    class="flex justify-between w-full p-6 text-left bg-white border border-gray-300 rounded-sm hover:bg-green-100">
                                    <span class="flex-1 text-gray-700">{{ $result['option' . $i] }}</span>
                                    @if($result['selected_option'])
                                    <div>
                                        @if($result['is_correct'])
                                        <x-heroicon-s-check-circle class="w-5 h-5 text-green-600"/>
                                        @else
                                        <x-heroicon-s-x-circle class="w-5 h-5 text-red-600"/>
                                        @endif
                                    </div>
                                    @endif
                                </button>
                                @endforeach
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

                @if($end)
                <button  wire:click="retake" type="button" class="btn-primary">Retake</button>
                @else
                <div x-data="{ open: false }"
                    x-on:next.window="open = true">
                    <button :class="open ? 'visible' : 'invisible'" x-on:click="open = false" wire:click="next" type="button" class="btn-primary">Next</button>
                </div>
                @endif
            </div>
        </div>
    </footer>
</div>