<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Basket extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'shopping_basket';

    protected $fillable = [
        'customer_id',
        'product_id',
        'product_images_id',
        'color',
        'quantity',
        'accessories',
        'acc_quantity',
        'total_price'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'shopping_basket_id');
    }

    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, 'reservation_basket_pivot', 'shopping_basket_id', 'reservation_id');
    }


}

