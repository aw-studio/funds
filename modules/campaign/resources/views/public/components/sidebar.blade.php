@props(['donation_options' => [], 'campaign' => null])
<div class="col-span-1 -mt-8 overflow-hidden bg-gray-100 md:col-span-4 md:bg-inherit md:mt-0">
    <div class= "py-8 lg:p-8 sidebar md:!px-0">
        <div class="container mb-4 text-2xl md:mx-0 md:px-0">
            {{ __('Choose your reward') }}
        </div>
        <div class="flex flex-col gap-5 lg:flex-row lg:gap-8">
            <div class="flex flex-col gap-5 scrollbar-hide carousel-container">
                <div class="flex carousel md:flex-col md:space-y-5 ">
                    <div class="pl-4 md:px-0">
                        <x-public::simple-donation-card :$campaign />
                    </div>
                    @foreach ($donation_options as $reward)
                        <div class="pl-4 md:px-0 @if ($loop->last) {{ 'pr-4' }} @endif">
                            <x-public::reward-donation-card
                                :reward="$reward"
                                :campaign="$campaign"
                            />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* max width 767px */
    @media (max-width: 767px) {
        .carousel-container {
            overflow-x: auto;
            scroll-snap-type: x mandatory;
        }

        .carousel-container>.carousel>* {
            scroll-snap-align: start;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .carousel>div>a {
            width: 80vw !important;
            max-width: 300px;
        }

        .carousel>div>a {
            height: 100%;
        }
    }
</style>
