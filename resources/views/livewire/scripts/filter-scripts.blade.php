<div>
    <div class="py-2 border-gray-300">
        <div>
            <div class="flex">
                <x-heroicon-s-filter class="flex-shrink-0 w-6 h-6 text-gray-500"/>
                <div class="ml-2">
                    <h3 class="text-lg text-darkgreen">Filter Scripts</h3>
                </div>
            </div>
            <p class="text-sm text-gray-700">View scripts according to your liking.</p>
            
        </div>

    </div>

    <div class="pt-4 mt-0 space-y-3">
  
        <div>
            <select wire:model="category_id" class="w-full text-sm text-gray-600 border border-transparent cursor-pointer hover:bg-gray-100">
                <option value="">Select Category</option>
                @foreach($categories as $categoryItem)
                <option value="{{ $categoryItem->id }}">{{ $categoryItem->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select wire:model="script_id" class="w-full text-sm text-gray-600 border border-transparent cursor-pointer hover:bg-gray-100">
                <option value="">Select Script </option>
                @foreach($scripts as $scriptItem)
                @if($category_id)
                    @if($category_id == $scriptItem->category_id)
                    <option value="{{ $scriptItem->id }}">{{ $scriptItem->title }}</option>
                    @endif
                @else
                <option value="{{ $scriptItem->id }}">{{ $scriptItem->title }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
      
</div>