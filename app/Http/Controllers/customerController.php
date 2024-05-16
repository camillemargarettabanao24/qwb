<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Exception;
use Carbon\Carbon;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Authcheck;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductColor;
use App\Models\ProductAccessory;
use App\Models\WeddingPackage;
use App\Models\WeddingPackageImage;
use App\Models\CustomerProfile;
use App\Models\Reservation;


class customerController extends Controller
{
    public function index()
    {

        $user = session('LoggedUser');

        $customer_list = Customer::where('id', $user->id)
            ->orderBy('fname', 'asc')
            ->orderBy('lname', 'asc')
            ->orderBy('username', 'asc')
            ->orderBy('email', 'asc')
            ->get();

        return view('customer-home', compact('customer_list', 'user','products'));
    }    


    public function Logout(){
        if (session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect('/customer-login');
        }
    }


    public function customer_home()
    {

        $user = session('LoggedUser');
        
        $customer_list = Customer::where('id', $user->id)
            ->orderBy('fname', 'asc')
            ->orderBy('lname', 'asc')
            ->orderBy('username', 'asc')
            ->orderBy('email', 'asc')
            ->get();

        $products = Product::with('product_colors')->get();
        
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

        //reserved dates in modal
        $reservationsCompleted = Reservation::with([
            'basket',
            'basket.product.product_colors',
            'basket.product.product_accessories', 
            'weddingPackageBasket',
            'basket.customer',
            'customer'
        ])->orderBy('created_at', 'desc')->get();


        
        return view('customer-home', compact('customer_list','products','productImages', 'weddingPackage', 'WeddingProductImages', 'reservationsCompleted'));
    }

 
public function customer_add2cart(Request $request)
{
        $user = session('LoggedUser');

        $productId = $request->route('id');
        $product = Product::find($productId);

    // selected product image
        $productImage = ProductImage::where('product_id', $productId)->first();

        $products = Product::all();

    // Organize the product images into an array by product ID
        $productImages = [];
        foreach ($products as $prod) {
            $images = ProductImage::where('product_id', $prod->id)->get();
            $productImages[$prod->id] = $images;
        }

    // product colors and accessories
        $productColors = ProductColor::where('product_id', $productId)->get();
        $productAccessories = ProductAccessory::where('product_id', $productId)->get();

    return view('customer-add2cart', compact('user', 'product', 'products', 'productImages', 'productImage', 'productColors', 'productAccessories'));
}


    
    public function customer_receipt()
    {
        return view('customer-receipt');
    }
    
    public function customer_details()
    {
        return view('customer-details');
    }

    public function customer_profile()
    {
        $customer= session('LoggedUser');
                
        return view('customer-profile', compact('customer'));
    }
        
    
    public function customer_profile_update(Request $request)
{
    try {

        $customerId = session('LoggedUser');
        // Validate the incoming request data
        $validatedData = $request->validate([
            'fname' => 'nullable|string',
            'lname' => 'nullable|string',
            'username' => 'nullable|string|unique:customers,username,' .$customerId,
            'phone_number' => 'nullable|string',
            'province' => 'nullable|string',
            'city_municipality' => 'nullable|string',
            'barangay' => 'nullable|string',
            'email' => 'nullable|string|unique:customers,email,' . $customerId,
            'new_password' => 'nullable|string|min:3|confirmed',
        ]);
        \Log::info('Validated Data:', $validatedData);

        $customer = Customer::findOrFail($customerId);
        
        // Update the customer record with the validated data
        $customer->fill($validatedData)->save();

        // Update the password if provided
        if ($request->filled('new_password')) {
            $customer->update([
                'password' => Hash::make($request->input('new_password')),
            ]);
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while updating the profile: ' . $e->getMessage());
    }
}

    
    
    
}
