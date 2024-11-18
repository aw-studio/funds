<x-app-layout>
    <x-form-page-container :title="__('Settings')">
        <x-card>
            <p class="text-lg">@lang('General Information')</p>
            <p class="text-gray-600">
                @lang('Your organization\'s name and logo will be displayed in the emails that your supporters receive.')</p>
            <form
                action="{{ route('settings.update') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-6"
            >
                @csrf
                @method('PUT')
                <div class="w-3/4">
                    <x-input
                        type="text"
                        name="organization_name"
                        :label="__('Organization Name')"
                        hint="The name of the organizer"
                        value="{{ $settings['organization_name'] ?? '' }}"
                    />
                </div>
                <div class="w-3/4">
                    <x-input-image
                        name="logo"
                        :label="__('Organization Logo')"
                        hint="Recommended type: .png"
                        currentUrl="{{ $settings['logo'] ?? '' }}"
                    />
                </div>
                <div class="flex justify-end">
                    <x-button type="submit">{{ __('Save') }}</x-button>
                </div>
            </form>
        </x-card>
        <x-card>
            <p class="text-lg">@lang('Legal')</p>
            <p>@lang('Please provide the legal information for your organization.')</p>
            <form
                action="{{ route('settings.update') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-6"
            >
                @csrf
                @method('PUT')
                <x-textarea
                    name="terms"
                    :label="__('Terms of Service')"
                >{{ $settings['terms'] ?? '' }}</x-textarea>

                <x-textarea
                    name="privacypolicy"
                    :label="__('Privacy Policy')"
                >{{ $settings['privacypolicy'] ?? '' }}</x-textarea>

                <x-textarea
                    name="imprint"
                    :label="__('Imprint')"
                >{{ $settings['imprint'] ?? '' }}</x-textarea>
                <div class="flex justify-end">
                    <x-button type="submit">{{ __('Save') }}</x-button>
                </div>
            </form>
        </x-card>
    </x-form-page-container>
</x-app-layout>
