 <div x-data="{ dateValue: @js($attributes->get('value', '')) }">
     <x-input
         {{ $attributes->merge(['type' => 'date']) }}
         x-model="dateValue"
         x-bind:style="{ color: dateValue ? 'black' : 'grey' }"
     />
 </div>
