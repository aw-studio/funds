@inject('settings', \Funds\Foundation\SettingsService::class)
<x-public::campaign-layout>
    <div class="my-10">
        <div class="text-center">
            <h1 class="text-3xl font-bold">
                {{ __('Privacy Policy') }}
            </h1>
            <p>
                {{ new \Illuminate\Support\HtmlString(nl2br($settings->get('privacypolicy'))) }}
            </p>
        </div>
    </div>
</x-public::campaign-layout>
