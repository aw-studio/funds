<?php

namespace Funds\Reward\View;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RewardShippingOptions extends Component
{
    public array $options;

    public ?string $selected;

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $selected
    ) {
        $this->options = config('rewards.shipping_options', []);
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('rewards::components.shipping-option-select', [
            'options' => config('rewards.shipping_options', []),
        ]);
    }
}
