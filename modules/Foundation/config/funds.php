<?php

return [
    'name' => 'Core',

    /**
     * Whether to enable a public campaign overview page.
     * If enabled, a public route will be registered for "/" to display all campaigns.
     * If disabled, the root path "/" will be redirected to the app login.
     */
    'public_campaign_overview' => false,

    'default_currency' => env('DEFAULT_CURRENCY', 'EUR'),
];
