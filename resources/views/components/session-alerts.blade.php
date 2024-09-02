@if (session('flashMessage'))
    <div
        x-cloak
        x-data="{ show: false }"
        x-show="show"
        x-init="setTimeout(() => { show = true;
            setTimeout(() => show = false, 3000); }, 100)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        class="fixed right-4 bottom-4 max-w-xs space-y-2"
    >
        <div
            id="flash-message"
            role="alert"
            class="rounded-xl bg-black text-white p-4 "
        >
            <div class="flex items-start gap-4">
                @php
                    $type = session('flashMessage')['type'];
                @endphp

                @if ($type === 'success')
                    <span class="text-green-600">
                        <x-icons.check />
                    </span>
                @elseif ($type === 'error')
                    <span class="text-red-600">
                    </span>
                @elseif ($type === 'warning')
                    <span class="text-yellow-600">
                    </span>
                @elseif ($type === 'info')
                    {{-- <span class="text-blue-600">
                        <x-icons.info />
                    </span> --}}
                @endif

                <div class="flex-1">
                    <p @class([
                        'mt-1 text-sm text-gray-700',
                        'text-green-600' => session('flashMessage')['type'] === 'success',
                        'text-red-600' => session('flashMessage')['type'] === 'error',
                        'text-yellow-600' => session('flashMessage')['type'] === 'warning',
                        'text-blue-600' => session('flashMessage')['type'] === 'info',
                    ])>
                        {{ session('flashMessage')['message'] }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif
