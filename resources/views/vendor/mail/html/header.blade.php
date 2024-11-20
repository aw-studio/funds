@inject('settings', \Funds\Foundation\SettingsService::class)
@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if ($settings->get('logo'))
<img src="{{ $settings->get('logo') }}" width="100px" alt="{{ $settings->get('name') }}">
@else
{{ $settings->get('organization_name') ?? $slot}}
@endif
</a>
</td>
</tr>
