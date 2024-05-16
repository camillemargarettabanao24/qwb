@extends ('layouts.customer')

@section ('content')

<!-- products -->
<body>
    <section class="products" id="products">

        <h1 class="heading"> Best Rental Products</h1>

    <div class="container-fluid">
        <div class="container">
        <div class="app-content-actions">
        <input class="search-bar" id="find" placeholder="Search..." type="text" onkeyup="search()">
        <div class="app-content-actions-wrapper">
            <div class="filter-button-wrapper">
                <select id="category-filter" class="action-button">
                    <option disabled selected>Category</option>
                    @php
                        $unique_categories = collect();

                        // Collect all categories from all products
                        foreach ($products as $product) {
                            $unique_categories->push($product->category);
                        }

                        // Filter out duplicate categories
                        $unique_categories = $unique_categories->unique();
                    @endphp

                    @foreach ($unique_categories as $category)
                        <option style="text-transform: capitalize" value="{{ $category }}">{{ $category }}</option>
                    @endforeach

                </select>
            </div>
            <div class="filter-button-wrapper">
                <select id="color-filter" class="action-button">
                    <option disabled selected>Color</option>
                    @php
                        $unique_colors = collect();

                        // Collect all colors from all products
                        foreach ($products as $product) {
                            $unique_colors = $unique_colors->merge($product->product_colors->pluck('color'));
                        }

                        // Filter out duplicate colors
                        $unique_colors = $unique_colors->unique();
                    @endphp

                    @foreach ($unique_colors as $color)
                        <option  value="{{ $color }}">{{ $color }}</option>
                    @endforeach

                </select>
            </div>
            <div class="filter-button-wrapper">
                <select id="price-filter" class="action-button">
                    <option disabled selected>Price</option>
                    @php
                        $prices = $products->pluck('price');

                        // Determine minimum and maximum prices
                        $min_price = $prices->min();
                        $max_price = $prices->max();

                        // Define price ranges
                        $ranges = [
                            ['min' => 200, 'max' => 500],
                            ['min' => 600, 'max' => 2000],
                            ['min' => 3000, 'max' => 7000],
                        ];
                    @endphp

                    @foreach ($ranges as $range)
                        @php
                            $range_str = "₱". $range['min']. " - ₱". $range['max'];
                        @endphp
                        <option value="{{ $range_str }}">{{ $range_str }}</option>
                    @endforeach

                </select>
            </div>
        </div>
    </div>
    </div>
<div class="box-container">

@foreach($products as $product)
            <div class="box" id="image">  
                <div class="image" >
                @if(isset($productImages[$product->id]))
                <img src="{{ $productImages[$product->id]->image_path }}" alt="{{ $product->item }}">
            @else
                <p>No image available</p>
            @endif
                    <div class="icon">
                        <a href="{{ route('customer-add2cart', ['id' => $product->id]) }}" class="fas fa-shopping-basket"></a>
                        <a href="#" class="fas fa-calendar-alt"  onclick="showCalendarModal({{ $product->id }})"></a>
                    </div>
                </div>
                <div class="content">
                    <h3 style="text-transform:capitalize">{{$product->item}}</h3>
                    <div class="category" hidden >{{$product->category}}</div>
                    <div class="price">₱{{number_format($product->price,2,'.',',')}}</div>
                </div>                  
            </div>

            <!-- Calendar Modal for the current product -->
            <div id="calendarModal_{{ $product->id }}" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeCalendarModal('{{ $product->id }}')">&times;</span>
                    <h2 id="modalProductName_{{ $product->id }}">Status Calendar</h2>
                    <div id="calendarContent_{{ $product->id }}">
                        @foreach ($product->product_colors as $product_color)
                            <div class="category">
                                <strong style="text-transform: capitalize; font-size: 12px;">{{ $product_color->color }}</strong>
                            </div>
                            @php
                                $reserved = false;
                                $ongoing = false;
                                $reservationDateReserved = null;
                                $reservationDateOngoing = null;
                            @endphp
                            @foreach ($reservationsCompleted as $reservation)
                                @foreach ($reservation->basket as $basketItem)
                                    @if ($basketItem->product_id == $product->id && $basketItem->color == $product_color->color)
                                        @if ($reservation->status === "Reserved")
                                            @php
                                                $reserved = true;
                                                $reservationDateReserved = \Carbon\Carbon::parse($reservation->reservation_date)->format('F j, Y');
                                            @endphp
                                        @elseif ($reservation->status === "Ongoing")
                                            @php
                                                $ongoing = true;
                                                $reservationDateOngoing = \Carbon\Carbon::parse($reservation->reservation_date)->format('F j, Y');
                                            @endphp
                                        @endif
                                        @if ($reserved && $ongoing)
                                            @break 2
                                        @endif
                                    @endif
                                @endforeach
                            @endforeach
                            @if ($reserved)
                                <div class="reserved-info" style="color:blue">
                                    <p style="font-size: 12px" >Reserved: {{ $reservationDateReserved }}</p>
                                </div>
                            @endif
                            @if ($ongoing)
                                <div class="reserved-info" style="color:green">
                                    <p style="font-size: 12px" >Ongoing: {{ $reservationDateOngoing }}</p>
                                </div>
                            @endif
                            @if (!$reserved && !$ongoing)
                                <div class="reserved-info" style="color:red">
                                    <p style="font-size: 12px">No reservations</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>




            
