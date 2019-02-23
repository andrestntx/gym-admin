<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $attributes = [
        'user_id' => 1
    ];

    protected $casts = [
        'paid_at' => 'date'
    ];

    protected $fillable = [
        'paid_at', 'description', 'value', 'expense_category_id'
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,);
    }
}
