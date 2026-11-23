<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'keahlian',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function projects()
        {
            return $this->hasMany(Project::class, 'client_id');
        }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'developer_id');
    }
}