<?php

namespace App\Observers;

use App\Membership;
use App\MembershipDetail;
use Carbon\Carbon;

class MembershipDetailObserver
{
    /**
     * Handle the membership detail "created" event.
     *
     * @param  \App\MembershipDetail $membershipDetail
     * @return void
     */
    public function created(MembershipDetail $membershipDetail)
    {
        $this->generateEndAt($membershipDetail);
    }

    /**
     * Handle the membership detail "updated" event.
     *
     * @param  \App\MembershipDetail $membershipDetail
     * @return void
     */
    public function updated(MembershipDetail $membershipDetail)
    {
        $this->generateEndAt($membershipDetail);
    }

    /**
     * Handle the membership detail "deleted" event.
     *
     * @param  \App\MembershipDetail $membershipDetail
     * @return void
     */
    public function deleted(MembershipDetail $membershipDetail)
    {
        //
    }

    /**
     * Handle the membership detail "restored" event.
     *
     * @param  \App\MembershipDetail $membershipDetail
     * @return void
     */
    public function restored(MembershipDetail $membershipDetail)
    {
        //
    }

    /**
     * Handle the membership detail "force deleted" event.
     *
     * @param  \App\MembershipDetail $membershipDetail
     * @return void
     */
    public function forceDeleted(MembershipDetail $membershipDetail)
    {
        //
    }

    private function generateEndAt(MembershipDetail $membershipDetail) {
        $membership = $membershipDetail->membership;
        $client = $membership
            ->clients()
            ->where('client_id', $membershipDetail->client_id)
            ->get()
            ->first();

        $client->pivot->end_at = $membership->getEndDate($client->pivot->start_at);
        $client->pivot->save();
    }
}
