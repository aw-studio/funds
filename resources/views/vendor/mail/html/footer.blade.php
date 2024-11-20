@inject('settings', \Funds\Foundation\SettingsService::class)
<tr>
<td>
<table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="content-cell" align="center">
<p>&copy; {{ date('Y') }} {{ $settings->get('organization_name') }}.<br> Powered by Funds</p>
</td>
</tr>
</table>
</td>
</tr>
