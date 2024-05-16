<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\AuthcheckAdmin;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Color;
use App\Models\Accessory;
use App\Models\ProductImage;
use App\Models\WeddingPackage;
use App\Models\WeddingPackageImage;
use App\Models\Appointment;
use App\Models\Reservation;
use App\Models\ActivityLogs;

class adminController extends Controller
{
    public function index(){
        
        $userAdmin = session('LoggedUserAdmin');
    
        $admin_list = Admin::where('id', $userAdmin->id)
            ->orderBy('fname', 'asc')
            ->orderBy('lname', 'asc')
            ->orderBy('username', 'asc')
            ->orderBy('email', 'asc')
            ->get();
    
        return view('admin-home', compact('admin_list', 'userAdmin'));
    }    
    
    
    
        public function Logout_admin(){
        if (session()->has('LoggedUserAdmin')){
            session()->pull('LoggedUserAdmin');
            return redirect('/admin-login');
        }
    }
    
    public function admin_home()
    {
            {
                $products = Product::with('product_colors','product_accessories')->get();
        
                    // Fetch the first image for each product
                    $productImages = [];
                    foreach ($products as $product) {
                        $firstImage = ProductImage::where('product_id', $product->id)->first();
                        if ($firstImage) {
                            $productImages[$product->id] = $firstImage;
                        }
                    }
        
                    $weddingPackage = WeddingPackage::all();
        
                    // display first wedding product images
                    $WeddingProductImages = [];
                    foreach ($weddingPackage as $weddingPackageItem) {
                        $firstWPImage = WeddingPackageImage::where('wedding_package_id', $weddingPackageItem->id)->first();
                        if ($firstWPImage) {
                            $WeddingProductImages[$weddingPackageItem->id] = $firstWPImage;
                        }
                    }
        
                    $reservationsPending = Reservation::with([
                        'basket',
                        'basket.product.product_colors',
                        'basket.product.product_accessories', 
                        'weddingPackageBasket',
                        'basket.customer',
                        'customer'
                    ])->where('status', 'pending')->orderBy('created_at', 'desc')->get();
        
                    $reservationsCompleted = Reservation::with([
                        'basket',
                        'basket.product.product_colors',
                        'basket.product.product_accessories', 
                        'weddingPackageBasket',
                        'basket.customer',
                        'customer'
                    ])->where('status', 'Reserved')->orderBy('created_at', 'desc')->get();
                    
                    $reservationsDeclined = Reservation::with([
                        'basket',
                        'basket.product.product_colors',
                        'basket.product.product_accessories', 
                        'weddingPackageBasket',
                        'basket.customer',
                        'customer'
                    ])->where('status', 'Declined')->orderBy('created_at', 'desc')->get();
        
        
                    // Combine the two reservation groups
                    $reservations = $reservationsPending->concat($reservationsCompleted)->concat($reservationsDeclined);
        
                return view('admin-home', compact('products', 'productImages', 'weddingPackage', 'WeddingProductImages', 'reservations'));
            }
    }
    
    public function admin_rented()
    {
        $userAdmin = session('LoggedUserManager'); 

                $products = Product::with('product_colors','product_accessories')->get();

            // Fetch the first image for each product
            $productImages = [];
            foreach ($products as $product) {
                $firstImage = ProductImage::where('product_id', $product->id)->first();
                if ($firstImage) {
                    $productImages[$product->id] = $firstImage;
                }
            }

            $weddingPackage = WeddingPackage::all();

            // display first wedding product images
            $WeddingProductImages = [];
            foreach ($weddingPackage as $weddingPackageItem) {
                $firstWPImage = WeddingPackageImage::where('wedding_package_id', $weddingPackageItem->id)->first();
                if ($firstWPImage) {
                    $WeddingProductImages[$weddingPackageItem->id] = $firstWPImage;
                }
            }

            $reservationOngoing = Reservation::with([
                'basket',
                'basket.product.product_colors',
                'basket.product.product_accessories', 
                'weddingPackageBasket',
                'basket.customer',
                'customer'
            ])->where('status', 'Ongoing')->orderBy('created_at', 'desc')->get();
            
            $reservationReturned = Reservation::with([
                'basket',
                'basket.product.product_colors',
                'basket.product.product_accessories', 
                'weddingPackageBasket',
                'basket.customer',
                'customer'
            ])->where('status', 'Returned')->orderBy('created_at', 'desc')->get();

            $reservations = $reservationOngoing->concat($reservationReturned);

            $isEmptyRents = $reservations->isEmpty();

        return view('admin-rented', compact('products', 'productImages', 'weddingPackage', 'WeddingProductImages', 'reservations', 'isEmptyRents', 'userAdmin'));

    }

