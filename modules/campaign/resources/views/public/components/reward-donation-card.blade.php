 <x-public::donation-card
     :href="route('public.checkout', ['campaign' => $campaign, 'reward' => $reward])"
     :disabled="!$reward->isAvailable()"
     {{ $attributes }}
 >
     @if (($image = $reward->getFirstMedia('image')) && $reward->show_image_in_overview)
         <div class="w-full mb-3">
             {{ $image }}
         </div>
     @endif
     <div class="flex flex-wrap gap-2 mb-3">
         <div class="self-start p-1 px-2 text-sm tag">
             {{ $reward->min_amount }}
         </div>
         @if ($reward->expected_delivery)
             <div class="self-start p-1 px-2 text-sm tag">
                 {{ $reward->expected_delivery }}
             </div>
         @endif
     </div>
     <p class="mb-3 text-lg title">
         {{ $reward->name }}
     </p>
     <p class="flex-1 mb-3 description">
         {{ $reward->description }}
     </p>
     <div class="text-right ">
         <span class="underline button-link underline-offset-8 decoration-1">
             {{ __('Select and Continue') }}
         </span>
     </div>
 </x-public::donation-card>
