<?php

namespace Funds\Donations\Tests\Support;

use Illuminate\Database\Eloquent\Model;

class TestCampaign extends Model
{
    public function getIdAttribute()
    {
        return 1;
    }

    public function getName()
    {
        return 'Campaign Name';
    }

    public function getDescription()
    {
        return 'Campaign Description';
    }

    public function getGoal()
    {
        return 1000;
    }

    public function getAmountRaised()
    {
        return 0;
    }
}
