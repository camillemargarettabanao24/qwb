<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductColor;
use App\Models\ProductAccessory;
use App\Models\WeddingPackage;
use App\Models\WeddingPackageImage;


class dashboardController extends Controller
{
    public function index(){
        $user = session('LoggedUser');
        
    
        $products = Product::all();
    
    //all product images
        $productImages = [];
        foreach ($products as $product) {
            $firstImage = ProductImage::where('product_id', $product->id)->first();
            if ($firstImage) {
                $productImages[$product->id] = $firstImage;
            }
        }
    
    // wedding package
        $weddingPackage = WeddingPackage::all();

    
    // display first wedding product images
        $WeddingProductImages = [];
        foreach ($weddingPackage as $weddingPackageItem) {
            $firstWPImage = WeddingPackageImage::where('wedding_package_id', $weddingPackageItem->id)->first();
            if ($firstWPImage) {
                $WeddingProductImages[$weddingPackageItem->id] = $firstWPImage;
            }
        }

    return view('dashboard', compact('products','productImages', 'weddingPackage', 'WeddingProductImages'));
}

}
