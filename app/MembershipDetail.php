<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MembershipDetail extends Pivot
{
    protected $table = "clients_memberships";

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date'
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
