<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingPackageImage extends Model
{
    use HasFactory;

    protected $table = 'wedding_package_images';

    protected $fillable = [
        'wedding_package_id',
        'image_path'
    ];

    
}
