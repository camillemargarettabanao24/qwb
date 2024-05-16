
@extends ('layouts.customer')

@section ('content')

<body>
 
<section class="indivproducts" id="indivproducts">
<div class="box-container">
            <div class="box">
                <div class="image-carousel">
                    <div class="swiper-container">
                        <div class="swiper-wrapper"> 
                            @if(isset($productImages[$product->id]) && count($productImages[$product->id]) > 0)
                                @foreach($productImages[$product->id] as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ $image->image_path }}" alt="{{ $product->item }}">
                                    </div>
                                @endforeach
                            @else
                            <div class="swiper-slide">
                                <p>No image available</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Add arrows for navigation -->
                <div class="prev-arrow">&lt;</div>
                <div class="next-arrow">&gt;</div>
            </div>
        </div>
    <div class="box-details">
        <div class="indiv-content">
            <h6>Products/{{$product->category}}</h6>
            <h2>{{$product->item}}</h2>
            <div class="price" id="totalPrice">₱{{ number_format($product->price,2, '.',',')}}</div>
            <h4>Product details</h4>
            <span>{{$product->description}}</span>

            <form method="POST" action="{{ route('shopping-basket.add') }}">
                @csrf

                @if($user)
                <input type="hidden" name="customer_id" value="{{$user->id}}">
                @endif
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <input type="hidden" name="product_images_id" value="{{ $productImage->id }}">

                <div class="form-group">
                    <select name="color" id="color" class="form-control">
                        <option style="color: grey" disabled selected>select a color</option> <!-- Placeholder option -->
                            @foreach ($productColors as $color)
                                <option value="{{$color->color}}" data-quantity="{{ $color->quantity }}" data-price="{{ $color->price }}">{{ $color->color }}</option>
                            @endforeach
                    </select>
                    <p id="colorQuantity"></p>
                    <p id="colorPrice"></p>
                </div>

                <div class="form-group"> 
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="1">
                </div>

                <div class="form-group">
                        <select name="accessories" id="accessories" class="form-control" required>
                            <option value="" disabled selected>select an accessory</option> <!-- Placeholder option -->
                                @foreach ($productAccessories as $accessory)
                                    <option value="{{ $accessory->accessory }}" data-quantity="{{ $accessory->quantity }}" data-price="{{ $accessory->price }}">{{ $accessory->accessory }}</option>
                                @endforeach
                        </select>
                    <p id="accessoryQuantity"></p>
                    <p id="accessoryPrice"></p>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="acc_quantity" id="acc_quantity" class="form-control" value="0" min="0">
                </div>

                <input type="hidden" name="total_price" id="totalPrice" value="">
                                @if(session('success'))
                                    <div id="success-message" style="color:green">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if(session('error'))
                                    <div id="error-message" style="color:red">
                                        {{ session('error') }}
                                    </div>
                                @endif

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary">Add to Basket</button>
            </form>
        </div> 
    </div>
</section>

<!--products-->
<section class="products" id="products">
    <h2 class="heading" style="margin-left:5em; color:grey">YOU MAY ALSO LIKE</h2>
        <div class="box-container">
        @foreach($products as $prod)
                    <div class="box" id="image"> 
                        <div class="image" >
                        @if(isset($productImages[$prod->id]) && count($productImages[$prod->id]) > 0)
                                <img src="{{ $productImages[$prod->id][0]->image_path }}" alt="{{ $prod->item }}">
                            @else
                                <p>No image available</p>
                            @endif
                            <div class="icon">
                                <a href="{{ route('customer-add2cart', ['id' => $prod->id]) }}" class="fas fa-shopping-basket"></a>
                                <a href="#" class="fas fa-calendar" onclick="showCalendarModal('{{ $prod->item }}')"></a>
                            </div>
                        </div>
                        <div class="content">
                            <h3>{{$prod->item}}</h3>
                            <div class="category">{{$prod->category}}</div>
                            <div class="price">₱{{$prod->price}}</div>
                        </div>                  
                    </div>
        @endforeach             
        </div>

    </section>
