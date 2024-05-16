@extends ('layouts.admin')

@section ('admin-content')

<div class="app-container">
  <div class="sidebar">
 
    <ul class="sidebar-list">
      <!-- <li class="sidebar-list-item">
        <a href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          <span>Home</span>
        </a>
      </li> -->
      <li class="sidebar-list-item" >
        <a href="{{route('admin.admin-home')}}">
        <i class="far fa-calendar-check" ></i><span>Reservations</span>
        </a>
      </li>
      <li class="sidebar-list-item" >
        <a href="{{route ('admin.admin-appointments') }}">
        <i class="fas fa-calendar-alt" ></i><span>Appointments</span>
        </a>
      </li>
      <li class="sidebar-list-item" style="background-color: #f085c3; ">
        <a style="color:white" href="{{route ('admin.admin-rented')}}">
        <i class="fas fa-tshirt" ></i><span>Rented</span>
        </a>
      </li>
      <li  class="sidebar-list-item">
        <a  href="{{route('admin.admin-products')}}">
        <i class="fas fa-box-open" ></i><span>Products</span>
        </a>
      </li>
      <li class="sidebar-list-item">
      <a href="{{route('admin.reports')}}">
          <i class="fas fa-newspaper" style="margin-right: 1em"></i><span>Reports</span>
        </a>
      </li>

      <li class="sidebar-list-item">
        <a href="{{route('admin.admin-activity-logs')}}">
            <i class="far fa-clock" style="margin-right: 1em"></i><span>Activity Logs</span>
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
        <div class="product-content-actions">
            <input class="search-bar" id="find" placeholder="Search..." type="text" onkeyup="search()">
            <div class="app-content-actions-wrapper">
                <div class="filter-button-wrapper">
                    <select class="action-button">
                        <option disabled selected>Status</option>
                        <option value="">Pending</option>
                        <option value="">Reserved</option>
                    </select>
                </div>
            </div>
        </div>
      <div class="products-area-wrapper appointmentView">
        <div class="products-header">
            <div class="staff-app-header">
                <span>Customer</span>
            </div>
            <div class="staff-app-header">
                <span>Time</span>
            </div>
            <div class="staff-app-header">
                <span>Date</span>
            </div>
            <div class="staff-app-header">
                <span>Payment <br> Method</span>
            </div>
            <div class="staff-app-header">
                <span>Payment <br> Deposit</span>
            </div>
            <div class="staff-app-header">
                <span>Image</span>
            </div>
            <div class="staff-app-header">
                <span>Color</span>
            </div>
            <div class="staff-app-header">
                <span>Quantity</span>
            </div>
            <div class="staff-app-header">
                <span>Accessories</span>
            </div>
            <div class="staff-app-header">
                <span>Quantity</span>
            </div>
            <div class="staff-app-header">
                <span>Total Price</span>
            </div>
            <div class="staff-app-header">
                <span>Status</span>
            </div>
        
        </div>

        @if ($isEmptyRents)
            <h4 style="margin:3em">There are no rented items.</h4>
        @endif

        @foreach ($reservations as $reservation) 

        <div class="appointments-row" style="">
            
            <div class="app-items">
                    <div class="staff-app-items">
                        <div class="app-details">
                            <div class="product-cell">
                                <span class="cell-label"></span>{{$reservation->customer->fname}} <br>
                                {{$reservation->customer->lname}}
                            </div>
                        </div>
                        <div class="app-details">
                            <div class="product-cell">
                                <span class="cell-label"></span>{{$reservation->reservation_time}}
                            </div>
                        </div>
                        <div class="app-details">
                            <div class="product-cell">
                                <span class="cell-label"></span>{{ date('F d, Y', strtotime($reservation->reservation_date)) }}
                            </div>
                        </div>
                        <div class="app-details">
                            <div class="product-cell">
                                 @if($reservation->payment_method == 'Gcash' )
                                    <span class="cell-label"></span> 
                                        {{$reservation->payment_method}}
                                        <button style="text-decoration: underline; background-color:transparent; color: blue " onclick="openModal('{{ $reservation->id }}')">View Details</button>   
                                @else
                                    <span class="cell-label"></span>
                                        {{$reservation->payment_method}}
                                @endif
                            </div>

                            <!-- modal -->
                            <div id="reservationModal{{ $reservation->id }}" class="modal">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal('{{ $reservation->id }}')">&times;</span>
                                    <div class="modal-body">
                                        <h2>PAYMENT DETAILS</h2>
                                        <h4>Payment Method: {{ $reservation->payment_method }}</h4>
                                        <h4>Account Name: {{ $reservation->account_name }}</h4>
                                        <h4>Account Number: {{ $reservation->account_number }}</h4> <br><br>
                                        <img style="width:50%; object-fit:contain" src="{{ asset($reservation->image_path) }}" alt="Reservation Screenshot">
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                        </div>
                        <div class="app-details">
                            <div class="product-cell">
                                <span class="cell-label"></span>{{ $reservation->payment_deposit }}
                            </div>
                        </div>
                    </div>
                <div class="parent-staff-app-items">
                    @foreach($reservation->basket as $basket)
                        <div class="staff-app-items2">
                                <div class="product-cell image">
                                        @if(isset($productImages[$basket->product->id]))
                                            <img src="{{ $productImages[$basket->product->id]->image_path }}" alt="{{ $basket->product->item }}">
                                        @endif            
                                    <div class=" item">{{$reservation->item}}</div>
                                </div>
                                
                                <div class="product-cell">
                                        {{$basket->color}} <br>
                                </div>
                                <div class="product-cell">
                                        {{$basket->quantity}} <br>
                                </div>
                                <div class="product-cell">
                                        {{$basket->accessories}} <br>
                                </div>
                                <div class="product-cell">
                                        {{$basket->acc_quantity}} <br>
                                </div>
                                
                            </div>

                    @endforeach
                </div>
                                <div class="staff-app-items3">
                                    <div class="app-details">
                                        <div class="product-cell">
                                            <span class="cell-label"></span>
                                        ₱{{ number_format($reservation->total_res_price,2, '.', ',')}}
                                        </div>
                                    </div>
                                </div>
                                <div class="staff-app-items4">
                                    <div class="app-details">
                                    @if ($reservation->status == 'Ongoing')
                                        <div class="product-cell" style="color:red">
                                            <strong>
                                                {{$reservation->status}}
                                            </strong>
                                        </div>
                                    @else
                                        <div class="product-cell" style="color:green">
                                            <strong>
                                                {{$reservation->status}}
                                            </strong>
                                        </div>
                                    @endif
                                        
                                    </div>
                                </div>
                    </div>

                    @if($reservation->weddingPackageBasket->isEmpty())
                    @else
                        <div class="products-header-wp">
                            <span>Wedding Package</span>
                        </div>

                        @foreach($reservation->weddingPackageBasket as $basket)
                            <div class="staff-app-items2">
                                    <div class="product-cell image">
                                            @if(isset($WeddingProductImages[$basket->weddingPackage->id]))
                                                <img src="{{ $WeddingProductImages[$basket->weddingPackage->id]->image_path }}" alt="{{ $basket->weddingPackage->item }}">
                                            @endif            
                                        <div class=" item">{{$reservation->item}}</div>
                                    </div>
                                    
                                    <div class="product-cell" style="text-align: left">
                                        1. {{ $basket->bride_gown }} <br>
                                        2. {{ $basket->groom_suit }} <br>
                                        3. {{ $basket->maid_of_honor }} <br>
                                        4. {{ $basket->bestman }} <br>
                                        5. {{ $basket->bridesmaid_set }} <br>
                                        6. {{ $basket->groomsmen_set }} <br>
                                        7. {{ $basket->bearers_set }} <br>
                                        8. {{ $basket->flowerG_set }} <br>
                                        9. {{ $basket->bride_father }} <br>
                                        10. {{ $basket->groom_father }}  <br>
                                        11. {{ $basket->bride_mother }} <br>
                                        12. {{ $basket->groom_mother }} <br>

                                    </div>
                                    <div class="product-cell" style="text-align: left">
                                        {{ $basket->bride_color }} <br>
                                        {{ $basket->groom_color }} <br>
                                        {{ $basket->moh_color }} <br>
                                        {{ $basket->bestman_color }} <br>
                                        {{ $basket->bridesmaid_set_color }} <br>
                                        {{ $basket->groomsmen_set_color }} <br>
                                        {{ $basket->bearers_set_color }} <br>
                                        {{ $basket->flowerG_set_color }} <br>
                                        {{ $basket->bride_father_color }} <br>
                                        {{ $basket->groom_father_color }} <br>
                                        {{ $basket->bride_mother_color }} <br>
                                        {{ $basket->groom_mother_color }} <br>
                                    </div>
                                </div>
                                
                        @endforeach
                    @endif
            </div>

            <script>
                function confirmReturn(url) {
                    if (confirm('Are you sure you want to confirm return?')) {
                        // Remove the button from the DOM
                        document.getElementById('completeButton{{ $reservation->id }}').style.display = 'none';

                        // Redirect to mark the appointment as completed
                        window.location.href = url;
                    }
                }
            </script>
               

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

<script>
    // Function to open the modal
    function openModal(reservationId) {
        // Get the modal element by its ID
        var modal = document.getElementById('reservationModal' + reservationId);
        
        // Display the modal by changing its style display property to "block"
        modal.style.display = "block";
    }

    // Function to close the modal
    function closeModal(reservationId) {
        // Get the modal element by its ID
        var modal = document.getElementById('reservationModal' + reservationId);
        
        // Hide the modal by changing its style display property to "none"
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        // Check if the clicked element is a modal
        if (event.target.className === "modal") {
            // Close the modal
            event.target.style.display = "none";
        }
    }

</script>







@endsection 
