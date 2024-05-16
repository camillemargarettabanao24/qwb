<!-- Create Product Form -->
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Product Name -->
    <div class="form-group">
        <label for="item">Product Name:</label>
        <input type="text" class="form-control" id="item" name="item" required>
    </div>

    <!-- Description -->
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>

    <!-- Category -->
    <div class="form-group">
        <label for="category">Category:</label>
        <input type="text" class="form-control" id="category" name="category" required>
    </div>

    <!-- Price -->
    <div class="form-group">
        <label for="price">Price:</label>
        <input type="number" class="form-control" id="price" name="price" min="1" required>
    </div>

    <div class="form-group">
        <label for="image_path">Product Images:</label>
        <input type="file" class="form-control-file" id="image_path" name="image_path[]" multiple required>
    </div>

    <!-- ---------------------------- -->
    <div class="container">
    <h1>Add Colors</h1>
    <div id="colorInputs">
        <!-- Existing color inputs -->
        <div class="form-group">
            <label for="colors">Color 1</label>
            <input name="colors[0][color]" class="form-control" placeholder="Color Name">
            <input name="colors[0][quantity]" class="form-control" type="number" placeholder="Quantity">
            <input name="colors[0][price]" class="form-control" type="number" placeholder="Price">
        </div>
    </div>
    <button id="addColor">Add Color</button>
</div>

<div class="container">
    <h1>Add Accessories</h1>
    <div id="accessoryInputs">
        <!-- Existing accessory inputs -->
        <div class="form-group">
            <label for="accessories">Accessory 1</label>
            <input name="accessories[0][accessory]" class="form-control" placeholder="Accessory Name">
            <input name="accessories[0][quantity]" class="form-control" type="number" placeholder="Quantity">
            <input name="accessories[0][price]" class="form-control" type="number" placeholder="Price">
        </div>
    </div>
    <button id="addAccessory">Add Accessory</button>
</div>

    <!-- ---------------------------- -->

    <!-- Submit Button -->
          <button type="submit" class="btn btn-primary">Add Product</button>

</form>
</div>






<div class="app-content">
      <h2>Wedding Package</h2>
        <div class="product-content-actions">
            <input class="search-bar" id="find" placeholder="Search..." type="text" onkeyup="search()">
            <div class="app-content-actions-wrapper">
                <div class="filter-button-wrapper">
                    <select class="action-button">
                        <option disabled selected>Category</option>
                        <option value="">Prom Gown</option>
                        <option value="">Wedding Gown</option>
                        <option value="">Ball Gown</option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </div>
                <div class="filter-button-wrapper">
                    <select class="action-button">
                        <option disabled selected>Color</option>
                        <option value="">Red</option>
                        <option value="">Blue</option>
                        <option value="">Beige</option>
                        <option value="">Azure Blue</option>
                    </select>
                </div>
                <div class="filter-button-wrapper">
                    <select class="action-button">
                        <option disabled selected>Price</option>
                        <option value="">₱200 - ₱500</option>
                        <option value="">₱600 - ₱2000</option>
                        <option value="">₱3000 - ₱7000</option>
                    </select>
                </div>
            </div>
        </div>
      <div class="products-area-wrapper tableView">
        <div class="products-header">
            <div class="product-cell image">
                <span>Items</span>
                <button class="sort-button"></button>
            </div>
            <div class="product-cell category">
                <span>Description</span>
                <button class="sort-button"></button>
            </div>
            <div class="product-cell status-cell">
                <span>Category</span>
                <button class="sort-button"></button>
            </div>
            <div class="product-cell stock">
                <span>Price</span>
                <button class="sort-button"></button>
            </div>
            <div class="product-cell stock">
                <span>Action</span>
                <button class="sort-button"></button>
            </div>
        </div>

        @foreach ($weddingPackage as $product) 
        <div class="products-row">
            <button class="cell-more-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                    <circle cx="12" cy="12" r="1"/>
                    <circle cx="12" cy="5" r="1"/>
                    <circle cx="12" cy="19" r="1"/>
                </svg>
            </button>
            <div class="product-cell image">
                @if(isset($WeddingProductImages[$basket->id]))
                            <img src="{{ $WeddingProductImages[$product->id]->image_path }}" alt="{{ $product->item }}">
                        @else
                            <p>No image available</p>
                        @endif          
                <div class=" item">{{$product->item}}</div>
            </div>
            <div class="product-cell description">
                <span class="cell-label"></span>{{$product->description}}
            </div>
            <div class="product-cell category">
                <span class="cell-label"></span>{{$product->category}}
            </div>
            <div class="product-cell category">
                <span class="cell-label"></span>₱{{ number_format($product->price,2,'.',',')}}
            </div>
            <div class="product-cell">
                <span class="cell-label">Action:</span>
                <i class="fas fa-pencil-alt"></i><a href="">Update</a>
            </div>
        </div>
        @endforeach


    </div>
    </div>