<div>
    <div class="px-4 py-6 bg-gray-100 lg:py-12 lg:px-16">
        <section class="hidden lg:block">
            
        </section>

        <section class="lg:hidden">
            <div class="flex justify-between">
                <a href="{{ url('dashboard') }}">
                    <x-heroicon-s-chevron-left class="w-6 h-6"/>
                </a>
                <div>
                    <h1>{{ $category->name }}</h1>
                </div>
                <div></div>
            </div>

            <div class="mt-8">
                <div class="flex justify-between p-4 bg-white rounded-md">
                    <p class="text-gray-700">Sort by</p>
                    <div>
                        <p>Most Recent</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 space-y-4">
                @foreach($category->scripts as $script)
                <div class="p-4 bg-white rounded-md">
                    <p class="text-blue-500">{{ $category->name }}</p>
                    <h3 class="mt-2">{{ $script->title }}</h3>
                </div>
                @endforeach
            </div>
        </section>
    </div>
    
</div>