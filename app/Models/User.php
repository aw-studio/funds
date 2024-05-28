<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Funds\Campaign\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function initialLetters(): string
    {
        return str($this->name)->ucsplit()->map(fn ($partial) => $partial[0])->join('');
    }

    public function currentCampaign()
    {
        return $this->belongsTo(Campaign::class, 'current_campaign_id');
    }
}
