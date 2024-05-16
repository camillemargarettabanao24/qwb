<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingPackage extends Model
{
    use HasFactory;

    protected $table = 'wedding_package';

    protected $fillable = [
        'item',
        'description',
        'category',
        'price',
    ];

    public function images()
    {
        return $this->hasMany(WeddingPackageImage::class);
    }

    public function weddingPackageBasket()
    {
        return $this->hasMany(WeddingPackageBasket::class);
    }
}
