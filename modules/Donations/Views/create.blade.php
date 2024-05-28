<x-campaign-layout backRoute="{{ route('donations.index') }}">
    <div>
        {{ __('Manually Add Donation - received externaly.') }}
    </div>
    <form
        method="POST"
        action="{{ route('donations.store') }}"
    >
        @csrf
        <input
            type="email"
            name="email"
            value="{{ app()->isLocal() ? 'dev@dev.com' : old('email') }}"
            placeholder="Email"
        >
        <input
            type="number"
            name="amount"
            value="100"
            placeholder="Amount"
        >
        <button type="submit">
            {{ __('Add Donation') }}
        </button>
    </form>
</x-campaign-layout>
