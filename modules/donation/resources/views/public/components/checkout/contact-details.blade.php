<div class="contactDetails mb-8">
    <h2 class="checkout-section-header text-2xl">{{ __('Contact Details') }}</h2>
    <div class="grid grid-cols-2 gap-2">
        <x-input
            name="name"
            type="text"
            label="{{ __('Full name') }}"
            placeholder="{{ __('Full name') }}"
            value="{{ old('name') }}"
            required
        />

        <x-input
            name="email"
            type="text"
            label="{{ __('Email address') }}"
            placeholder="{{ __('Email') }}"
            value="{{ old('email') }}"
            required
        />
    </div>

</div>
