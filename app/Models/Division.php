<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = ['company_id', 'name'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Hapus karena employee sudah gabung ke user
    // public function employees()
    // {
    //     return $this->hasMany(Employee::class);
    // }
}
