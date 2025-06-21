<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'email', 'phonenumber', 'address'];

    public function divisions()
    {
        return $this->hasMany(Division::class);
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

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }
}
