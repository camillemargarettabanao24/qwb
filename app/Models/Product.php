<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'item',
        'description',
        'category',
        'stock',
        'price'
    ];

    public function product_colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function product_accessories()
    {
        return $this->hasMany(ProductAccessory::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
