<div>
    <h2 class="text-2xl font-semibold">{{ __('Contact Details') }}</h2>
    <div class="grid grid-cols-2 gap-2">
        <x-input
            name="name"
            type="text"
            placeholder="{{ __('Full name') }}"
            value="{{ old('name') ?? fake()->name }}"
            required
        />

        <x-input
            name="email"
            type="text"
            placeholder="{{ __('Email') }}"
            value="{{ old('email') ?? fake()->email }}"
            required
        />
    </div>

</div>
