@extends ('layouts.manager')

@section ('contentss')

<div class="app-container">
  <div class="sidebar">
 
    <ul class="sidebar-list">
      <!-- <li class="sidebar-list-item">
        <a href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          <span>Home</span>
        </a>
      </li> -->
      <li class="sidebar-list-item">
        <a href="{{route('manager.manager-home')}}">
          <i class="far fa-calendar-check" ></i><span>Reservations</span>
        </a>
      </li>
      <li class="sidebar-list-item">
        <a href="{{route('manager.manager-appointments')}}">
          <i class="fas fa-calendar-alt" ></i><span>Appointments</span>
        </a>
      </li>
      <li class="sidebar-list-item">
        <a href="{{route ('manager.manager-rented')}}">
          <i class="fas fa-tshirt" ></i><span>Rented</span>
        </a>
      </li>
      <li style="background-color: #f085c3; " class="sidebar-list-item">
        <a style="color:white " href="{{route('manager.manager-products')}}">
          <i class="fas fa-box-open" ></i><span>Products</span>
        </a>
      </li>
      <li class="sidebar-list-item">
      <a href="{{route('reports.reserved')}}">
          <i class="fas fa-newspaper" style="margin-right: 1em"></i><span>Reports</span>
        </a>
      </li>
      <li class="sidebar-list-item">
        <a href="#">
          <i class="fas fa-user" style="margin-right: 1em"></i><span>Account</span>
        </a>
      </li>
    </ul>
    <div class="account-info">
     
    </div>
  </div>

  
<div class="products-staff">
    <div class="app-content">
        <div class="app-content-header">      
          <button class="app-content-headerButton"><a href="{{route('manager.manager-products-add')}}">Add Product</a></button>
        </div>
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
            <div class="staff-app-header">
                <span>Items</span>
            </div>
            <div class="staff-app-header">
                <span>Description</span>
            </div>
            <div class="staff-app-header">
                <span>Category</span>
            </div>
            <div class="staff-app-header">
                <span>Colors</span>
            </div>
            <div class="staff-app-header">
                <span>Color Stock</span>
            </div>
            <div class="staff-app-header">
                <span>Price</span>
            </div>
            <div class="staff-app-header">
                <span>Accessories</span>
            </div>
            <div class="staff-app-header">
                <span>Accessory Stock</span>
            </div>
            <div class="staff-app-header">
                <span>Price</span>
            </div>
            <div class="staff-app-header">
                <span>Action</span>
            </div>
        </div>

        
        @foreach ($products as $product) 

        <form action="{{ route('manager.products.delete', ['id' => $product->id]) }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="products-row">
                <button class="cell-more-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                        <circle cx="12" cy="12" r="1"/>
                        <circle cx="12" cy="5" r="1"/>
                        <circle cx="12" cy="19" r="1"/>
                    </svg>
                </button>
                <div class="product-cell image">
                    @if(isset($productImages[$product->id]))
                        <img src="{{ $productImages[$product->id]->image_path }}" alt="{{ $product->item }}">
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
                <div class="product-cell colors">
                    @foreach($product->product_colors as $color)
                    {{$color->color}} <br>
                    @endforeach
                </div>
                <div class="product-cell stock">
                    @foreach($product->product_colors as $color)
                    <span class="cell-label" style="text-align:center"></span>{{$color->quantity}} <br>
                    @endforeach
                </div>
                <div class="product-cell stock">
                    @foreach($product->product_colors as $color)
                    <span class="cell-label" style="text-align:center"></span>₱{{ number_format($color->price,2,'.',',')}} <br>
                    @endforeach
                </div>
                <div class="product-cell accessory">
                    @foreach($product->product_accessories as $accessory)
                    {{$accessory->accessory}} <br>
                    @endforeach
                </div>
                <div class="product-cell stock">
                    @foreach($product->product_accessories as $accessory)
                    <span class="cell-label" style="text-align:center"></span>{{$accessory->quantity}} <br>
                    @endforeach
                </div>
                <div class="product-cell stock">
                    @foreach($product->product_accessories as $accessory)
                    <span class="cell-label" style="text-align:center"></span>₱{{ number_format($accessory->price,2,'.',',')}}<br>
                    @endforeach
                </div>
                <div class="product-cell">
                    <span class="cell-label"></span>
                    <button style="width: 50%; color: green; background-color: #4f6079; padding:0.6em; border-radius:10px">
                        <i class="fas fa-pencil-alt" style="color:white" ></i><a style="color:white; text-decoration:none; padding-left:5px" href="{{ route('manager.manager-products-update', ['id' => $product->id]) }}"></a>
                    </button><br><br>
                    <button type="submit" style="width: 50%; color: white; background-color: darksalmon; padding:0.6em; border-radius:10px"><i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        </form>

        @endforeach

    </div>
    </div>
 
    <div class="app-content">
      <h2>Wedding Package</h2>
        <div class="product-content-actions">
            <input class="search-bar" id="find" placeholder="Search..." type="text" onkeyup="search()">
            <div class="app-content-actions-wrapper">
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
                @if(isset($WeddingProductImages[$product->id]))
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
                <span class="cell-label"></span>
                <button style="width: 100%; color: green; background-color: #f085c3; padding:0.6em; border-radius:10px">
                    <i class="fas fa-pencil-alt"></i><a style="color:white; text-decoration:none; padding-left:5px" href="{{ route('manager.update-wedding-package', ['id' => $product->id]) }}">Update</a>
                </button><br><br>
                <button type="submit" style="width: 100%; color: red; background-color: darksalmon; padding:0.6em; border-radius:10px">
                    <i class="fas fa-trash-alt"></i><a style="color:white; text-decoration:none; padding-left:5px" href="">Delete</a>
                </button>
            </div>
        </div>
        @endforeach


    </div>
    </div>
</div>


</div>

<script>
        document.getElementById('search-input').addEventListener('input', function(e) {
            const searchText = e.target.value.toLowerCase();
            const products = document.getElementsByClassName('products-row');

            for (let i = 0; i < products.length; i++) {
                const product = products[i];
                const productName = product.getElementsByClassName('item')[0].textContent.toLowerCase();
                
                if (productName.includes(searchText)) {
                    product.style.display = '';
                } else {
                    product.style.display = 'none';
                }
            }
        });
</script>

@endsection 
