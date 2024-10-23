{{-- @dump($data) --}}
@php
    $service = $data['service'];
    $source = $data['source'];
    $embed = $data['embed'];
    $width = $data['width'] ?? 580;
    $height = $data['height'] ?? 320;
    $caption = $data['caption'] ?? '';

    // Helper function to get service-specific class
    $getServiceClass = function ($baseService) use ($service) {
        return "editorjs-embed__content--$baseService";
    };
@endphp
<script>
    function videoEmbed() {
        return {
            consentGiven: false,

            checkConsent() {
                const consentCookie = document.cookie.split('; ').find(row => row.startsWith('videoConsent='));
                if (consentCookie) {
                    this.consentGiven = true;
                }
            },

            giveConsent() {
                this.consentGiven = true;
                document.cookie = "videoConsent=true; path=/; max-age=31536000"; // Set cookie for 1 year
            },

            clearConsent() {
                document.cookie = "videoConsent=; path=/; max-age=0"; // Delete cookie
                this.consentGiven = false;
            }
        };
    }
</script>
<div
    x-data="videoEmbed()"
    x-init="checkConsent()"
    class="flex flex-col items-center justify-center w-full embed"
>
    <div
        x-show="!consentGiven"
        class="w-full p-6 text-center no-consent"
    >
        <p class="mb-4 text-on-accent-2">@lang('Recommended external content. By activating the button, external content is displayed and personal data is transmitted to third-party platforms.')</p>
        <button
            class="fc-button"
            @click="giveConsent"
        >
            @lang('Load video')
        </button>
    </div>

    <template
        x-if="consentGiven"
        x-cloak
    >
        <div class="w-full max-w-lg">
            @switch($service)
                @case('youtube')
                    <iframe
                        class="editorjs-embed__iframe w-full"
                        width="{{ $width }}"
                        height="{{ $height }}"
                        src="{{ $embed }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                @break

                @case('vimeo')
                    <iframe
                        class="editorjs-embed__iframe w-full"
                        src="{{ $embed }}"
                        width="{{ $width }}"
                        height="{{ $height }}"
                        frameborder="0"
                        allow="autoplay; fullscreen; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                @break

                @default
                    <iframe
                        class="editorjs-embed__iframe w-full"
                        src="{{ $embed }}"
                        width="{{ $width }}"
                        height="{{ $height }}"
                        frameborder="0"
                    ></iframe>
            @endswitch
        </div>
    </template>
    <div
        x-show="consentGiven"
        x-cloak
    >
        <label
            for="defaultToggle"
            class="inline-flex cursor-pointer items-center gap-3"
            @click="clearConsent()"
        >
            <input
                id="defaultToggle"
                type="checkbox"
                class="peer sr-only"
                role="switch"
                checked
            />
            <div
                class="relative h-6 w-11 after:h-5 after:w-5 peer-checked:after:translate-x-5 rounded-full border border-slate-300 bg-slate-100 after:absolute after:bottom-0 after:left-[0.0625rem] after:top-0 after:my-auto after:rounded-full after:bg-slate-700 after:transition-all after:content-[''] peer-checked:bg-blue-700 peer-checked:after:bg-slate-100 peer-focus:outline peer-focus:outline-2 peer-focus:outline-offset-2 peer-focus:outline-slate-800 peer-focus:peer-checked:outline-blue-700 peer-active:outline-offset-0 peer-disabled:cursor-not-allowed peer-disabled:opacity-70 dark:border-slate-700 dark:bg-slate-800 dark:after:bg-slate-300 dark:peer-checked:bg-blue-600 dark:peer-checked:after:bg-slate-100 dark:peer-focus:outline-slate-300 dark:peer-focus:peer-checked:outline-blue-600"
                aria-hidden="true"
            ></div>
            <span
                class="trancking-wide text-sm font-medium text-slate-700 peer-checked:text-black peer-disabled:cursor-not-allowed peer-disabled:opacity-70 dark:text-slate-300 dark:peer-checked:text-white"
            >Revoke Consent</span>
        </label>
    </div>
</div>
@if ($caption)
    <div class="text-sm my-2">{{ $caption }}</div>
@endif
