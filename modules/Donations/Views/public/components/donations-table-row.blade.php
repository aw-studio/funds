@isset($extraColumns)
    @foreach ($extraColumns as $column)
        <td class="whitespace-nowrap px-4 py-2">
            {{ $column }}
        </td>
    @endforeach
@endisset
