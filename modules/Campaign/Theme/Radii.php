<?php

namespace Funds\Campaign\Theme;

class Radii
{
    public static function options()
    {
        return [
            [
                'key' => 'button',
                'label' => 'Button',
                'description' => 'The border radius used for buttons.',
            ],
            [
                'key' => 'tab',
                'label' => 'Tab',
                'description' => 'The border radius used for tabs.',
            ],
            [
                'key' => 'tag',
                'label' => 'Tag',
                'description' => 'The border radius used for tags.',
            ],
            [
                'key' => 'input',
                'label' => 'Input',
                'description' => 'The border radius used for inputs.',
            ],
            [
                'key' => 'checkbox',
                'label' => 'Checkbox',
                'description' => 'The border radius used for checkboxes.',
            ],
            [
                'key' => 'card_radio',
                'label' => 'Card Radio',
                'description' => 'The border radius used for card radios.',
            ],
            [
                'key' => 'choice_chip',
                'label' => 'Choice Chip',
                'description' => 'The border radius used for choice chips.',
            ],
            [
                'key' => 'sidebar',
                'label' => 'Sidebar',
                'description' => 'The border radius used for sidebars.',
            ],
            [
                'key' => 'summary',
                'label' => 'Summary',
                'description' => 'The border radius used for summaries.',
            ],
            [
                'key' => 'image',
                'label' => 'Image',
                'description' => 'The border radius used for images.',
            ],
            [
                'key' => 'card',
                'label' => 'Card',
                'description' => 'The border radius used for cards.',
            ],
            [
                'key' => 'progress_bar',
                'label' => 'Progress Bar',
                'description' => 'The border radius used for progress bars.',
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

    public static function toCssVar(string $key, string $value): string
    {
        $key = str_replace('_', '-', $key);

        return "--radius-$key: {$value}px;";
    }
}