    public function admin_products(){ 

        $products = Product::with('product_colors','product_accessories')
                            ->get();

        // Fetch the first image for each product
        $productImages = [];
            foreach ($products as $product) {
                $firstImage = ProductImage::where('product_id', $product->id)->first();
                if ($firstImage) {
                    $productImages[$product->id] = $firstImage;
                }
        }    

        $weddingPackage = WeddingPackage::all();

         // display first wedding product images
         $WeddingProductImages = [];
         foreach ($weddingPackage as $weddingPackageItem) {
             $firstWPImage = WeddingPackageImage::where('wedding_package_id', $weddingPackageItem->id)->first();
             if ($firstWPImage) {
                 $WeddingProductImages[$weddingPackageItem->id] = $firstWPImage;
             }
         }

        return view('admin-products', compact('products','productImages', 'weddingPackage', 'WeddingProductImages'));
    }


    
    public function admin_appointments(){
        $products = Product::with('product_colors','product_accessories')
        ->get();

        // Fetch the first image for each product
        $productImages = [];
            foreach ($products as $product) {
                $firstImage = ProductImage::where('product_id', $product->id)->first();
                    if ($firstImage) {
                        $productImages[$product->id] = $firstImage;
                    }
            }    

        $weddingPackage = WeddingPackage::all();

        // display first wedding product images
        $WeddingProductImages = [];
            foreach ($weddingPackage as $weddingPackageItem) {
                $firstWPImage = WeddingPackageImage::where('wedding_package_id', $weddingPackageItem->id)->first();
                    if ($firstWPImage) {
                        $WeddingProductImages[$weddingPackageItem->id] = $firstWPImage;
                    }
            }

        $appointments = Appointment::
                with(['basket','basket.product.product_colors',
                'basket.product.product_accessories', 
                'weddingPackageBasket',
                'basket.customer',
                'customer'
                ])->get();



        return view('admin-appointments', compact('products','productImages', 'weddingPackage', 'WeddingProductImages','appointments'));
    }


    public function admin_profile(){
        
        $userAdmin = session('LoggedUserAdmin');

        return view('admin-profile', compact('userAdmin'));    
    }

    public function activity_logs(){
        
        $activityLogs = ActivityLogs::all();

            return view('admin-activity-logs', compact('activityLogs'));
    }

    public function admin_reports()
    {
        // Get the current year
        $year = date('Y');

        // Retrieve only reservations created in May of the current year
        $reservations = Reservation::
            whereYear('created_at', $year)
            ->whereMonth('created_at', 5)
            ->with('customer')
            ->get();

            $pendingCount = Reservation::where('status', 'Pending')->count();
            $reservedCount = Reservation::where('status', 'Reserved')->count();
            $ongoingCount = Reservation::where('status', 'Ongoing')->count();
            $returnedCount = Reservation::where('status', 'Returned')->count();
            $declinedCount = Reservation::where('status', 'Declined')->count();
    
        $data = [
            'title' => 'Reserved Items for the month of May ' . $year,
            'date' => date('F d, Y'),
            'reservations' => $reservations,
            'reservedCount' => $reservedCount,
            'pendingCount' => $pendingCount,
            'ongoingCount' => $ongoingCount,
            'returnedCount' => $returnedCount,
            'declinedCount' => $declinedCount,
            'street' => 'Lower Luke Wright Street',
            'city' => 'Dumaguete City',
            'province' => 'Negros Oriental',
            'postal_code' => '6200',
            'companyName' => 'Q Wedding Boutique'
        ];

        $pdf = PDF::loadView('admin-reports', $data);
        return $pdf->download('Report as of the month of MAY 2024.pdf');
    }


}
