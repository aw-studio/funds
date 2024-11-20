<?php

namespace Funds\Campaign\Theme;

class Colors
{
    public static function options()
    {
        return [
            [
                'key' => 'general_bg',
                'label' => 'General Background',
                'description' => 'The background color used for general elements.',
            ],
            [
                'key' => 'general_text',
                'label' => 'General Text',
                'description' => 'The text color used for general elements.',
            ],
            [
                'key' => 'accent_1',
                'label' => 'Accent 1',
                'description' => 'The primary color used to highlight elements.',
            ],
            [
                'key' => 'accent_2',
                'label' => 'Accent 2',
                'description' => 'The secondary color used for background elements.',
            ],
            [
                'key' => 'interaction',
                'label' => 'Interaction',
                'description' => 'The background color used for interactive elements.',
            ],
            [
                'key' => 'interaction_text',
                'label' => 'Interaction Text',
                'description' => 'The text color used for interactive elements.',
            ],
        ];

    }

    public static function all()
    {
        return array_map(fn ($option) => new ThemeOption(
            key: $option['key'],
            label: $option['label'],
            description: $option['description']),

            self::options()
        );
    }

    public static function toCssVar(string $key, string $value)
    {
        $key = str_replace('_', '-', $key);
        $value = implode(', ', self::hexToRgb($value));

        return implode("\n", [
            "--color-$key-rgb: $value;",
        ]);
    }

    public static function hexToRgb(string $hexString)
    {
        $hexString = str_replace('#', '', $hexString);

        if (strlen($hexString) === 3) {
            $hexString = implode('', array_map(function ($char) {
                return str_repeat($char, 2);
            }, str_split($hexString)));
        }

        $hexString = str_split($hexString, 2);

        return array_map('hexdec', $hexString);

    }
}
