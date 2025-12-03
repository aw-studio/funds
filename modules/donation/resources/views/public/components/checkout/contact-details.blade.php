<div class="mb-16 contactDetails">
    <x-public::checkout.section-headline :value="__('Contact Details')" />
    <div class="grid gap-8 md:grid-cols-2">
        <x-input
            ref="contactDetailsName"
            name="name"
            type="text"
            label="{{ __('Full name') }}"
            x-model="name"
            x-on:input="if (!shippingDirty) shipping_name = name"
            required
        />

        <x-input
            name="email"
            type="email"
            label="{{ __('Email address') }}"
            value="{{ old('email') }}"
            required
        />
    </div>

</div>
