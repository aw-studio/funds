<div>
    <h2 class="text-2xl font-semibold">{{ __('Contact Details') }}</h2>
    <x-input
        name="name"
        type="text"
        placeholder="{{ __('Name') }}"
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
