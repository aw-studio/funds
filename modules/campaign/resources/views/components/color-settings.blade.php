<?php
use Illuminate\Support\Arr;
use Funds\Campaign\Theme\Radii;
use Funds\Campaign\Theme\Colors;

$colors = Colors::all();
$radii = Radii::all();
?>
<style>
    /*------ Style 2 ------*/
    input[type="color"] {
        -moz-appearance: none;
        -webkit-appearance: none;
        appearance: none;
        background: none;
        border: 0;
        cursor: pointer;
        height: 50px;
        padding: 0;
        width: 50px;
        border-radius: 100%;
        border: 2px solid grey;
    }

    *:focus {
        border-radius: 0;
        outline: none;
    }

    ::-webkit-color-swatch-wrapper {
        padding: 0;
    }

    ::-webkit-color-swatch {
        border: 0;
        border-radius: 0;
    }

    ::-moz-color-swatch,
    ::-moz-focus-inner {
        border: 0;
    }

    ::-moz-focus-inner {
        padding: 0;
    }
</style>
<div class="max-w-xl my-10">
    @foreach ($colors as $color)
        <div
            class="flex gap-2 border-b border-gray-200 py-2"
            x-data="{
                value: @js(old($color->key, Arr::get($campaign->settings, 'colors.' . $color->key) ?? '#010101')),
                reset() {
                    this.value = '#010101';
                },
                get isDefault() {
                    return this.value === '#010101';
                }
            }"
        >

            <label
                for="colors[{{ $color->key }}]"
                class="mb-4 "
            >
                <input
                    type="color"
                    name="colors[{{ $color->key }}]"
                    x-model="value"
                    class="style2"
                    :class="{ 'opacity-10': isDefault }"
                    x-cloak
                />
            </label>
            <div class="">
                <p class="font-semibold">{{ $color->label }}</p>
                <p>
                    {{ $color->description }}
                </p>
                <small
                    class="text-orange-500 cursor-pointer"
                    x-on:click="reset "
                    x-show="!isDefault"
                >{{ __('Reset') }}</small>
            </div>
        </div>
    @endforeach
</div>
