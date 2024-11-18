<?php

use Livewire\Volt\Component;
use Funds\Foundation\Facades\Funds;
use App\Livewire\Actions\Logout;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav
    x-data="{ open: false }"
    class="bg-gray-50 border-b border-gray-200 sticky top-0 z-50"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16">
            <!-- Logo -->
            <div class="shrink-0 flex items-center mr-auto">
                <a
                    href="{{ route('dashboard') }}"
                    wire:navigate
                >
                    <x-application-logo class="block h-5 w-auto fill-current text-gray-800 " />
                </a>
            </div>
            <div class="flex">

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link
                        :href="route('campaigns.index')"
                        :active="request()->routeIs('campaigns.*') ||
                            request()->routeIs('donations.*') ||
                            request()->routeIs('rewards.*')"
                        wire:navigate
                    >
                        {{ __('Campaigns') }}
                    </x-nav-link>

                    @foreach (Funds::navigation()->items() as $nav)
                        <x-nav-link
                            :href="$nav['route']"
                            :active="$nav['active']"
                            wire:navigate
                        >
                            {{ __($nav['title']) }}

                            @if ($nav['badge'])
                                <span
                                    class="ml-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs text-white bg-orange-500"
                                >
                                    {{ $nav['badge'] }}
                                </span>
                            @endif

                        </x-nav-link>
                    @endforeach
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown
                    align="right"
                    width="48"
                >
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500  hover:text-gray-700 :text-gray-300 focus:outline-none transition ease-in-out duration-150"
                        >

                            <p
                                class="text-base font-normal mr-2"
                                x-data="{
                                    userName: @js(auth()->user()->name),
                                }"
                                x-text="userName"
                                x-on:profile-updated.window="userName = $event.detail.name"
                            >{{ auth()->user()->name }}</p>
                            <div class="rounded-full h-10 w-10 bg-white flex items-center justify-center">
                                <div
                                    x-data="{{ json_encode(['initialLetters' => auth()->user()->initialLetters()]) }}"
                                    x-text="initialLetters"
                                    x-on:profile-updated.window="initialLetters = $event.detail.initialLetters"
                                ></div>
                            </div>

                            <div class="ms-1">
                                <svg
                                    class="fill-current h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link
                            :href="route('profile')"
                            wire:navigate
                        >
                            {{ __('My Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link
                            :href="route('settings.show')"
                            wire:navigate
                        >
                            {{ __('Organization Settings') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button
                            wire:click="logout"
                            class="w-full text-start"
                        >
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400  hover:text-gray-500 :text-gray-400 hover:bg-gray-100 :bg-gray-900 focus:outline-none focus:bg-gray-100 :bg-gray-900 focus:text-gray-500 :text-gray-400 transition duration-150 ease-in-out"
                    @click="open = ! open"
                >
                    <svg
                        class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            :class="{ 'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            :class="{ 'hidden': !open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div
        :class="{ 'block': open, 'hidden': !open }"
        class="hidden sm:hidden"
    >
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link
                :href="route('campaigns.index')"
                :active="request()->routeIs('campaigns.index')"
                wire:navigate
            >
                {{ __('Campaigns') }}
            </x-responsive-nav-link>

            @foreach (Funds::navigation()->items() as $nav)
                <x-responsive-nav-link
                    :href="$nav['route']"
                    :active="$nav['active']"
                    wire:navigate
                >
                    {{ __($nav['title']) }}

                    @if ($nav['badge'])
                        <span
                            class="ml-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs text-white bg-orange-500"
                        >
                            {{ $nav['badge'] }}
                        </span>
                    @endif

                </x-responsive-nav-link>
            @endforeach
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 ">
            <div class="px-4">
                <div
                    class="font-medium text-base text-gray-800 "
                    x-data="{{ json_encode(['name' => auth()->user()->name]) }}"
                    x-text="name"
                    x-on:profile-updated.window="name = $event.detail.name"
                ></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link
                    :href="route('profile')"
                    wire:navigate
                >
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link
                    :href="route('settings.show')"
                    wire:navigate
                >
                    {{ __('Organization Settings') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button
                    wire:click="logout"
                    class="w-full text-start"
                >
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
