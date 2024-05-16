<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeddingPackageBasket;
use Illuminate\Support\Str; 



class WPBasketController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'wedding_package_id' => 'required|exists:wedding_package,id',
            'wedding_package_images_id' => 'required|exists:wedding_package_images,id',
            'selected_colors' => 'required|array',
        ]);
    
            $basketItem = new WeddingPackageBasket();
                $basketItem->customer_id = $request->customer_id;
                $basketItem->wedding_package_id = $request->wedding_package_id;
                $basketItem->wedding_package_images_id = $request->wedding_package_images_id;
    
        // Loop through the selected colors
        foreach ($request->selected_colors as $category => $selectedColors) {
            // Extract product names and colors from the selected colors
            $productNames = $request->product_names[$category];
            
            // Check if $selectedColors is a string, and convert it to an array if necessary
            if (!is_array($selectedColors)) {
                $selectedColors = [$selectedColors]; 
            }
    
            switch ($category) {
                case 'Bridesmaid':
                    $basketItem->bridesmaid_set = $productNames;
                    $basketItem->bridesmaid_set_color = implode(', ', $selectedColors);
                    break;
                case 'Men Suit':
                    $basketItem->groom_suit = $productNames;
                    $basketItem->groom_color = implode(', ', $selectedColors);
                    break;
                case 'Wedding Gown':
                    $basketItem->bride_gown = $productNames;
                    $basketItem->bride_color = implode(', ', $selectedColors);
                    break;
                case 'Maid Of Honor':
                    $basketItem->maid_of_honor = $productNames;
                    $basketItem->moh_color = implode(', ', $selectedColors);
                    break;
                case 'Bestman Vest':
                    $basketItem->bestman = $productNames;
                    $basketItem->bestman_color = implode(', ', $selectedColors);
                    break;
                case 'Groomsmen Suspender':
                    $basketItem->groomsmen_set = $productNames;
                    $basketItem->groomsmen_set_color = implode(', ', $selectedColors);
                    break;
                case 'Bearers Suspender':
                    $basketItem->bearers_set = $productNames;
                    $basketItem->bearers_set_color = implode(', ', $selectedColors);
                    break;
                case 'Flower Girl':
                    $basketItem->flowerG_set = $productNames;
                    $basketItem->flowerG_set_color = implode(', ', $selectedColors);
                    break;
                case 'Barong':
                    if (count($selectedColors) > 1) {
                        $basketItem->groom_father_color = $selectedColors[1];
                    }
                    if (count($selectedColors) > 0) {
                        $basketItem->bride_father_color = $selectedColors[0];
                    }
                        $basketItem->groom_father = $productNames;
                        $basketItem->bride_father = $productNames;
                    break;
                case 'Mother Dress':
                    if (count($selectedColors) > 1) {
                        $basketItem->groom_mother_color = $selectedColors[1];
                    }
                    if (count($selectedColors) > 0) {
                        $basketItem->bride_mother_color = $selectedColors[0];
                    }
                        $basketItem->bride_mother = $productNames;
                        $basketItem->groom_mother = $productNames;
                    break;
                
                default:
                    break;
            }
        }
    
                    $basketItem->save();
    
        return redirect('shopping-basket')->with('success', 'Items added to basket successfully.');
    }


public function updateWPBasket(Request $request)
{
    // Retrieve the existing basket item
    $basketItem = WeddingPackageBasket::where('id', $request->id)
                                    ->where('wedding_package_id', $request->wedding_package_id)
                                    ->where('customer_id', $request->customer_id)
                                    ->first();

    if ($basketItem) {
        // Log the request data
        \Log::info('Request Data:', $request->all());

        // Loop through the submitted data and update color columns
        foreach ($request->all() as $key => $value) {
            // Check if the key ends with '_color'
            if (Str::endsWith($key, '_color')) {
                // Update the color column in the basket item
                $basketItem->{$key} = $value;
            }
        }

        // Save the updated basket item
        $basketItem->save();

        // Log the updated basket item
        \Log::info('Updated Basket Item:', $basketItem->toArray());

        return redirect()->route('shopping-basket')->with('success', 'Basket updated successfully');
    } else {
        return redirect()->route('shopping-basket')->with('error', 'Basket item not found');
    }
}


}


