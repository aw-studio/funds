@if ($donations->isEmpty())
    <p>No donations found.</p>
@endif
@foreach ($donations as $donation)
    <table class="w-full">
        <tr>
            <td>{{ $donation->id }}</td>
            <td>{{ $donation->created_at->isoFormat('L') }}</td>
            <td>{{ $donation->donor->email }}</td>
            <td>{{ $donation->amount->format() }}</td>
        </tr>
    </table>
@endforeach
