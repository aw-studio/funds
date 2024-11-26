<div class="contactDetails mb-16">
    <x-public::checkout.section-headline :value="__('Contact Details')" />
    <div class="grid md:grid-cols-2 gap-8">
        <x-input
            ref="contactDetailsName"
            name="name"
            type="text"
            label="{{ __('Full name') }}"
            placeholder="{{ __('Full name') }}"
            x-model="name"
            x-on:input="if (!shippingDirty) shipping_name = name"
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
