<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    public function clients()
    {
        return $this->belongsToMany(
            Client::class,
            'clients_memberships',
            'membership_id'
        )
            ->using(MembershipDetail::class)
            ->withPivot('start_at', 'end_at')
            ->withTimestamps();
    }

    public function getEndDate(Carbon $startAt)
    {
        if ($this->days % 30 == 0) {
            $date = $startAt->addMonths($this->days / 30);
        } else {
            $date = $startAt->addDays($this->days);
        }

        return $date->toDateString();
    }

    public function getDetailAttribute()
    {
        $detail = '';

        if (isset($this->pivot->end_at)) {
            $detail = $this->name . ' (' . $this->pivot->start_at->format("d M") . ' - ' . $this->pivot->end_at->format("d M") . ')';
        }

        return $detail;
    }
}
