<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\WeddingPackage;
use App\Models\WeddingPackageImage;
use App\Models\Color;
use App\Models\Accessory;
use Log;

class productManagerController extends Controller
{
    public function manager_products(){ 

        $userManager = session('LoggedUserManager'); 

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

        return view('manager-products', compact('products','productImages', 'weddingPackage', 'WeddingProductImages', 'userManager'));
    }

    public function create(){
        return view('manager-products.create');
    }

    public function store(Request $request)
{
    try{
    $request->validate([
        'item' => 'required',
        'image_path.*' => 'image|mimes:jpeg,png,jpg|max:2048', // Allow multiple images
        'description' => 'required',
        'category' => 'required',
        'price' => 'required|integer',

        // validation for colors and accessories
        'colors.*.color' => 'required',
        'colors.*.quantity' => 'required|integer|min:0',
        'colors.*.price' => 'required|numeric|min:0',
        'accessories.*.accessory' => 'nullable',
        'accessories.*.quantity' => 'nullable|integer|min:0',
        'accessories.*.price' => 'nullable|numeric|min:0',
    ]);

        // Create the product
        $product = new Product();
        $product->item = $request->input('item'); 
        $product->description = $request->input('description');
        $product->category = $request->input('category');
        $product->price = $request->input('price');
        $product->save();

       // Store colors
        foreach ($request->input('colors') as $colorData) {
            $product->product_colors()->create([
                'color' => $colorData['color'],
                'quantity' => $colorData['quantity'],
                'price' => $colorData['price'],
        ]); 
    }

        // Store accessories
        foreach ($request->input('accessories') as $accessoryData) {
            $product->product_accessories()->create([
                'accessory' => $accessoryData['accessory'],
                'quantity' => $accessoryData['quantity'],
                'price' => $accessoryData['price'],
            ]);
    }

        // Upload and store product images
        if ($request->hasFile('image_path')) {
            foreach ($request->file('image_path') as $image) {
                $fileName = time() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('product_images', $fileName, 'public');
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image_path = '/storage/' . $path;
                $productImage->save();
            }
        }

        // Log activity
        ActivityLogs::create([
            'activity' => 'Added a product',
            'user' => session('LoggedUserManager')->username
        ]);

        return redirect('manager-products')->with('flash_message', 'Product Added!');
    } catch (\Exception $e) {
        // Log the error
        \Log::error('Error in store method: ' . $e->getMessage());

        // Return an error response or redirect to a specific page with a flash message
        return redirect()->back()->with('error', 'An error occurred while adding the product. Please try again.');
    }
}



    public function products_update(Request $request, $id)
    {
        try {
            $request->validate([
                'item' => 'required',
                'description' => 'required',
                'category' => 'required',
                'price' => 'required|numeric|min:0',
                'colors.*.color' => 'required',
                'colors.*.quantity' => 'required|integer|min:0',
                'colors.*.price' => 'required|numeric|min:0',
                'accessories.*.accessory' => 'nullable',
                'accessories.*.quantity' => 'nullable|integer|min:0',
                'accessories.*.price' => 'nullable|numeric|min:0',
                'image_path.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $product = Product::findOrFail($id);

            $product->item = $request->input('item');
            $product->description = $request->input('description');
            $product->category = $request->input('category');
            $product->price = $request->input('price');
            $product->save();

            // Update or create colors
            $product->product_colors()->delete(); // Delete existing colors
            foreach ($request->input('colors') as $colorData) {
                $product->product_colors()->create([
                    'color' => $colorData['color'],
                    'quantity' => $colorData['quantity'],
                    'price' => $colorData['price'],
                ]);
            }

            // Update or create accessories
            $product->product_accessories()->delete(); // Delete existing accessories
            foreach ($request->input('accessories') as $accessoryData) {
                $product->product_accessories()->create([
                    'accessory' => $accessoryData['accessory'],
                    'quantity' => $accessoryData['quantity'],
                    'price' => $accessoryData['price'],
                ]);
            }

            // Upload and store product images
            if ($request->hasFile('image_path')) {
                foreach ($request->file('image_path') as $key => $image) {
                    $fileName = time() . '_' . $image->getClientOriginalName();
                    $path = $image->storeAs('product_images', $fileName, 'public');
                    $isCover = $key === (int)$request->input('cover_photo_index'); // Check if this image is the cover photo
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image_path = '/storage/' . $path;
                    $productImage->is_cover = $isCover;
                    $productImage->save();
                }
            }

            // Log activity
            ActivityLogs::create([
                'activity' => 'Updated a product',
                'user' => session('LoggedUserManager')->username
            ]); 

            return redirect('manager-products')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error in store method: ' . $e->getMessage());

            // Return an error response or redirect to a specific page with a flash message
            return redirect()->back()->with('error', 'An error occurred while updating the product. Please try again.');
        }
    }

    public function manager_products_update($id)
    {         
        try {
            // Retrieve product details
            $product = Product::findOrFail($id)->load('images');
            $colors = Color::all(); 
            $accessories = Accessory::all();

            return view('manager-products-update', compact('product', 'colors', 'accessories'));
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error in manager_products_update method: ' . $e->getMessage());

            // Return an error response or redirect to a specific page with a flash message
            return redirect()->back()->with('error', 'An error occurred while retrieving product details. Please try again.');
        }
    }



    public function show($id)
    {
        $product = Product::findOrFail($id);
        $productImages = ProductImage::where('product_id', $id)->get();

        return view('products.show', compact('product', 'productImages'));
    }

    
    public function manager_products_add()
    {         
        $userManager = session('LoggedUserManager'); 

        $colors = Color::all(); 
        $accessories = Accessory::all();
        
            return view('manager-products-add', compact( 'colors', 'accessories', 'userManager'));   
    }   
    
    
    public function products_delete($id)
{
    try {
        $product = Product::findOrFail($id);

        $product->delete();

        // Log activity
        ActivityLogs::create([
            'activity' => 'Deleted a product',
            'user' => session('LoggedUserManager')->username
        ]);

        return redirect()->back()->with('success', 'Product deleted successfully.');
    } catch (\Exception $e) {
        // Log the error
        \Log::error('Error deleting product: ' . $e->getMessage());

        // Return with an error message
        return redirect()->back()->with('error', 'An error occurred while deleting the product. Please try again.');
    }
}

    


}