@endforeach      

 
@foreach($weddingPackage as $weddingPackageItem) 

            <div class="box" id="image">  
                <div class="image" >

                    @if(isset($WeddingProductImages[$weddingPackageItem->id]))
                        <img src="{{ $WeddingProductImages[$weddingPackageItem->id]->image_path }}" alt="{{ $weddingPackageItem->item }}">
                    @else
                        <p>No image available</p>
                    @endif
                    
                    <div class="icon">
                        <a href="{{ route('wedding-package', ['id' => $weddingPackageItem->id]) }}" class="fas fa-shopping-basket"></a>
                            <a href="" class="fas fa-calendar-alt" onclick="showCalendarModal('{{ $weddingPackageItem->item }}')"></a>
                    </div>

                </div>

                <div class="content">
                    <h3 style="text-transform:capitalize">{{$weddingPackageItem->item}}</h3>
                    <div class="price">₱{{$weddingPackageItem->price}}</div>
                </div>       

            </div>
            
 @endforeach      
           
</div>




</section>

<script>
    const containers = document.querySelectorAll(".image");

    containers.forEach(container => {
        const img = container.querySelector("img");

        container.addEventListener("mousemove", (e) => {
            const rect = container.getBoundingClientRect();
            const containerCenterX = rect.left + rect.width / 2;
            const containerCenterY = rect.top + rect.height / 2;

            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            img.style.transformOrigin = `${x}px ${y}px`;
            img.style.transform = "scale(3)";
        });

        container.addEventListener("mouseleave", () => {
            img.style.transform = "scale(1)";
        });
    });
</script>


<script>
    function showCalendarModal(productId) {
        const modalId = `calendarModal_${productId}`;
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
        }
    }

    function closeCalendarModal(productId) {
        const modalId = `calendarModal_${productId}`;
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
    }

   // Close the modal if the user clicks outside of it
    window.onclick = function(event) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
    }

    // Check if the click event occurred inside the modal
        const modalContent = document.querySelector('.modal-content');
        if (modalContent && !modalContent.contains(event.target)) {
            modals.forEach(modal => {
                modal.style.display = 'none';
            });
        }
    
</script>






<script>
    // Function to filter products based on user selection
    function filterProducts() {
        const category = document.getElementById('category-filter').value;
        const color = document.getElementById('color-filter').value;
        const price = document.getElementById('price-filter').value;

        // Show all products initially
        const products = document.querySelectorAll('.box');
        products.forEach(product => {
            product.style.display = 'block';
        });

        // Filter products based on category
        if (category) {
            products.forEach(product => {
                const productCategory = product.querySelector('.category').textContent;
                if (productCategory !== category) {
                    product.style.display = 'none';
                }
            });
        }

        // Filter products based on color
        if (color) {
            products.forEach(product => {
                const productColors = Array.from(product.querySelectorAll('.category')).map(color => color.textContent);
                if (!productColors.includes(color)) {
                    product.style.display = 'none';
                }
            });
        }

        // Filter products based on price
        if (price) {
            const priceRange = price.split(' - ');
            const minPrice = parseFloat(priceRange[0].replace('₱', '').replace(',', ''));
            const maxPrice = parseFloat(priceRange[1].replace('₱', '').replace(',', ''));
            products.forEach(product => {
              const productPrice = parseFloat(product.querySelector('.price').textContent.replace('₱', '').replace(',', ''));
                if (productPrice < minPrice || productPrice > maxPrice) {
                    product.style.display = 'none';
                }
            });
        }
    }

    // Event listeners for filtering
    document.getElementById('category-filter').addEventListener('change', filterProducts);
    document.getElementById('color-filter').addEventListener('change', filterProducts);
    document.getElementById('price-filter').addEventListener('change', filterProducts);
</script>


</body>
</html>

@endsection