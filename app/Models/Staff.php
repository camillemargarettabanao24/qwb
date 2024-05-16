<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Authenticatable
{
    use HasFactory;
    protected $table = 'staffs';
    protected $fillable = [
        'fname',
        'lname',
        'username',
        'email',
        'password',
    ];
}
