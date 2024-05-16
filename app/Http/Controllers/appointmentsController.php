<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basket;
use App\Models\WeddingPackage;
use App\Models\WeddingPackageBasket;
use App\Models\WeddingPackageImage;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Appointment;
use DateTime;

 

class appointmentsController extends Controller
{
    public function appointment_create(Request $request)
    {
        $customerId = session('LoggedUser');

        $itemIds = $request->query('itemIds');
        $selectedItemIds = explode(',', $itemIds);

            $basketItems = Basket::with(['product','product.images'])
                                    ->whereIn('id', $selectedItemIds)->get();
            // Populate $productImages array with product images
            $productImages = [];

                foreach ($basketItems as $item) {
                    if ($item->product->images->isNotEmpty()) {
                        $productImages[$item->product->id] = $item->product->images->first();
                    }
                }

                
            $wpItems = WeddingPackageBasket::with('weddingPackage','weddingPackageImage')
                                    ->whereIn('id', $selectedItemIds)->get();

            return view('appointment-create', compact('customerId','basketItems', 'wpItems','productImages'));
    }


    public function appointment_selection(Request $request)
    {
        $selectedItems = $request->input('selectedItems');
        $buttonClicked = $request->input('buttonClicked');
        $redirectUrl = ($buttonClicked === 'appointment') ? '/appointment-create' : '/reservation-create';

            return response()->json(['selectedItems' => $selectedItems, 'redirectUrl' => $redirectUrl]);
    }


    public function appointment_store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id', 
            'shopping_basket_id' => 'nullable|array', 
            'wp_basket_id' => 'nullable|array', 
            'total_app_price' => 'required|numeric',
            'phone_number' => 'required|string',
            'province' => 'required|string',
            'city_municipality' => 'required|string',
            'barangay' => 'required|string',
            'appointment_time' => 'required|string',
            'appointment_date' => 'required|date',
            'confirmation' => 'required|string',
        ]);
    
        $appointment = new Appointment();
    
        $appointment->customer_id = $validatedData['customer_id'];
        $appointment->phone_number = $validatedData['phone_number'];
        $appointment->province = $validatedData['province'];
        $appointment->city_municipality = $validatedData['city_municipality'];
        $appointment->barangay = $validatedData['barangay'];
        $appointment->appointment_time = $validatedData['appointment_time'];
        $appointment->confirmation = $validatedData['confirmation'];
    
        $appointmentDateTime = new \DateTime($validatedData['appointment_date']);
        $formattedAppointmentDate = $appointmentDateTime->format('Y-m-d');
        $appointment->appointment_date = $formattedAppointmentDate;
        
        $totalPrice = floatval($validatedData['total_app_price']);
        $appointment->total_app_price = $totalPrice;
        
        $appointment->save();

        $appointmentId = $appointment->id;

        // Attach shopping baskets to the appointment if provided
        if (isset($validatedData['shopping_basket_id'])) {
            $appointment->basket()->attach($validatedData['shopping_basket_id'], ['appointment_id' => $appointmentId]);
        }

        // Attach wedding package baskets to the appointment if provided
        if (isset($validatedData['wp_basket_id'])) {
            $appointment->weddingPackageBasket()->attach($validatedData['wp_basket_id'], ['appointment_id' => $appointmentId]);
        }

        return redirect('customer-appointments')->with('appointment_id', $appointmentId);
    }
    

    public function customer_appointments()
    {
        $customerId = session('LoggedUser');

        $basketItems = Basket::where('customer_id', $customerId->id)
        ->orderBy('color', 'asc')
        ->orderBy('quantity', 'asc')
        ->orderBy('accessories', 'asc')
        ->orderBy('acc_quantity', 'asc')
        ->orderBy('total_price', 'asc')
        ->with(['product', 'product.images'])
        ->get();
    
        $wpItems = WeddingPackageBasket::where('customer_id', $customerId->id)
        ->orderBy('bride_gown', 'asc')
        ->orderBy('bride_color', 'asc')
        
        ->orderBy('groom_suit', 'asc')
        ->orderBy('groom_color', 'asc')
        
        ->orderBy('maid_of_honor', 'asc')
        ->orderBy('moh_color', 'asc')
        
        ->orderBy('bestman', 'asc')
        ->orderBy('bestman_color', 'asc')
        
        ->orderBy('bridesmaid_set', 'asc')
        ->orderBy('bridesmaid_set_color', 'asc')
        
        ->orderBy('groomsmen_set', 'asc')
        ->orderBy('groomsmen_set_color', 'asc')
        
        ->orderBy('bearers_set', 'asc')
        ->orderBy('bearers_set_color', 'asc')
        
        ->orderBy('flowerG_set', 'asc')
        ->orderBy('flowerG_set_color', 'asc')
        
        ->orderBy('bride_father', 'asc')
        ->orderBy('bride_father_color', 'asc')
        
        ->orderBy('groom_father', 'asc')
        ->orderBy('groom_father_color', 'asc')
        
        ->orderBy('bride_mother', 'asc')
        ->orderBy('bride_mother_color', 'asc')
        
        ->orderBy('groom_mother', 'asc')
        ->orderBy('groom_mother_color', 'asc')
        
        ->with('weddingPackage', 'weddingPackageImage')
        ->get();

                // Populate $productImages array with product images
            $productImages = [];

                foreach ($basketItems as $item) {
                    if ($item->product->images->isNotEmpty()) {
                        $productImages[$item->product->id] = $item->product->images->first();
                    }
                }
            
        // Retrieve appointments for the customer
            $appointments = Appointment::where('customer_id', $customerId->id)
                ->with(['basket', 'weddingPackageBasket'])
                ->latest('id')
                ->get();        

                $isEmptyAppointment = $appointments->isEmpty();

            return view('customer-appointments',compact('customerId','basketItems', 'wpItems','productImages','appointments','isEmptyAppointment'));
    }
}

