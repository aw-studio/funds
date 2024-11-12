<div class="bg-gray-50  overflow-hidden  sm:rounded-lg">
    <div class="p-6 text-black text-sm">
        <span class="text-lg">
            {{ __('Top Rewards') }}
        </span>
        <ul>
            @foreach ($rewards as $reward)
                <li class="flex justify-between py-4 border-b">
                    {{ $reward->name }} <span>{{ $reward->order_count }}</span>
                </li>
            @endforeach
            @if ($rewards->isEmpty())
                <li class="py-4">
                    {{ __('No data available') }}
                </li>
            @endif
        </ul>
    </div>
</div>
