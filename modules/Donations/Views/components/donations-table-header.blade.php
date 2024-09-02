@isset($extraColumns)
    @foreach ($extraColumns as $column)
        <th class="whitespace-nowrap text-left px-4 py-2 font-medium">
            {{ $column }}
        </th>
    @endforeach
@endisset
