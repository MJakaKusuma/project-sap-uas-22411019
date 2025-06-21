<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'company_id',
        'division_id',
        'phone',
        'address',
    ];

    protected $hidden = ['password', 'remember_token'];

    // Relasi ke perusahaan
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relasi ke divisi
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // Contoh relasi ke gaji atau cuti jika ada
    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

}
