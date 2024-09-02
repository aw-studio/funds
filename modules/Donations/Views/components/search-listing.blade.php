<div
    class="flex justify-between"
    x-data="{ showSearch: false, search: '' }"
>
    <div class="relative">
        <input
            wire:model.live.debounce.250ms="search"
            x-model="search"
            class="mt-1 rounded-full border-gray-200 sm:text-s w-10 transition-all"
            :class="{ 'pl-8 w-48': showSearch }"
            x-on:focus="showSearch = true"
            x-on:blur="showSearch = (search === '') ? false : true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 w-0"
            x-transition:enter-end="opacity-100 w-48"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 w-48"
            x-transition:leave-end="opacity-0 w-0"
        />
        <span
            class="absolute pointer-events-none cursor-pointer inset-y-0 start-0 grid w-10 place-content-center text-gray-500 mt-1"
        >
            <x-icons.search />
        </span>
    </div>
</div>
