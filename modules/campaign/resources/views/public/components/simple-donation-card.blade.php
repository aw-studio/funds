  <x-public::donation-card href="{{ route('public.checkout', ['campaign' => $campaign]) }}">
      <div class="flex flex-wrap gap-2 mb-3">
          <div class="self-start p-1 px-2 text-sm tag">
              {{ __('Simple Donation') }}
          </div>
      </div>
      <x-input
          type="text"
          name="amount"
          value="5 €"
          disabled
          class="mb-3 pointer-events-none"
      />
      <p class="flex-1 mb-3 description text-muted">
          {{ __('Support us with a donation of any amount for nothing in return!') }}
      </p>
      <div class="text-right ">
          <span class="underline button-link underline-offset-8 decoration-1">
              {{ __('Donate an amount') }}
          </span>
      </div>
  </x-public::donation-card>
