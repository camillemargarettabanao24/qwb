<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    use HasFactory;

    protected $table ="accessories";

    protected $fillable = [
        'name',
    ];

    // public function products()
    // {
    //     return $this->belongsToMany(Product::class,'product_accessories', 'product_id', 'accessory_id');
    // }

}
