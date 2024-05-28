<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Campaigns') }}
        </h2>

    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form
                            method="post"
                            action="{{ route('campaigns.store') }}"
                        >
                            @csrf
                            <input
                                type="text"
                                name="name"
                                placeholder="Name"
                            >
                            <input
                                type="text"
                                name="description"
                                placeholder="Description"
                            >
                            <x-primary-button type="submit">
                                {{ __('Create Campaign') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