</body>

<script>
    // Function to update total price
    function updateTotalPrice() {
        var colorSelect = document.getElementById('color');
        var colorOption = colorSelect.options[colorSelect.selectedIndex];
        var colorPrice = parseFloat(colorOption.getAttribute('data-price')) || 0; // Default to 0 if price attribute is missing

        var accessorySelect = document.getElementById('accessories');
        var accessoryOption = accessorySelect.options[accessorySelect.selectedIndex];
        var accessoryPrice = parseFloat(accessoryOption.getAttribute('data-price')) || 0; // Default to 0 if price attribute is missing

        var quantity = parseInt(document.getElementById('quantity').value) || 1;
        var accQuantity = parseInt(document.getElementById('acc_quantity').value) || 0; // Default to 0 if accessory quantity is empty

        // Calculate total price
        var totalPrice = (colorPrice * quantity) + (accessoryPrice * accQuantity);

        // Display total price
        document.getElementById('totalPrice').textContent = '₱' + totalPrice.toFixed(2);

        // Set total price value to hidden input
        document.querySelector('input[name="total_price"]').value = totalPrice.toFixed(2);
    }

    // Event listener for color dropdown
    document.getElementById('color').addEventListener('change', updateTotalPrice);

    // Event listener for accessory dropdown
    document.getElementById('accessories').addEventListener('change', updateTotalPrice);

    // Event listener for quantity input
    document.getElementById('quantity').addEventListener('input', updateTotalPrice);

    // Event listener for accessory quantity input
    document.getElementById('acc_quantity').addEventListener('input', updateTotalPrice);

    // Initial update of total price
    updateTotalPrice();
</script>



<script>
    // Function to update quantity and price based on selection
    function updateQuantityAndPrice(elementId, quantityId, priceId, inputId) {
        var element = document.getElementById(elementId);
        var selectedOption = element.options[element.selectedIndex];
        var quantity = selectedOption.getAttribute('data-quantity');
        var price = selectedOption.getAttribute('data-price');
        var quantityElement = document.getElementById(quantityId);
        var priceElement = document.getElementById(priceId);
        var inputElement = document.getElementById(inputId);

        // Check if quantity and price are available
        if (quantity !== null && price !== null) {
            quantityElement.textContent = 'Stock: ' + quantity;
            priceElement.textContent = 'Price: ' + price;
        } else {
            quantityElement.textContent = '';
            priceElement.textContent = '';
        }

        // Update the maximum attribute of the input field
        if (quantity !== null) {
            inputElement.max = quantity;
        } else {
            inputElement.max = 0; // Default to 1 if quantity is not available
        }
    }

    // Event listener for color dropdown
    document.getElementById('color').addEventListener('change', function() {
        updateQuantityAndPrice('color', 'colorQuantity', 'colorPrice', 'quantity');
    });

    // Event listener for accessory dropdown
    document.getElementById('accessories').addEventListener('change', function() {
        updateQuantityAndPrice('accessories', 'accessoryQuantity', 'accessoryPrice', 'acc_quantity');
    });
</script>

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
    document.addEventListener('DOMContentLoaded', function () {
        const slides = document.querySelectorAll('.swiper-slide');
        const prevArrow = document.querySelector('.prev-arrow');
        const nextArrow = document.querySelector('.next-arrow');
        let currentIndex = 0;

        // Function to show slide
        function showSlide(index) {
            slides.forEach((slide, i) => {
                if (i === index) {
                    slide.style.display = 'block';
                } else {
                    slide.style.display = 'none';
                }
            });
        }

        // Show initial slide
        showSlide(currentIndex);

        // Previous slide
        prevArrow.addEventListener('click', function () {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            showSlide(currentIndex);
        });

        // Next slide
        nextArrow.addEventListener('click', function () {
            currentIndex = (currentIndex + 1) % slides.length;
            showSlide(currentIndex);
        });
    });
</script>

@endsection






