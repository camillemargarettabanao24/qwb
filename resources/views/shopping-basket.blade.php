
@extends ('layouts.customer')

@section ('content')

<body>

    <div class="basket-container">
            @if($customerId)
                <input type="hidden" name="customer_id" value="{{$customerId->id}}">
            @endif

                <div class="shopping-basket">
                    <h2 class="title">Shopping Basket</h2>
                    @if ($isEmptyBasket)
                        <h4 style="margin-bottom:3em">Your basket is empty.</h4>
                    @endif
                                @if(session('success'))
                                    <div id="success-message" style=" display: flex; justify-content:center; align-items:center; margin:1em; color:green; font-size: 12px">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if(session('error'))
                                    <div id="error-message" style=" display: flex; justify-content:center; align-items:center; margin:1em; color:red; font-size:12px">
                                        {{ session('error') }}
                                    </div>
                                @endif

                    @foreach ($basketItems as $item)                          
                        <form method="POST" action="{{ route('shopping-basket.update') }}">
                            @csrf
                            @method('PUT')

                                        @if($customerId)
                                            <input type="hidden" name="customer_id" value="{{$customerId->id}}">
                                        @endif

                                <input type="hidden" name="product_images_id_{{ $item->product->id }}" value="{{ $item->product_images_id }}">
                        
                                <div class="item">
                                    <input type="hidden" name="shopping_basket_id_{{ $item->id }}" value="{{ $item->id }}">
                                    
                                    <div class="buttons">
                                        <div class="add-appointment">
                                            Appointment <br>
                                            <input type="checkbox" name="appointment[]" value="{{ $item->id }}" onclick="toggleCheckbox(this, 'reservation[]', '{{ $item->id }}')">
                                        </div>
                                        <div class="add-appointment">
                                            Reservation <br>
                                            <input type="checkbox" name="reservation[]" value="{{ $item->id }}" onclick="toggleCheckbox(this, 'appointment[]', '{{ $item->id }}')">
                                        </div>
                                    </div>
                                    <div class="basket-image">
                                        @if(isset($productImages[$item->product->id]))
                                            <img src="{{ $productImages[$item->product->id]->image_path }}" alt="{{ $item->product->item }}">
                                        @endif
                                    </div>
                                    <div class="description">
                                        <span>{{ $item->product->item }}</span>
                                        <span>Color:
                                            <select name="color_{{ $item->product->id }}" class="color-select">
                                                <option value="" disabled selected>{{$item->color}}</option>
                                                @foreach ($productColors[$item->product->id] as $color)
                                                    <option value="{{ $color->color }}" {{ $item->color == $color->color ? 'selected' : '' }} data-price="{{ $color->price }}" data-max-quantity="{{ $color->quantity }}">{{ $color->color }} ({{$color->quantity}})</option>
                                                @endforeach
                                            </select>
                                        </span>
                                        <span>Accessory:
                                            <select name="accessory_{{ $item->product->id }}" class="accessory-select">
                                                <option value="" disabled selected>{{$item->accessories}}</option>
                                                @foreach ($productAccessories[$item->product->id] as $accessory)
                                                    <option value="{{ $accessory->accessory }}" {{ $item->accessories == $accessory->accessory ? 'selected' : '' }} data-price="{{ $accessory->price }}" data-max-quantity="{{ $accessory->quantity }}">{{ $accessory->accessory }} ({{$accessory->quantity}})</option>
                                                @endforeach
                                            </select>
                                        </span>
                                    </div>
                                    <div class="quantity">
                                        <span>Color Quantity:</span>
                                        <input type="number" name="color_quantity_{{ $item->product->id }}" class="color-quantity" id="color_quantity_{{ $item->product->id }}" value="{{ $item->quantity}}" min="1" max="{{ $color->quantity}}">
                                    </div>
                                    <div class="quantity">
                                        <span>Accessory Quantity:</span>
                                        <input type="number" name="accessory_quantity_{{ $item->product->id }}" class="accessory-quantity" id="accessory_quantity_{{ $item->product->id }}" value="{{ $item->acc_quantity}}" min="0" max="{{ $accessory->quantity}}">
                                    </div>
                                    <input type="text" name="total_price_{{ $item->product->id }}" class="total-price" 
                                            data-product-price="{{ $item->product->price * ($item->quantity ?? 0) + $accessory->price * ($item->acc_quantity ?? 0) }}"
                                            value="{{ '₱' . number_format($item->product->price * ($item->quantity ?? 0) + $accessory->price * ($item->acc_quantity ?? 0), 2) }}">

                                        <div class="buttons"><button type="submit"><i class="fas fa-save"></i> Save</button></div>
                        </form>

                                    <!-- <form id="delete-form-{{ $item->id }}" class="delete-form" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <div class="buttons">
                                            <button type="button" onclick="deleteItem('{{ $item->id }}')"><i class="fas fa-trash" style="color:red"></i> Remove</button>
                                        </div>
                                    </form> -->
                    </div>

                    @endforeach
                </div>
                
              

            <div class="shopping-basket">
                <h2 class="title">Wedding Package</h2>
                @if ($isEmptyWPBasket)
                    <h4 style="margin-bottom:3em">Your basket is empty.</h4>
                @endif

                @foreach ($wpItems as $item)

                    <form method="POST" action="{{ route('shopping-basket-wp.update')}}">
                        @csrf
                        @method('PUT')
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <input type="hidden" name="customer_id" value="{{ $item->customer_id }}">
                            <input type="hidden" name="wedding_package_id" value="{{ $item->wedding_package_id }}">
                            <input type="hidden" name="wedding_package_images_id" value="{{ $item->wedding_package_images_id }}">

                        <div class="item-wp">
                            <input type="hidden" name="wedding_package_shopping_basket_id_{{ $item->id }}" value="{{ $item->wedding_package_shopping_basket_id }}">

                            <div class="buttons">
                                <div class="add-appointment">
                                    Appointment <br>
                                    <input type="checkbox" name="appointment[]" value="{{ $item->id }}" onclick="toggleCheckbox(this, 'reservation[]', '{{ $item->id }}')">
                                </div>
                                <div class="add-appointment">
                                    Reservation <br>
                                    <input type="checkbox" name="reservation[]" value="{{ $item->id }}" onclick="toggleCheckbox(this, 'appointment[]', '{{ $item->id }}')">
                                </div>
                            </div>
                            <div class="basket-image-wp">
                                @if ($item->weddingPackageImage)
                                <img src="{{ $item->weddingPackageImage->image_path }}" alt="{{ $item->weddingPackage->item }}">
                                @endif
                            </div>
                            <div class="description-wp">
                            
                                    <h4> {{$item->bride_gown}}</h4>
                                    <span>
                                        <select name="bride_color">
                                            <option value="" disabled selected>{{$item->bride_color}}</option>
                                            @foreach ($productColorsByCategory['Wedding Gown'] as $color)
                                                <option value="{{ $color }}">{{ $color }}</option>
                                            @endforeach
                                        </select>   
                                    </span><br>
                                
                                    <h4> {{$item->groom_suit}}</h4>
                                    <span>
                                        <select name="groom_color">
                                            <option value="" disabled selected>{{$item->groom_color}}</option>
                                            @foreach ($productColorsByCategory['Men Suit'] as $color)
                                                <option value="{{ $color }}">{{ $color }}</option>
                                            @endforeach
                                        </select>   
                                    </span><br>   

                                    <h4> {{$item->maid_of_honor}}</h4>
                                    <span>
                                        <select name="moh_color">
                                            <option value="" disabled selected>{{$item->moh_color}}</option>
                                            @foreach ($productColorsByCategory['Maid Of Honor'] as $color)
                                                <option value="{{ $color }}">{{ $color }}</option>
                                            @endforeach
                                        </select>   
                                    </span><br>               

                                    <h4> {{$item->bestman}}</h4>
                                    <span>
                                        <select name="bestman_color">
                                            <option value="" disabled selected>{{$item->bestman_color}}</option>
                                            @foreach ($productColorsByCategory['Bestman Vest'] as $color)
                                                <option value="{{ $color }}">{{ $color }}</option>
                                            @endforeach
                                        </select>   
                                    </span><br>   

                                    <h4> {{$item->bridesmaid_set}}</h4>
                                    <span>
                                        <select name="bridesmaid_set_color">
                                            <option value="" disabled selected>{{$item->bridesmaid_set_color}}</option>
                                            @foreach ($productColorsByCategory['Bridesmaid'] as $color)
                                                <option value="{{ $color }}">{{ $color }}</option>
                                            @endforeach
                                        </select>   
                                    </span><br>      

                                    <h4> {{$item->groomsmen_set}}</h4>
                                    <span>
                                        <select name="groomsmen_set_color">
                                            <option value="" disabled selected>{{$item->groomsmen_set_color}}</option>
                                            @foreach ($productColorsByCategory['Groomsmen Suspender'] as $color)
                                                <option value="{{ $color }}">{{ $color }}</option>
                                            @endforeach
                                        </select>   
                                    </span><br>   

                                    <h4> {{$item->bearers_set}}</h4>
                                    <span>
                                        <select name="bearers_set_color">
                                            <option value="" disabled selected>{{$item->bearers_set_color}}</option>
                                            @foreach ($productColorsByCategory['Bearers Suspender'] as $color)
                                                <option value="{{ $color }}">{{ $color }}</option>
                                            @endforeach
                                        </select>   
                                    </span><br>             

                                    <h4> {{$item->flowerG_set}}</h4>
                                    <span>
                                        <select name="flowerG_set_color">
                                            <option value="" disabled selected>{{$item->flowerG_set_color}}</option>
                                            @foreach ($productColorsByCategory['Flower Girl'] as $color)
                                                <option value="{{ $color }}">{{ $color }}</option>
                                            @endforeach
                                        </select>   
                                    </span><br>  

                                    <h4> {{$item->bride_father}}</h4>
                                    <span>
                                        <select name="bride_father_color">
                                            <option value="" disabled selected>{{$item->bride_father_color}}</option>
                                            @foreach ($productColorsByCategory['Barong'] as $color)
                                                <option value="{{ $color }}">{{ $color }}</option>
                                            @endforeach
                                        </select>   
                                    </span><br> 

                                    <h4> {{$item->groom_father}}</h4>
                                    <span>
                                        <select name="groom_father_color">
                                            <option value="" disabled selected>{{$item->groom_father_color}}</option>
                                            @foreach ($productColorsByCategory['Barong'] as $color)
                                                <option value="{{ $color }}">{{ $color }}</option>
                                            @endforeach
                                        </select>   
                                    </span><br>      

                                    <h4> {{$item->bride_mother}}</h4>
                                    <span>
                                        <select name="bride_mother_color">
                                            <option value="" disabled selected>{{$item->bride_mother_color}}</option>
                                            @foreach ($productColorsByCategory['Mother Dress'] as $color)
                                                <option value="{{ $color }}">{{ $color }}</option>
                                            @endforeach
                                        </select>   
                                    </span><br>

                                    <h4> {{$item->groom_mother}}</h4>
                                    <span>
                                        <select name="groom_mother_color">
                                            <option value="" disabled selected>{{$item->groom_mother_color}}</option>
                                            @foreach ($productColorsByCategory['Mother Dress'] as $color)
                                                <option value="{{ $color }}">{{ $color }}</option>
                                            @endforeach
                                        </select>   
                                    </span><br>
                                </div>
                            <div class="total-price-wp">₱{{number_format($item->weddingPackage->price,2, '.', ',')}}</div>
                                    <div class="buttons-wp"><button type="submit"><i class="fas fa-save"></i> Save</button></div>
                                    <!-- <div class="buttons-wp"><button type=""><i class="fas fa-trash"  style="color:red"></i> Remove</button></div>            -->
                            </div>
                    </form>
                @endforeach

                                @if(session('successWP'))
                                    <div id="success-message" style="color:green">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if(session('error'))
                                    <div id="error-message" style="color:red">
                                        {{ session('error') }}
                                    </div>
                                @endif
            </div>
        </div>
            <div class="app-res-container">
                <div class="grand-total">
                    <span>Grand Total: ₱</span><span id="grandTotalAmount"></span>
                </div>
                <div class="appointment-res-button">
                    <button type="button" id="addAppointmentBtn" data-route="{{ route('appointment-create') }}">Make Appointment</button>
                    <button type="button" id="addReservationBtn" data-route="{{ route('reservation-create') }}">Make Reservation</button>
                </div>

            </div>
    </div>


