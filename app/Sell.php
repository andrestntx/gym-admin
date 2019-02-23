<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    protected $attributes = [
        'user_id' => 1
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalAttribute()
    {
        $price = 0;

        if (isset($this->product->price)) $price = $this->product->price;

        return $price * $this->quantity;
    }
}