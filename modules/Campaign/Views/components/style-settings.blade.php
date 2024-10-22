@php
    $colors = \Funds\Campaign\Theme\Colors::all();

    $radii = \Funds\Campaign\Theme\Radii::all();

@endphp

<div class="max-w-xl my-10">
    <p class="text-xl ">Style Settings</p>
    <p class="text-lg my-2">Colors</p>
    <p class="text-gray-600 mb-2 text-sm">Customize the colors and border radius of your campaign.</p>
    @foreach ($colors as $color)
        <div
            class="flex gap-2 border-b border-gray-200 py-2"
            x-data="{
                value: @js(old($color->key, \Illuminate\Support\Arr::get($campaign->settings, 'colors.' . $color->key) ?? '#010101')),
                reset() {
                    this.value = '#010101';
                },
                get isDefault() {
                    return this.value === '#010101';
                }
            }"
        >
            <input
                type="color"
                name="colors[{{ $color->key }}]"
                x-model="value"
                :class="{ 'opacity-10': isDefault }"
            />
            <label
                for="{{ $color->key }}"
                class="mb-4"
            >
                <p class="font-semibold">{{ $color->label }}</p>
                <p>
                    {{ $color->description }}
                </p>
                <small
                    x-on:click="reset "
                    x-show="!isDefault"
                >Reset</small>
            </label>
        </div>
    @endforeach
    <p class="text-lg my-2 mt-8">Radius</p>
    <p class="text-gray-600 mb-2 text-sm">Customize the border radius of your campaign.</p>
</div>

@foreach ($radii as $radius)
    <div>
        <div
            class="flex gap-2 border-b border-gray-200 py-2"
            x-data="{
                value: @js(old($radius->key, \Illuminate\Support\Arr::get($campaign->settings, 'radius.' . $radius->key) ?? null)),
                reset() {
                    this.value = null;
                },
                get isDefault() {
                    return this.value === null;
                }
            }"
        >
            <x-input
                type="number"
                name="radius[{{ $radius->key }}]"
                x-model="value"
                placeholder="Default"
            />
            <label for="{{ $radius->key }}">
                <p class="font-semibold">{{ $radius->label }}</p>
                <p>
                    {{ $radius->description }}
                </p>
                <small
                    x-on:click="reset"
                    x-show="!isDefault"
                >Reset</small>
            </label>
        </div>

    </div>
@endforeach
