<?php

namespace App\Nova\Metrics;

use Illuminate\Support\Carbon;
use Laravel\Nova\Metrics\Value;

abstract class DateValue extends Value
{
    protected $days = 5;
    protected $format = "d M";

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        $range = [
            0 => 'Hoy',
            1 => 'Ayer'
        ];

        for ($i = 2; $i <= $this->days; $i++) {
            $range[$i] = Carbon::now()->subDays($i)->format($this->format);
        }

        return $range;
    }

    /**
     * Calculate the current range and calculate any short-cuts.
     *
     * @param  string|int $range
     * @return array
     */
    protected function currentRange($range)
    {
        if ($range == 0) {
            return [
                now()->toDateString(),
                now()->addDay()->toDateString()
            ];
        }

        return [
            now()->subDays($range)->toDateString(),
            now()->subDays($range - 1)->toDateString()
        ];
    }

    protected function previousRange($range)
    {
        return [
            now()->subDays($range + 1)->toDateString(),
            now()->subDays($range)->toDateString()
        ];
    }
}
