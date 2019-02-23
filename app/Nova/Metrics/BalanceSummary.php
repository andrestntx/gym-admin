<?php

namespace App\Nova\Metrics;

use App\Balance;
use App\MembershipDetail;
use App\Expense;
use App\Sell;
use Illuminate\Http\Request;
use DB;

class BalanceSummary extends DateValue
{
    /**
     * The displayable name of the metric.
     *
     * @var string
     */
    public $name = "Dinero que debe haber en caja";

    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        $initBase = $this->sum(
            $request,
            Balance::class,
            'new_base',
            DB::raw("DATE_ADD(closed_at, INTERVAL 1 DAY)")
        );

        $sold = $this->sum(
            $request,
            Sell::join('products', 'sells.product_id', '=', 'products.id'),
            DB::raw('products.price * sells.quantity'),
            DB::raw('DATE(sells.created_at)')
        );

        $soldByMemberships = $this->sum(
            $request,
            MembershipDetail::join('memberships', 'clients_memberships.membership_id', '=', 'memberships.id'),
            'memberships.price',
            'clients_memberships.start_at'
        );

        $spent = $this->sum(
            $request,
            Expense::class,
            'value',
            'paid_at'
        );

        return $this->result($initBase->value + $sold->value + $soldByMemberships->value - $spent->value)
            ->format(',0n')
            ->currency('$');
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
        return 'balance-sumary';
    }
}
