<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\VoltServiceProvider::class,
    \Funds\Core\FundsCoreServiceProvider::class,
    \Funds\Campaign\Providers\CampaignServiceProvider::class,
    \Funds\Donations\DonationsServiceProvider::class,
    \Funds\Order\OrderServiceProvider::class,
    \Funds\Reward\RewardsServiceProvider::class,
    \Funds\RecurringDonations\RecurringDonationsServiceProvider::class,
];
