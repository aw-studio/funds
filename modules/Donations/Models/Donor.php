<?php

namespace Funds\Donations\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;

    public $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->first_name.' '.$this->last_name,
        );
    }
}
