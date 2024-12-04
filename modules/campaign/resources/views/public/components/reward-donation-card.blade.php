 <x-public::donation-card
     :href="route('public.checkout', ['campaign' => $campaign, 'reward' => $reward])"
     :disabled="!$reward->isAvailable()"
     {{ $attributes }}
 >
     @if ($image = $reward->getFirstMedia('image'))
         <div class="w-full mb-3">
             {{ $image }}
         </div>
     @endif
     <div class="flex gap-2 mb-3">
         <div class="tag self-start text-sm p-1 px-2">
             {{ $reward->min_amount }}
         </div>
         @if ($reward->expected_delivery)
             <div class="tag self-start text-sm p-1 px-2">
                 {{ $reward->expected_delivery }}
             </div>
         @endif
     </div>
     <p class="title text-lg mb-3">
         {{ $reward->name }}
     </p>
     <p class="description mb-3">
         {{ $reward->description }}
     </p>
     <div class="text-right">
         <span class="button-link underline underline-offset-8 decoration-1">
             {{ __('Select and Continue') }}
         </span>
     </div>
 </x-public::donation-card>