<script>
    function deleteItem(itemId) {
        if (confirm('Are you sure you want to remove this item?')) {
            fetch(`/shopping-basket/delete/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (response.ok) {
                    // Reload the page or update the UI as needed
                    location.reload(); // Example: Reload the page
                } else {
                    alert('Failed to delete the item.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
</script>

<script>
    function toggleCheckbox(checkbox, otherName, itemId) {
        var parentDiv = checkbox.parentNode; // Get the parent div
        var otherCheckbox = parentDiv.parentNode.querySelector('input[name="' + otherName + '"][value="' + itemId + '"]');
        
        if (checkbox.checked) {
            otherCheckbox.disabled = true;
        } else {
            otherCheckbox.disabled = false;
        }
    }
</script>

<script>
    document.querySelectorAll('.color-select').forEach(select => {
        select.addEventListener('change', function() {
            const selectedColor = this.value;
            const maxQuantity = parseInt(this.selectedOptions[0].dataset.maxQuantity);
            const productId = this.getAttribute('name').split('_')[1];
            const quantityInput = document.querySelector(`#color_quantity_${productId}`);
            quantityInput.setAttribute('max', maxQuantity);
        });
    });

    document.querySelectorAll('.accessory-select').forEach(select => {
        select.addEventListener('change', function() {
            const selectedAccessory = this.value;
            const maxQuantity = parseInt(this.selectedOptions[0].dataset.maxQuantity);
            const productId = this.getAttribute('name').split('_')[1];
            const quantityInput = document.querySelector(`#accessory_quantity_${productId}`);
            quantityInput.setAttribute('max', maxQuantity);
        });
    });

    document.querySelectorAll('.shopping-basket-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            const item = this.closest('.item');
            const colorQuantity = parseInt(item.querySelector('.color-quantity').value);
            const accessoryQuantity = parseInt(item.querySelector('.accessory-quantity').value);
            item.querySelector(`[name^="color_quantity_"]`).value = colorQuantity;
            item.querySelector(`[name^="accessory_quantity_"]`).value = accessoryQuantity;
        });
    });

    document.querySelectorAll('.color-quantity, .accessory-quantity').forEach(input => {
        input.addEventListener('input', function() {
            const item = this.closest('.item');
            const colorPrice = parseFloat(item.querySelector('.color-select').selectedOptions[0].getAttribute('data-price'));
            const accessoryPrice = parseFloat(item.querySelector('.accessory-select').selectedOptions[0].getAttribute('data-price'));
            const colorQuantity = parseInt(item.querySelector('.color-quantity').value);
            const accessoryQuantity = parseInt(item.querySelector('.accessory-quantity').value);
            const totalPrice = (colorPrice * colorQuantity) + (accessoryPrice * accessoryQuantity);

            // Format the total price with commas for thousands and more
            const formattedPrice = '₱' + totalPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            // Update the value attribute of the input element with the new formatted total price
            item.querySelector('.total-price').value = formattedPrice;
            // Optionally, you can also update the data-product-price attribute if needed
            item.querySelector('.total-price').setAttribute('data-product-price', totalPrice);
        });
    });
