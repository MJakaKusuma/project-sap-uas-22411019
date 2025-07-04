<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisionDetail extends Model
{
    protected $fillable = ['division_id', 'company_id', 'basic_salary'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function users()
    {
        return $this->hasMany(User::class, 'division_detail_id');
    }


}

