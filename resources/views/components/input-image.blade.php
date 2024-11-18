@props(['name', 'currentUrl', 'label' => null])
<x-input-label
    :value="$label"
    :for="$attributes->get('id', $attributes->get('name'))"
    :hint="$attributes->get('hint')"
/>
<div
    x-data="fileUpload(@js($currentUrl))"
    {{ $attributes->merge(['class' => 'flex justify-center items-center border bg-gray-50 border-gray-300  border-dashed rounded-md min-h-24 overflow-y-hidden']) }}
    :class="imageUrl && 'border-primary-500'"
>

    <template x-if="!imageUrl">
        <label
            class="relative cursor-pointer bg-transparent rounded-md space-y-1 text-center px-6 pt-5 pb-6 w-full"
            for="{{ $name }}"
        >
            <x-icons.add-image class="mx-auto h-8 w-8 text-gray-400" />
            <p class="text-gray-500 space-y-1 text-sm">
                <span>{{ __('Add a file') }}</span>
            </p>
        </label>
    </template>

    <template x-if="imageUrl">
        <div class="object-contain w-full group relative">
            <div
                class="text-sm hidden group-hover:flex absolute justify-center items-center m-auto text-white bg-transparent h-full w-full hover:bg-black/50 ">
                <span
                    x-on:click="clear()"
                    class="p-4 cursor-pointer hover:cursor-pointer"
                > Remove</span>
            </div>
            <img
                :src="imageUrl"
                alt=""
                x-bind:class="{ 'hidden': !imageUrl, 'object-contain h-56 w-full': imageUrl }"
            >
        </div>
    </template>

    <input
        id="{{ $name }}"
        class="sr-only"
        name="{{ $name }}"
        type="file"
        x-on:change="selectFile"
    >
    <input
        id="{{ $name }}_delete"
        :value="shouldDelete ? '{{ $currentUrl }}' : null"
        name="{{ $name }}_delete"
        type="hidden"
    />
</div>
@once
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('fileUpload', (initialUrl) => ({
                imageUrl: initialUrl,
                hasChanged: false,
                shouldDelete: false,
                init() {
                    this.$watch('imageUrl', (value) => {})
                },

                clear() {
                    this.imageUrl = ''
                    this.shouldDelete = true
                    this.hasChanged = true
                },

                selectFile(event) {
                    const file = event.target.files[0]
                    const reader = new FileReader()

                    if (event.target.files.length < 1) {
                        return
                    }

                    reader.readAsDataURL(file)

                    reader.onload = () => (this.imageUrl = reader.result)
                    this.hasChanged = true
                },
            }))
        })
    </script>
@endonce
