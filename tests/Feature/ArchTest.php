<?php

// test('Not debugging statements are left in our code.')
//     ->expect(['dd', 'dump', 'ray'])
//     ->not->toBeUsed();

// test('Query classes are used for read operations')
//     ->expect('Domains\*\Queries')
//     // ->toBeUsedIn('App\Http\Controllers\Api\*\*\IndexController')
//     // ->toBeUsedIn('App\Http\Controllers\Api\*\*\ShowController')
//     ->not->toBeUsedIn('App\Http\Controllers\Api\*\*\StoreController')
//     ->not->toBeUsedIn('App\Http\Controllers\Api\*\*\UpdateController')
//     ->not->toBeUsedIn('App\Http\Controllers\Api\*\*\DeleteController');

arch('It stays within the core')
    ->expect('Funds\Order')
    ->toOnlyBeUsedIn('Funds\Order')
    ->ignoring('Funds\Donations');
