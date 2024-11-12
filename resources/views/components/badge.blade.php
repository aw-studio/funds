@props(['variant' => null])
<?php
$colors = match ($variant) {
    'danger' => 'bg-danger-200 text-danger-600',
    'warning' => 'bg-warning-200 text-warning-600',
    'success', 'green' => 'bg-success-200 text-success-600',
    'info', 'blue' => 'bg-blue-200 text-blue-600',
    'orange' => 'bg-orange-200 text-orange-600',
    'purple' => 'bg-purple-200 text-purple-600',
    default => 'bg-gray-200 text-gray-600',
};
?>
<span @class(['px-2 py-1 rounded-md text-xs', $colors])>
    {{ $slot }}
</span>
