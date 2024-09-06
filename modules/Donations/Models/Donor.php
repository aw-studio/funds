<?php

namespace Funds\Donations\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'email',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
