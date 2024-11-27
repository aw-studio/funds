<?php

return [
    /**
     * Whether to enable a public campaign overview page.
     * If enabled, a public route will be registered for "/" to display all campaigns.
     * If disabled, the root path "/" will be redirected to the app login.
     */
    'public_campaign_overview' => env('PUBLIC_CAMPAIGN_OVERVIEW', false),

    'single_campaign_mode' => env('SINGLE_CAMPAIGN_MODE', false),

    'default_currency' => env('DEFAULT_CURRENCY', 'EUR'),

    'stripe' => [
        'publishable_key' => env('STRIPE_PUBLISHABLE_KEY'),
        'secret_key' => env('STRIPE_SECRET_KEY'),
    ],
];
