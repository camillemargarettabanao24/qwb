<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Http\Request;
use Carbon\Carbon; 
use App\Models\Basket;
use App\Models\WeddingPackage;
use App\Models\WeddingPackageBasket;
use App\Models\WeddingPackageImage;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Reservation;
use DateTime; 

class reservationsController extends Controller
{
    public function reservation_create(Request $request)
    {
        
        $customerId = session('LoggedUser');

        $itemIds = $request->query('itemIds');
        $selectedItemIds = explode(',', $itemIds);

            $basketItems = Basket::with(['product','product.images'])
                                    ->whereIn('id', $selectedItemIds)->get();
            $productImages = [];

                foreach ($basketItems as $item) {
                    if ($item->product->images->isNotEmpty()) {
                        $productImages[$item->product->id] = $item->product->images->first();
                    }
                }
                
            $wpItems = WeddingPackageBasket::with('weddingPackage','weddingPackageImage')
                                    ->whereIn('id', $selectedItemIds)->get();

            //reservation dates
            $reservationsCompleted = Reservation::with([
                'basket',
                'basket.product.product_colors',
                'basket.product.product_accessories', 
                'weddingPackageBasket',
                'basket.customer',
                'customer'
            ])->orderBy('created_at', 'desc')->get();
                            

            return view('reservation-create', compact('customerId','basketItems', 'wpItems','productImages', 'reservationsCompleted'));
    }

    public function reservation_selection(Request $request)
    {
        $selectedItems = $request->input('selectedItems');
        $buttonClicked = $request->input('buttonClicked');
        $redirectUrl = ($buttonClicked === 'reservation') ?  '/reservation-create' : '/appointment-create';

        return response()->json(['selectedItems' => $selectedItems, 'redirectUrl' => $redirectUrl]);
    }

    public function reservation_store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'customer_id' => 'required|exists:customers,id', 
    
                'total_res_price' => 'required|numeric',
                'payment_deposit' => 'required|string',
    
                'payment_method' => 'required|string',
                'account_name' => 'nullable|string',
                'account_number' => 'nullable|string',
                'image_path' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
                'status' => 'required|string',
    
                'reservation_time' => 'required|string',
                'reservation_date' => 'required|date',
    
                'confirmation' => 'required|string',

                'shopping_basket_id' => 'nullable|array',
                'wp_basket_id' => 'nullable|array',
            ]);
    
            $reservation = new Reservation();
    
            $reservation->customer_id = $validatedData['customer_id'];
    
            $reservation->payment_deposit = $validatedData['payment_deposit'];
            $reservation->payment_method = $validatedData['payment_method'];
            $reservation->account_name = $validatedData['account_name'];
            
            if ($request->hasFile('image_path')) {
                $image = $request->file('image_path');
                $fileName = time() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('public', $fileName); 
                $reservation->image_path = 'storage/' . $fileName; 
            } else {
                $reservation->image_path = null; 
            }
            
            $reservation->status = $validatedData['status'];
            $reservation->reservation_time = $validatedData['reservation_time'];
            $reservation->confirmation = $validatedData['confirmation'];
    
            $reservationDate = Carbon::createFromFormat('F j, Y', $validatedData['reservation_date'], 'Asia/Singapore')
            ->startOfDay() // Set time to the beginning of the day in Singapore timezone
            ->toDateString(); // Format as YYYY-MM-DD
        
            $reservation->reservation_date = $reservationDate;
            $reservation->account_number = str_replace(',', '', $validatedData['account_number']);
            $reservation->total_res_price = floatval($validatedData['total_res_price']);
    
            $reservation->save();
    
            $reservationId = $reservation->id;
    
            // Attach shopping baskets to the reservation if provided
            if (isset($validatedData['shopping_basket_id'])) {
                $reservation->basket()->attach($validatedData['shopping_basket_id'], ['reservation_id' => $reservationId]);
            }

            // Attach wedding package baskets to the reservation if provided
            if (isset($validatedData['wp_basket_id'])) {
                $reservation->weddingPackageBasket()->attach($validatedData['wp_basket_id'], ['reservation_id' => $reservationId]);
            }
    
            return redirect('customer-reservations')->with('reservation_id', $reservationId);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error in reservation_store: ' . $e->getMessage());
            // Return an error response or redirect to a specific page with a flash message
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function customer_reservations()
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
            
        // Retrieve reservations for the customer
            $reservations = Reservation::where('customer_id', $customerId->id)
                ->with(['basket', 'weddingPackageBasket'])
                ->orderBy('created_at', 'desc')
                ->get();        

                $isEmptyReservation = $reservations->isEmpty();

            return view('customer-reservations',compact('customerId','basketItems', 'wpItems','productImages','reservations','isEmptyReservation'));
    }

   
}
