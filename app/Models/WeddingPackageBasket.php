<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class WeddingPackageBasket extends Model
{
    use HasFactory;

    protected $table = 'wedding_package_shopping_basket';

    protected $fillable = [

        'customer_id',
        'wedding_package_id',
        'wedding_package_images_id',

        'bride_gown',
        'bride_color',

        'groom_suit',
        'groom_color',

        'maid_of_honor',
        'moh_color',

        'bestman',
        'bestman_color',

        'bridesmaid_set',
        'bridesmaid_set_color',

        'groomsmen_set',
        'groomsme_set_color',

        'bearers_set',
        'bearers_set_color',

        'flowerG_set',
        'flowerG_set_color',

        'bride_father',
        'bride_father_color',

        'groom_father',
        'groom_father_color',

        'bride_mother',
        'bride_mother_color',

        'groom_mother',
        'groom_mother_color'
    
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function weddingPackage()
    {
        return $this->belongsTo(WeddingPackage::class, 'wedding_package_id');
    }

    public function weddingPackageImage()
    {
        return $this->belongsTo(WeddingPackageImage::class, 'wedding_package_images_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'wp_basket_id');
    }

    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, 'reservation_wedding_package_basket_pivot', 'wp_basket_id', 'reservation_id');
    }

}
