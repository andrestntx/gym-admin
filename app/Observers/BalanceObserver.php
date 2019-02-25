<?php

namespace App\Observers;

use App\Balance;

class BalanceObserver
{
    /**
     * Handle the balance "created" event.
     *
     * @param  \App\Balance  $balance
     * @return void
     */
    public function created(Balance $balance)
    {
        $balance->user()->associate(auth()->user());
        $balance->save();
    }

    /**
     * Handle the balance "updated" event.
     *
     * @param  \App\Balance  $balance
     * @return void
     */
    public function updated(Balance $balance)
    {
        //
    }

    /**
     * Handle the balance "deleted" event.
     *
     * @param  \App\Balance  $balance
     * @return void
     */
    public function deleted(Balance $balance)
    {
        //
    }

    /**
     * Handle the balance "restored" event.
     *
     * @param  \App\Balance  $balance
     * @return void
     */
    public function restored(Balance $balance)
    {
        //
    }

    /**
     * Handle the balance "force deleted" event.
     *
     * @param  \App\Balance  $balance
     * @return void
     */
    public function forceDeleted(Balance $balance)
    {
        //
    }
}
