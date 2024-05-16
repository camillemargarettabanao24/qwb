<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\CustomerProfileUpdated;

class CustomerProfile extends Model
{
    use HasFactory;

    protected $table = 'customer_profile';

    protected $fillable = [
        'customer_id',

        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'phone_number',
        'email',

        'province',
        'city_municipality',
        'barangay'

    ];

    
}
