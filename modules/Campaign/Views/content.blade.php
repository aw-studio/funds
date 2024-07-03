<x-campaign-layout :campaign="$campaign">
    <form
        method="post"
        action="{{ route('campaigns.content.store', ['campaign' => $campaign]) }}"
    >
        @csrf
        <textarea
            name="content"
            class="w-full h-96"
        >{{ $campaign->content }}</textarea>

        <x-primary-button type="submit">
            {{ __('Save') }}
        </x-primary-button>
    </form>
</x-campaign-layout>
