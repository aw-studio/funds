<?php

namespace Funds\Campaign\Theme;

class CampaginStyles
{
    protected $options = [];

    public function __construct(
        array $colors,
        array $radii = [],
    ) {
        $this->options['colors'] = $colors;
        $this->options['radii'] = $radii;
    }

    public function toCssVariables()
    {
        $css = '';

        foreach ($this->options as $group => $options) {
            $css .= match ($group) {
                'colors' => $this->colorCssVariables($options),
                'radii' => $this->radiiCssVariables($options),
                default => '',
            };
        }

        return $css;
    }

    protected function radiiCssVariables($options)
    {
        $css = '';

        $radii = array_filter($options);

        foreach ($radii as $key => $value) {
            $css .= Radii::toCssVar($key, $value).PHP_EOL;
        }

        return $css;
    }

    protected function colorCssVariables($options)
    {
        $css = '';

        $colors = array_filter($options);

        foreach ($colors as $key => $value) {
            $css .= Colors::toCssVar($key, $value).PHP_EOL;
        }

        return $css;
    }
}
