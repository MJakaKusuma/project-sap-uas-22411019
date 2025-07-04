<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = ['name'];

    public function details()
    {
        return $this->hasMany(DivisionDetail::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}


// Hapus karena employee sudah gabung ke user
// public function employees()
// {
//     return $this->hasMany(Employee::class);
// }

