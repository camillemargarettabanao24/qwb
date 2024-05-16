<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\AuthcheckStaff;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\WeddingPackage;
use App\Models\WeddingPackageImage;
use App\Models\Appointment;
use App\Models\Reservation;
use App\Models\ActivityLogs;

class staffController extends Controller
{
    
    public function index()
    {
        $userStaff = session('LoggedUserStaff'); 

        $staff_list = Staff::where('id', $userStaff->id)
            ->orderBy('fname', 'asc')
            ->orderBy('lname', 'asc')
            ->orderBy('username', 'asc')
            ->orderBy('email', 'asc')
            ->get();

        return view('staff-home', compact('staff_list', 'userStaff'));
    }    

    public function Logout_staff()
    {
        if (session()->has('LoggedUserStaff')){
            session()->pull('LoggedUserStaff');
            return redirect('/staff-login');
        }
    }

    public function staff_home()
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

        return view('staff-home', compact('products', 'productImages', 'weddingPackage', 'WeddingProductImages', 'reservations'));
    }

    public function confirm_reservations($id)
    {
        $reservation = Reservation::find($id);

            if ($reservation && $reservation->status == 'pending') {
                $reservation->status = 'Reserved';
                $reservation->save();

                // Log activity
                ActivityLogs::create([
                    'activity' => 'Reservation is confirmed',
                    'user' => session('LoggedUserStaff')->username
                ]);

                return redirect()->back()->with('success', 'Reservation marked as completed.');
            } else {
                return redirect()->back()->with('error', 'Reservation has already been confirmed.');
            }
    }

    public function decline_reservations($id)
    {
        $reservation = Reservation::find($id);

        if ($reservation && $reservation->status == 'pending') {
            $reservation->status = 'Declined';
            $reservation->save();

            // Log activity
            ActivityLogs::create([
                'activity' => 'Reservation is declined',
                'user' => session('LoggedUserStaff')->username
            ]);

            return redirect()->back()->with('success', 'Reservation declined successfully.');
        } else {
            return redirect()->back()->with('error', 'Reservation could not be declined.');
        }
    }

    public function staff_rented()
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

        return view('staff-rented', compact('products', 'productImages', 'weddingPackage', 'WeddingProductImages', 'reservations', 'isEmptyRents'));

    }

    public function confirm_rent($id)
    {
        $reservation = Reservation::find($id);
            if ($reservation) {
                $reservation->status = 'Ongoing';
                $reservation->save();

            // Log activity
                ActivityLogs::create([
                    'activity' => 'Confirmed reservation is rented',
                    'user' => session('LoggedUserStaff')->username
                ]);

                foreach ($reservation->basket as $basket) {
                    if ($basket->color) {
                        // Iterate over all product colors of the current product
                        foreach ($basket->product->product_colors as $productColor) {
                            // Check if the color of the product color matches the color of the basket item
                            if ($productColor->color === $basket->color) {
                                // If a match is found, decrease the quantity of that product color by the quantity specified in the basket item
                                $productColor->quantity -= $basket->quantity;
                                $productColor->save();
                                
                                // Break the loop since we found the matching color
                                break;
                            }
                        }
                    }
                }
                

                return redirect()->back()->with('success', 'Reservation confirmed as rented.');
            } else {
                return redirect()->back()->with('error', 'Reservation not found.');
            }
    }

    public function confirm_return($id)
    {
        $reservation = Reservation::find($id);
            if ($reservation) {
                $reservation->status = 'Returned';
                $reservation->save();

                // Log activity
                ActivityLogs::create([
                    'activity' => 'Rented item is returned',
                    'user' => session('LoggedUserStaff')->username
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

    public function staff_products()
    {
        return view('staff-products');
    }

    public function staff_appointments()
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

        return view('staff-appointments', compact('products', 'productImages', 'weddingPackage', 'WeddingProductImages', 'appointments'));
    }

    public function appointments_completed($id)
    {
        $appointment = Appointment::find($id);

        $appointment->status = 'completed';
        $appointment->save();

        // Log activity
        ActivityLogs::create([
            'activity' => 'Appointment is marked "completed"',
            'user' => session('LoggedUserStaff')->username
        ]);

        return redirect()->back()->with('success', 'Appointment marked as completed.');
    }

    public function staff_profile()
    {
        $userStaff = session('LoggedUserStaff');

        return view('staff-profile', compact('userStaff'));
    }

    public function staff_profile_update(Request $request)
{
    try {
        $staffId = session('LoggedUserStaff'); // Retrieve the logged-in staff ID from session

        // Validate the incoming request data
        $validatedData = $request->validate([
            'fname' => 'nullable|string',
            'lname' => 'nullable|string',
            'username' => 'nullable|string',
            'email' => 'nullable|string|email',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Find the staff record
        $userStaff = Staff::findOrFail($staffId);


        // Update the staff record with the validated data
        $userStaff->fname = $validatedData['fname'];
        $userStaff->lname = $validatedData['lname'];
        $userStaff->username = $validatedData['username'];
        $userStaff->email = $validatedData['email'];

        // Update the password if provided
        if (!empty($validatedData['new_password'])) {
            $userStaff->password = Hash::make($validatedData['new_password']);
        }

        // Save the updated staff data
        $userStaff->save();

        // Log activity
        ActivityLogs::create([
            'activity' => 'Updated their profile',
            'user' => session('LoggedUserStaff')
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while updating the profile: ' . $e->getMessage());
    }
}


}