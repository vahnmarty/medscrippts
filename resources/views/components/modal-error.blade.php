@if($errors->any())
<div x-data="{ isOpen: true }" 
    x-show="isOpen"
    class="relative z-30 modal"
    id="ModalErrors"
    aria-labelledby="modal-title" role="dialog" aria-modal="true">

<div x-show="isOpen" 
    x-transition:enter="ease-out duration-300" 
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" 
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100" 
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex items-center justify-center w-full min-h-full p-4 text-center lg:items-center sm:items-center sm:p-0">

            <div x-show="isOpen" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative flex-1 px-8 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-3xl sm:p-6">

                <div class="absolute right-5">
                    <button x-on:click="isOpen = false" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd"
                                d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                                clip-rule="evenodd" />
                        </svg>

                    </button>
                </div>

                <div class="px-2 lg:px-12">
                    <div {{ $attributes }}>
                        <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

                            <ul class="mt-3 text-sm text-red-600 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                </div>
                
            </div>
        </div>
    </div>
</div>
@endif