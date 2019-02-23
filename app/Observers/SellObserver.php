<?php

namespace App\Observers;

use App\Sell;

class SellObserver
{
    /**
     * Handle the sell "created" event.
     *
     * @param  \App\Sell  $sell
     * @return void
     */
    public function created(Sell $sell)
    {
        $sell->user()->associate(auth()->user());
        $sell->save();
    }

    /**
     * Handle the sell "updated" event.
     *
     * @param  \App\Sell  $sell
     * @return void
     */
    public function updated(Sell $sell)
    {
        //
    }

    /**
     * Handle the sell "deleted" event.
     *
     * @param  \App\Sell  $sell
     * @return void
     */
    public function deleted(Sell $sell)
    {
        //
    }

    /**
     * Handle the sell "restored" event.
     *
     * @param  \App\Sell  $sell
     * @return void
     */
    public function restored(Sell $sell)
    {
        //
    }

    /**
     * Handle the sell "force deleted" event.
     *
     * @param  \App\Sell  $sell
     * @return void
     */
    public function forceDeleted(Sell $sell)
    {
        //
    }
}
