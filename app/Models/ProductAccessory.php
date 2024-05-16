<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAccessory extends Model
{
    use HasFactory;

    protected $table ="product_accessories";

    protected $fillable = [
        'product_id',
        'accessory',
        'quantity',
        'price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
