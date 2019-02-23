<?php

namespace App\Nova\Metrics;

use App\Sell;
use Illuminate\Http\Request;
use DB;

class NewSells extends DateValue
{
    /**
     * The displayable name of the metric.
     *
     * @var string
     */
    public $name = "Ventas registradas";

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
            Sell::join('products', 'sells.product_id', '=', 'products.id'),
            DB::raw('products.price * sells.quantity'),
            'sells.created_at'
        )->format(',0n')->currency('$');
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'new-sells';
    }
}