</script>


<script>
    // hiding the message
    setTimeout(function() {
        document.getElementById('success-message').style.display = 'none';
    }, 5000); 

    setTimeout(function() {
        document.getElementById('error-message').style.display = 'none';
    }, 5000);
</script>


<script>
  $(document).ready(function() {
    // Function to handle adding appointment
    $('#addAppointmentBtn').on('click', function() {
        // Array to store selected items
        var selectedItems = [];

        // Loop through all checkboxes
        $('input[name="appointment[]"]:checked').each(function() {
            // Add the item's ID to the selectedItems array
            selectedItems.push($(this).val());
        });

        // Send the selectedItems array to the server
        var route = $(this).data('route') + '?itemIds=' + selectedItems.join(',');
        route = route.replace(/,+$/, ''); // Remove trailing commas
        window.location.href = route;
    });

    // Function to handle adding reservation
    $('#addReservationBtn').on('click', function() {
        // Array to store selected items
        var selectedItems = [];

        // Loop through all checkboxes
        $('input[name="reservation[]"]:checked').each(function() {
            // Add the item's ID to the selectedItems array
            selectedItems.push($(this).val());
        });

        // Send the selectedItems array to the server
        var route = $(this).data('route') + '?itemIds=' + selectedItems.join(',');
        route = route.replace(/,+$/, ''); // Remove trailing commas
        window.location.href = route;
    });
});

</script>



<script>
    // Function to calculate the grand total
    function calculateGrandTotal() {
        let grandTotal = 0;
        // Loop through each checked checkbox
        document.querySelectorAll('input[name="appointment[]"]:checked, input[name="reservation[]"]:checked').forEach(function(checkbox) {
            // Get the corresponding item's total price
            const totalPriceElement = checkbox.closest('.item').querySelector('.total-price');
            if (totalPriceElement) {
                // Get the product price from the data-product-price attribute
                const productPrice = parseFloat(totalPriceElement.getAttribute('data-product-price'));
                // Add the product price to the grand total
                grandTotal += productPrice;
            }
        });
        // Format the grand total with commas and ensure it ends with .00
        const formattedGrandTotal = grandTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        // Update the content of the grand total element
        document.getElementById('grandTotalAmount').textContent = formattedGrandTotal;
    }

    // Add event listeners to checkboxes to recalculate the grand total when checkboxes are checked/unchecked
    document.querySelectorAll('input[name="appointment[]"], input[name="reservation[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // Calculate the grand total
            calculateGrandTotal();
        });
    });

    // Initially calculate the grand total when the page loads
    calculateGrandTotal();
</script>

</body>
</html>
@endsection






