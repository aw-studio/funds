<h2>FAQ</h2>

<div
    x-data="{}"
    class="space-y-3"
>
    @foreach ($faqs as $faq)
        <div
            x-data="{ open: false }"
            @click="open = !open"
            class="relative p-3 bg-gray-100 rounded-md faq-item group hover:bg-gray-200"
        >
            <div class="flex items-center justify-between text-lg font-semibold cursor-pointer">
                <h3 class="!m-0 flex-1">{{ $faq->question }}</h3>
                <div class="absolute flex items-center justify-center w-8 h-8 right-2 top-3.5 ">

                    <svg
                        :class="{ 'rotate-180': open }"
                        class="w-5 h-5 transition-transform transform"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="lucide lucide-chevron-down"
                    >
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </div>
            </div>

            <div
                x-show="open"
                x-collapse
                class="overflow-hidden text-gray-700 "
            >
                <p>{{ $faq->answer }}</p>
            </div>
        </div>
    @endforeach
</div>
