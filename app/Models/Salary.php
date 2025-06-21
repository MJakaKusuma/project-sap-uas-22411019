<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = [
        'user_id',
        'basic_salary',
        'allowance',
        'bonus',
        'deduction',
        'amount',
        'payment_status',
        'payment_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function booted()
    {
        static::creating(function ($salary) {
            $salary->amount =
                $salary->basic_salary +
                $salary->allowance +
                $salary->bonus -
                $salary->deduction;
        });
    }
}
