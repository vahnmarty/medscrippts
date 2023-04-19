<div class="min-h-screen py-4 bg-gray-100 h-100">

    <button type="button" 
        wire:click="exit"
        class="fixed z-50 p-2 text-gray-900 duration-300 ease-in-out bg-gray-300 rounded-full top-3 right-10 hover:bg-red-500 hover:text-white">
        <x-heroicon-s-x class="w-4 h-4 "/>
    </button>

    <div class="px-8 pb-32 mx-auto max-w-7xl">
        <div class="mt-16">
            <div>

                <section x-data="{ end: $wire.entangle('end') }" x-show="end"
                    class="max-w-xl px-4 mx-auto">
                    <div class="flex justify-center">
                        <x-heroicon-s-puzzle class="w-16 h-16 text-gray-400"/>
                    </div>
                    <h3 class="mt-3 text-2xl font-bold text-center text-darkgreen">Your Score</h3>

                    <div class="p-6 mt-6 space-y-5 bg-white border rounded-md">
                        <h1 class="text-5xl font-bold text-center text-gray-900">{{ $this->score }} / {{ count($results) }}</h1>

                        <div class="flex justify-center mt-3">
                            @if($passed)
                            <span class="text-xs px-6 py-0.5 bg-green-200 border border-green-300 rounded-lg text-green-600">Passed</span>
                            @else
                            <span class="text-xs px-6 py-0.5 bg-red-200 border border-red-300 rounded-lg text-red-600">Failed</span>
                            @endif
                        </div>
                    </div>
                </section>

                <section x-data="{ end: $wire.entangle('end') }" x-show="!end" class="max-w-xl px-4 mx-auto">
                    @foreach($results as $q => $result)
                    <div wire:key="quiz-{{ $loop->index }}">
                        @if($index == $loop->index)
                        <div>
                            <h3 class="text-xl font-bold text-darkgreen">{{ $result['question'] }}</h3>

                            <div class="mt-8 space-y-2">
                                @foreach(range(1,4) as $i)
                                <div wire:key="q{{ $q}}-option-{{ $i }}" >
                                    @if($result['selected_option'])
                                    @if($result['selected_option'] == 'option' . $i && $result['option_answer'] == 'option' . $i)
                                    <div class="flex justify-between w-full p-6 text-left bg-green-200 border border-green-300 rounded-sm ">
                                        <span>{{ $result['option' . $i] }}</span>
                                        <x-heroicon-s-check-circle class="w-5 h-5 text-green-500"/>
                                    </div>
                                    @elseif($result['selected_option'] == 'option' . $i && $result['option_answer'] != 'option' . $i)
                                    <div class="flex justify-between w-full p-6 text-left bg-red-200 border border-red-300 rounded-sm ">
                                        <span>{{ $result['option' . $i] }}</span>
                                        <x-heroicon-s-check-circle class="w-5 h-5 text-red-500"/>
                                    </div>
                                    @elseif($result['option_answer'] == 'option' . $i && !$result['is_correct'])
                                    <div class="flex justify-between w-full p-6 text-left bg-green-200 border border-green-300 rounded-sm ">
                                        <span>{{ $result['option' . $i] }}</span>
                                        <x-heroicon-s-check-circle class="w-5 h-5 text-green-500"/>
                                    </div>
                                    @else
                                    <div class="flex justify-between w-full p-6 text-left bg-white border border-gray-200 rounded-sm ">
                                        <span>{{ $result['option' . $i] }}</span>
                                    </div>
                                    @endif
                                    @else
                                    <button type="button" 
                                        wire:click="selectAnswer({{ $q }}, `{{ 'option' . $i}}` )"
                                        class="flex justify-between w-full p-6 text-left bg-white border rounded-sm hover:bg-gray-200 ">
                                        <span class="flex-1 text-gray-700">{{ $result['option' . $i] }}</span>
                                        <div class="w-5"></div>
                                    </button>
                                    @endif
                                </div>
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

                <div class="h-12">
                    @if($end)
                    <button  wire:click="retake" type="button" class="btn-primary">Retake</button>
                    @endif

                    @if($has_answered)
                    <div> 
                        <button  wire:click="next" type="button" class="btn-primary">Next</button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </footer>
</div>