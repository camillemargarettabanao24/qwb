<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Authenticatable
{
    use HasFactory;
    protected $table = 'customers';

    protected $fillable = [
        'fname',
        'lname',
        'username',
        'email',
        'phone_number',
        'province',
        'city_municipality',
        'barangay',
        'password'
        ];

        public function baskets()
        {
            return $this->hasMany(Basket::class);
        }
    
        public function weddingPackageBaskets()
        {
            return $this->hasMany(WeddingPackageBasket::class);
        }
}
