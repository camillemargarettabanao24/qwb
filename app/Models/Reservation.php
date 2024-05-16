<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'customer_id',

        'total_res_price',
        'payment_deposit',
        'payment_method',

        'account_name',
        'account_number',
        'image_path',
        'status',

        'reservation_time',
        'reservation_date',

        'confirmation'
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function basket(): BelongsToMany
    {
        return $this->belongsToMany(Basket::class, 'reservation_basket_pivot', 'reservation_id', 'shopping_basket_id');
    }

    public function weddingPackageBasket()
    {
        return $this->belongsToMany(WeddingPackageBasket::class, 'reservation_wedding_package_basket_pivot', 'reservation_id', 'wp_basket_id');
    }

}
