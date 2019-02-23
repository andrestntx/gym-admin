<?php

namespace App\Nova\Metrics;

use App\Balance;
use Illuminate\Http\Request;
use DB;

class NewBalance extends DateValue
{
    /**
     * The displayable name of the metric.
     *
     * @var string
     */
    public $name = "Dinero inicial de la caja";

    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->sum(
            $request,
            Balance::class,
            'new_base',
            DB::raw("DATE_ADD(closed_at, INTERVAL 1 DAY)")
        )->format(',0n')->currency('$');

    }

    /**
     * Calculate the current range and calculate any short-cuts.
     *
     * @param  string|int $range
     * @return array
     */
    protected function currentRange($range)
    {
        return [
            now()->subDays($range)->toDateString(),
            now()->subDays($range)->toDateString()
        ];
    }

    /**
     * Calculate the current range and calculate any short-cuts.
     *
     * @param  string|int $range
     * @return array
     */
    protected function previousRange($range)
    {
        return [
            now()->subDays($range + 1)->toDateString(),
            now()->subDays($range + 1)->toDateString()
        ];
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'new-balance';
    }
}
