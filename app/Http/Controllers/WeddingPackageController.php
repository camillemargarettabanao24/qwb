<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WeddingPackage;
use App\Models\WeddingPackageImage;
use App\Models\Product;

class WeddingPackageController extends Controller
{

// CUSTOMER SIDE
    public function staff_products_add_wedding_package(){        
        return view('staff-products-add-wedding-package');
    }

    public function store(Request $request)
{
    // Validate the incoming request data
        $request->validate([
            'item' => 'required',
            'description' => 'required',
            'category' => 'required',
            'price' => 'required|numeric|min:1',
            'image_path.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);


        $weddingPackage = new WeddingPackage();
            $weddingPackage->item = $request->input('item');
            $weddingPackage->description = $request->input('description');
            $weddingPackage->category = $request->input('category');
            $weddingPackage->price = $request->input('price');
            $weddingPackage->save();


    // process the uploaded images and store them
        if ($request->hasFile('image_path')) {
            foreach ($request->file('image_path') as $image) {
                $fileName = time() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('wedding_package_images', $fileName, 'public');
                $productImage = new WeddingPackageImage();
                $productImage->wedding_package_id = $weddingPackage->id;
                $productImage->image_path = '/storage/' . $path;
                $productImage->save();
            }
        }

        return redirect()->route('staff-products', $weddingPackage->id)
                     ->with('success', 'Wedding package added successfully.');
}


    public function show(Request $request)
{
        $user = session('LoggedUser');
        $weddingPackageID = $request->route('id');
        $weddingPackage = WeddingPackage::find($weddingPackageID);

    // selected product image
            $WeddingPackageImage = WeddingPackageImage::where('wedding_package_id', $weddingPackageID)->first();
            $weddingPackageItem = WeddingPackage::all();

    // organize the wedding package images into an array by product ID
            $WeddingPackageImages = [];
            foreach ($weddingPackageItem as $item) {
                $images = WeddingPackageImage::where('wedding_package_id', $item->id)->get();
                $WeddingPackageImages[$item->id] = $images;
            }


        $productsByCategory = DB::table('products')
            ->join('product_colors', 'products.id', '=', 'product_colors.product_id')
            ->join('product_images', 'products.id', '=', 'product_images.product_id')
            ->select('products.id', 'products.item', 'products.description', 'products.category', 'products.price', 'product_colors.color', 'product_images.image_path')
            ->whereIn('products.category', 
                    ['Wedding gown', 
                    'Men suit', 
                    'maid of Honor', 
                    'bestman vest', 
                    'Bridesmaid', 
                    'Groomsmen suspender', 
                    'Bearers Suspender', 
                    'Flower Girl', 
                    'Barong', 
                    'Mother Dress'])
            ->get();
        
        $productsByCategoryColors = [];
            foreach ($productsByCategory as $product) {
                $productId = $product->id;
                $productName = $product->item;
                $category = $product->category;
        
            // Check if the product already exists in the array
                if (!isset($productsByCategoryColors[$category][$productName])) {
                    $productsByCategoryColors[$category][$productName]['images'] = [];
                    $productsByCategoryColors[$category][$productName]['colors'] = [];
                }
        
            // Add the image path to the product only if it's not already added
                if (!in_array($product->image_path, $productsByCategoryColors[$category][$productName]['images'])) {
                    $productsByCategoryColors[$category][$productName]['images'][] = $product->image_path;
                }

            // Add the color to the product if it's not already added
                if (!in_array($product->color, $productsByCategoryColors[$category][$productName]['colors'])) {
                    $productsByCategoryColors[$category][$productName]['colors'][] = $product->color;
                }
        }

        $selectedColors = [];
    
    return view('wedding-package', 
            compact('user',
                'weddingPackage', 
                'WeddingPackageImage', 
                'WeddingPackageImages', 
                'weddingPackageItem', 
                'productsByCategoryColors',
                'productsByCategory', 
                'category', 
                'productName', 
                'productId',
                'selectedColors'));
}

// STAFF WEDDING PACKAGE ADD, UPDATE, DELETE

    public function update_wedding_package_show($id)
    {
        $wpItems = WeddingPackage::findOrFail($id);

            return view('staff-products-update-wedding-package', compact('wpItems'));
    }


    public function wp_update(Request $request, $id)
    {
        $request->validate([
            'item' => 'required',
            'description' => 'required',
            'category' => 'required',
            'price' => 'required|numeric|min:1',
            'image_path.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // Find the existing wedding package by ID
        $weddingPackage = WeddingPackage::findOrFail($id);
    
        // Update the wedding package details
        $weddingPackage->item = $request->input('item');
        $weddingPackage->description = $request->input('description');
        $weddingPackage->category = $request->input('category');
        $weddingPackage->price = $request->input('price');
        $weddingPackage->save();
    
        // Process the uploaded images and store them
        if ($request->hasFile('image_path')) {
            foreach ($request->file('image_path') as $image) {
                $fileName = time() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('wedding_package_images', $fileName, 'public');
                $productImage = new WeddingPackageImage();
                $productImage->wedding_package_id = $weddingPackage->id;
                $productImage->image_path = '/storage/' . $path;
                $productImage->save();
            }
        }
        return redirect()->route('staff-products')->with('success', 'Wedding package updated successfully.');
    }


    public function destroy(string $id)
    {
        //
    }
}
