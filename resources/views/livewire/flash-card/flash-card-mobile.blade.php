<div class="bg-gray-100">

    <header class="flex items-center justify-between px-6 py-6 lg:px-16 lg:py-6">
        <h1 class="text-2xl font-bold leading-7 lg:text-4xl text-darkgreen sm:leading-9">Flash Cards</h1>
        <div>
            <button type="button" class="btn-primary">Create</button>
        </div>
    </header>

    <div class="px-6">
        @foreach($flash_cards as $card)
        <a href="{{ route('flashcard.play', $card->id) }}" wire:key="card-{{ $card->id }}" class="relative block p-5 bg-white border border-gray-300 rounded-md">
            <h4 class="text-xl font-bold text-orange-600">{{ $card->getCategoriesName() }}</h4>

            <div class="flex gap-2 mt-2 text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                  </svg>
                <span>{{ $card->items_count }} cards</span>
                  
            </div>

            <div class="absolute top-0 bottom-0 right-0 pr-7">
                <div class="flex flex-col items-center w-full h-full">
                    <x-heroicon-o-chevron-right class="flex-1 w-10 h-10 text-gray-300"/>
                </div>
                
            </div>
        </a>
        @endforeach
    </div>
    
    
</div>

