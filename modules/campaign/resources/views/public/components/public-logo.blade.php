@inject('settings', \Funds\Foundation\SettingsService::class)
@if ($settings->get('logo'))
    <img
        src="{{ $settings->get('logo') }}"
        alt="Logo"
        class="max-w-40 h-auto"
    />
@elseif($settings->get('organization_name'))
    <span class="text-xl font-bold">{{ $settings->get('organization_name') }}</span>
@else
    <x-application-logo />
@endif
