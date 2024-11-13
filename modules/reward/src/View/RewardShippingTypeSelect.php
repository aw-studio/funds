<?php

namespace Funds\Reward\View;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RewardShippingTypeSelect extends Component
{
    public array $options;

    public ?string $selected;

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $selected,
        array $options = [],
    ) {
        $this->options = ! empty($options) ? $options : $this->defaultOptions();

        $this->selected = $selected;
    }

    protected function defaultOptions(): array
    {
        return config('rewards.shipping_options', []);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('rewards::components.shipping-type-select');
    }
}
