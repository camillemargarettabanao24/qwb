<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Basket;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\WeddingPackageImage;
use App\Models\WeddingPackageBasket;
use App\Models\WeddingPackage;
use App\Models\ProductColor;
use App\Models\ProductAccessory;
use App\Models\Reservation;
 
class ShoppingBasketController extends Controller
{
    public function shopping_basket(Request $request)
{   
    $customerId = session('LoggedUser');
    
    $basketItems = Basket::where('customer_id', $customerId->id)
        ->whereDoesntHave('reservations', function ($query) {
            $query->where('status', 'Reserved');
        })
        ->latest('id')
        ->with(['product', 'product.images'])
        ->get();

    $wpItems = WeddingPackageBasket::where('customer_id', $customerId->id)
        ->whereDoesntHave('reservations', function ($query) {
            $query->where('status', 'Reserved');
        })
        ->latest('id')
        ->with('weddingPackage', 'weddingPackageImage')
        ->get();


    $products = Product::with(['images', 'product_colors' => function($query) {
        $query->select('product_id', 'color');
    }])->get();

    $productImages = [];
    $productColors = [];
    $productAccessories = [];

    foreach ($basketItems as $item) {
        // Check if $item->product is not null and if it has images
        if ($item->product && $item->product->images->isNotEmpty()) {
            $productImages[$item->product->id] = $item->product->images->first();
        }
    }
    
    // Fetch all colors and accessories for all products in the basket in a single query
    $productIds = $basketItems->pluck('product_id')->unique();
    $productColors = ProductColor::whereIn('product_id', $productIds)->get()->groupBy('product_id');
    $productAccessories = ProductAccessory::whereIn('product_id', $productIds)->get()->groupBy('product_id');

    $productColorsByCategory = [];

    foreach ($products as $product) {
        foreach ($product->product_colors as $color) {
            $productColorsByCategory[$product->category][] = $color->color;
        }
    }
    
    $isEmptyBasket = $basketItems->isEmpty();
    $isEmptyWPBasket = $wpItems->isEmpty();


    return view('shopping-basket', compact('customerId', 'basketItems', 'productImages', 'products', 'wpItems', 'productColors', 'productAccessories', 'productColorsByCategory','isEmptyWPBasket','isEmptyBasket'));
}


    public function addToBasket(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|integer',
            'product_id' => 'required|integer',
            'product_images_id' => 'required|integer',
            'color' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'accessories' => 'nullable|string',
            'acc_quantity' => 'nullable|integer',
            'total_price' => 'required|numeric|min:0'
        ]);

        // Retrieve input data
        $customerId = $validatedData['customer_id'];
        $productId = $validatedData['product_id'];
        $selectedColor = $validatedData['color'];
        $quantityToAdd = $validatedData['quantity'];
        $accessories = $validatedData['accessories'];
        $accQuantity = $validatedData['acc_quantity'];

        $product = Product::findOrFail($productId);

        $selectedColorDetails = $product->product_colors()->where('color', $selectedColor)->first();

        if (!$selectedColorDetails) {
            return redirect()->back()->with('error', 'Selected color not found for this product');
        }

        $basketItem = Basket::where('customer_id', $customerId)
            ->where('product_id', $productId)
            ->where('color', $selectedColor)
            ->first();

        if ($basketItem) {
            $newQuantity = $basketItem->quantity + $quantityToAdd;

            // Check if the new quantity exceeds the available stock
            if ($newQuantity > $selectedColorDetails->quantity) {
                return redirect()->back()->with('error', 'Quantity exceeds available stock for this product color');
            }

            // Update the quantity in the basket item
            $basketItem->update(['quantity' => $newQuantity]);
        } else {
            // Product does not exist in the basket, add it
            $basketItem = Basket::create([
                'customer_id' => $customerId,
                'product_id' => $productId,
                'product_images_id' => $validatedData['product_images_id'],
                'color' => $selectedColor,
                'quantity' => $quantityToAdd,
                'accessories' => $accessories,
                'acc_quantity' => $accQuantity,
                'total_price' => $validatedData['total_price'],
            ]);
        }

        return redirect()->route('shopping-basket')->with('success', 'Product added to basket successfully');
    }



    public function updateBasketItem(Request $request)
    {
        $customerId = session('LoggedUser')->id;

        // Loop through the submitted data and update basket items
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'color_quantity_') === 0) {
                // Extracting the product ID from the key
                $productId = explode('_', $key)[2];
                // Extract other necessary data
                $productImagesId = $request->input('product_images_id_' . $productId);
                $totalPrice = str_replace(['₱', ','], '', $request->input('total_price_' . $productId));

                // Update or create basket item for color
                Basket::updateOrCreate(
                    ['product_id' => $productId, 'customer_id' => $customerId],
                    [
                        'quantity' => $value,
                        'color' => $request->input('color_' . $productId),
                        'product_images_id' => $productImagesId,
                        'total_price' => $totalPrice
                    ]
                );
            } elseif (strpos($key, 'accessory_quantity_') === 0) {
                // Extracting the product ID from the key
                $productId = explode('_', $key)[2];
                // Extract other necessary data
                $productImagesId = $request->input('product_images_id_' . $productId);
                $totalPrice = str_replace(['₱', ','], '', $request->input('total_price_' . $productId));

                // Update or create basket item for accessory
                Basket::updateOrCreate(
                    ['product_id' => $productId, 'customer_id' => $customerId],
                    [
                        'acc_quantity' => $value,
                        'accessories' => $request->input('accessory_' . $productId),
                        'product_images_id' => $productImagesId,
                        'total_price' => $totalPrice
                    ]
                );
            }
        }

        // Redirect back to the shopping basket page after updating the items
        return redirect()->route('shopping-basket')->with('success', 'Basket updated successfully');
    }




    public function deleteFromBasket($id)
    {
        $basketItem = Basket::find($id);

        if (!$basketItem) {
            return response()->json(['message' => 'Basket item not found'], 404);
        }

        $basketItem->delete();

        return response()->json(['message' => 'Basket item deleted successfully'], 200);
    }
}
