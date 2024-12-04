  <x-public::donation-card href="{{ route('public.checkout', ['campaign' => $campaign]) }}">
      <div class="flex gap-2 mb-2">
          <p class="title text-lg">
              {{ __('Simple Donation') }}
          </p>
      </div>
      <x-input
          type="text"
          name="amount"
          value="5 €"
          disabled
          class="pointer-events-none mb-3"
      />
      <p class="description mb-3 text-muted">
          {{ __('Support us with a donation of any amount for nothing in return!') }}
      </p>
      <div class="text-right">
          <span class="button-link underline underline-offset-8 decoration-1">
              {{ __('Donate an amount') }}
          </span>
      </div>
  </x-public::donation-card>
