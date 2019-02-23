<?php

namespace App\Nova\Metrics;

use App\Expense;
use Illuminate\Http\Request;

class NewExpenses extends DateValue
{
    /**
     * The displayable name of the metric.
     *
     * @var string
     */
    public $name = "Gastos registrados";

    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->sum(
            $request,
            Expense::class,
            'value',
            'paid_at'
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
        return 'new-expenses';
    }
}
