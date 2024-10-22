<span @class([
    'bg-green-200' => $campaign->status->is('published'),
    'bg-red-200' => $campaign->status->is('archived'),
    'bg-gray-200' => $campaign->status->is('draft'),
    'px-2 py-1 rounded-md text-xs',
])>
    {{ $campaign->status->label() }}
</span>
