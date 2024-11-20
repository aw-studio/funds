<?php

namespace Funds\Donation\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Donor extends Model
{
    use HasFactory;
    use Notifiable;

    public $fillable = [
        'name',
        'email',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('email', 'like', "%$search%")
            ->orWhere('name', 'like', "%$search%");
    }
}
