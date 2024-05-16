<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\AuthcheckManager;
use Illuminate\Support\Facades\Hash;
use App\Models\Manager;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\WeddingPackage;
use App\Models\WeddingPackageImage;
use App\Models\Appointment;
use App\Models\Reservation;
use App\Models\ActivityLogs;

class managerController extends Controller
{
    
    public function index()
    {
        $userManager = session('LoggedUserManager'); 

        $manager_list = Manager::where('id', $userManager->id)
            ->orderBy('fname', 'asc')
            ->orderBy('lname', 'asc')
            ->orderBy('username', 'asc')
            ->orderBy('email', 'asc')
            ->get();

        return view('manager', compact('manager_list', 'userManager'));
    }    

    public function Logout_manager()
    {
        if (session()->has('LoggedUserManager')){
            session()->pull('LoggedUserManager');
            return redirect('/manager-login');
        }
    }

    public function manager_home()
    {

        $userManager = session('LoggedUserManager'); 

        $manager_list = Manager::where('id', $userManager->id)
            ->orderBy('fname', 'asc')
            ->orderBy('lname', 'asc')
            ->orderBy('username', 'asc')
            ->orderBy('email', 'asc')
            ->get();

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

        return view('manager-home', compact('products', 'productImages', 'weddingPackage', 'WeddingProductImages', 'reservations', 'manager_list', 'userManager'));
    }

    public function manager_confirm_reservations($id)
    {
        $reservation = Reservation::find($id);

            if ($reservation && $reservation->status == 'pending') {
                $reservation->status = 'Reserved';
                $reservation->save();

                // Log activity
                ActivityLogs::create([
                    'activity' => 'Reservation is confirmed',
                    'user' => session('LoggedUserManager')->username
                ]);

                return redirect()->back()->with('success', 'Reservation marked as completed.');
            } else {
                return redirect()->back()->with('error', 'Reservation has already been confirmed.');
            }
    }

    public function manager_decline_reservations($id)
    {
        $reservation = Reservation::find($id);

        if ($reservation && $reservation->status == 'pending') {
            $reservation->status = 'Declined';
            $reservation->save();

            // Log activity
            ActivityLogs::create([
                'activity' => 'Reservation is declined',
                'user' => session('LoggedUserManager')->username
            ]);

            return redirect()->back()->with('success', 'Reservation declined successfully.');
        } else {
            return redirect()->back()->with('error', 'Reservation could not be declined.');
        }
    }

    public function manager_rented()
    {
        $userManager = session('LoggedUserManager'); 

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

        return view('manager-rented', compact('products', 'productImages', 'weddingPackage', 'WeddingProductImages', 'reservations', 'isEmptyRents', 'userManager'));

    }

    public function manager_confirm_rent($id)
    {
        $reservation = Reservation::find($id);
            if ($reservation) {
                $reservation->status = 'Ongoing';
                $reservation->save();

                // Log activity
                ActivityLogs::create([
                    'activity' => 'Confirmed reservation is rented',
                    'user' => session('LoggedUserManager')->username
                ]);

                foreach ($reservation->basket as $basket) {
                    if ($basket->color) {
                        $productColor = $basket->product->product_colors->firstWhere('color', $basket->color);
                        
                        if ($productColor) {
                            $productColor->quantity -= $basket->quantity;
                            $productColor->save();
                        }
                    }
                }

                return redirect()->back()->with('success', 'Reservation confirmed as rented.');
            } else {
                return redirect()->back()->with('error', 'Reservation not found.');
            }
    }

    public function manager_confirm_return($id)
    {
        $reservation = Reservation::find($id);
            if ($reservation) {
                $reservation->status = 'Returned';
                $reservation->save();

                // Log activity
                ActivityLogs::create([
                    'activity' => 'Rented item is returned',
                    'user' => session('LoggedUserManager')->username
                ]);

        // Restore quantity to product colors
        foreach ($reservation->basket as $basket) {
            if ($basket->product->product_colors->isNotEmpty()) {
                foreach ($basket->product->product_colors as $color) {
                    $color->quantity += $basket->quantity;
                    $color->save();
                }
            }
        }


                return redirect()->back()->with('success', 'Reservation confirmed as returned.');
            } else {
                return redirect()->back()->with('error', 'Reservation not found.');
            }
    }

    public function manager_products()
    {
        $userManager = session('LoggedUserManager');
        return view('manager-products', compact('userManager'));
    }

    public function manager_appointments()
    {
        $userManager = session('LoggedUserManager'); 

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

        $appointmentsPending = Appointment::with([
            'basket',
            'basket.product.product_colors',
            'basket.product.product_accessories', 
            'weddingPackageBasket',
            'basket.customer',
            'customer'
        ])->where('status', 'pending')->get();

        $appointmentsCompleted = Appointment::with([
            'basket',
            'basket.product.product_colors',
            'basket.product.product_accessories', 
            'weddingPackageBasket',
            'basket.customer',
            'customer'
        ])->where('status', 'completed')->get();

        // Combine the two appointment groups
        $appointments = $appointmentsPending->concat($appointmentsCompleted);

        return view('manager-appointments', compact('products', 'productImages', 'weddingPackage', 'WeddingProductImages', 'appointments', 'userManager'));
    }

    public function manager_appointments_completed($id)
    {
        $appointment = Appointment::find($id);

        $appointment->status = 'completed';
        $appointment->save();

        // Log activity
        ActivityLogs::create([
            'activity' => 'Appointment is marked "completed"',
            'user' => session('LoggedUserManager')->username
        ]);

        return redirect()->back()->with('success', 'Appointment marked as completed.');
    }

    public function manager_profile()
    {
        
        return view('manager-profile');
    }

    
    public function reports()
    {
        $userManager = session('LoggedUserManager'); 
    
        $pendingCount = Reservation::where('status', 'Pending')->count();
        $reservedCount = Reservation::where('status', 'Reserved')->count();
        $ongoingCount = Reservation::where('status', 'Ongoing')->count();
        $returnedCount = Reservation::where('status', 'Returned')->count();
        $declinedCount = Reservation::where('status', 'Declined')->count();
    
        return view('reports', compact('userManager', 'pendingCount', 'reservedCount', 'ongoingCount', 'returnedCount', 'declinedCount'));
    }
    

    public function reports_reserved()
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

        $pdf = PDF::loadView('reports-reserved', $data);
        return $pdf->download('Report as of the month of MAY 2024.pdf');
    }



   

}