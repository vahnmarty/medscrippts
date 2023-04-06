

<div>
    <div>
        <div x-data="{ flip: false }" class="group h-96 w-80 [perspective:1000px]">
            <div
                x-on:click="flip = !flip"
                :class="flip ? '[transform:rotateY(180deg)]' : ''"
                class="relative h-full w-full rounded-xl shadow-xl transition-all duration-500 [transform-style:preserve-3d]">
                <div class="absolute inset-0" id="front">
                    <div class="p-4 bg-white">
                        <h4>category</h4>
                        <h3>title</h3>
                        <p>description</p>
                    </div>
                </div>
                <div class="text-slate-200 absolute inset-0 h-full w-full rounded-xl bg-white px-12 text-center [transform:rotateY(180deg)] [backface-visibility:hidden]"
                    id="back">
                    <div>
                        <img src="{{ asset('img/logo.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
