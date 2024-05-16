<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'customer_id',
        'total_app_price',

        'phone_number',
        'province',
        'city_municipality',
        'barangay',

        'appointment_time',
        'appointment_date'
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function basket()
    {
        return $this->belongsToMany(Basket::class, 'appointment_basket_pivot', 'appointment_id', 'shopping_basket_id');
    }

    public function weddingPackageBasket()
    {
        return $this->belongsToMany(WeddingPackageBasket::class, 'appointment_wedding_package_basket_pivot', 'appointment_id', 'wp_basket_id');
    }

}
