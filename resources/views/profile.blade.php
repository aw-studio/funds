<x-app-layout :title="page_title(__('Profile'))">

    <x-form-page-container
        class="py-12"
        :title="__('Profile')"
    >
        <div class="p-4 sm:p-8 bg-gray-50 rounded-lg">
            <div class="max-w-xl">
                <livewire:profile.update-profile-information-form />
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-gray-50 rounded-lg">
            <div class="max-w-xl">
                <livewire:profile.update-password-form />
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-gray-50 rounded-lg">
            <div class="max-w-xl">
                <livewire:profile.delete-user-form />
            </div>
        </div>
        </x-container>
</x-app-layout>
