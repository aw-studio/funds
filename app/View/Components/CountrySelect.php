<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Symfony\Component\Intl\Countries;

class CountrySelect extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $selectedOption = '',
        public array $countries = []
    ) {
        $this->countries = Countries::getNames(app()->getLocale());
        if ($this->selectedOption == '') {
            $this->guessDefaultSelectedOption();
        }
    }

    protected function guessDefaultSelectedOption()
    {
        $guessDefault = strtoupper(app()->getLocale());

        if (array_key_exists($guessDefault, $this->countries)) {
            $this->selectedOption = $guessDefault;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.country-select');
    }
}
