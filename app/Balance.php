<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $casts = [
        'closed_at' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
