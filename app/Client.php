<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $attributes = [
        'user_id' => 1
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function memberships()
    {
        return $this->belongsToMany(
            Membership::class,
            'clients_memberships',
            'client_id'
        )
            ->using(MembershipDetail::class)
            ->withPivot('start_at', 'end_at')
            ->withTimestamps();
    }
}
