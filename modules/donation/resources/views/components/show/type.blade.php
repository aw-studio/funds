                <div>
                    <span class="text-gray-500 text-sm">{{ __('Type') }}</span>
                    <div class="text-xl font-serif">
                        {{ $donation->label() }}
                    </div>
                    <div class="mt-2">
                        @if ($donation->reward)
                            <p class="flex gap-2 items-center">
                                <x-icons.gift />
                                {{ $donation->reward->name }}
                            </p>
                        @endif
                        @if ($donation->rewardVariant)
                            <p class="flex gap-2 items-center">
                                <x-icons.tag />
                                {{ $donation->rewardVariant->name }}
                            </p>
                        @endif
                    </div>
                </div>
