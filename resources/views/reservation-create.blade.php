@extends ('layouts.customer') 


@section('content')
    <!-- products -->

    <body class="customer-details">

        <div class="iphone">
            @php
                $totalPrice = 0; // Initialize total price variable
            @endphp


            <div id="selectedItems" class="shopping-basket-app-create">
                @foreach ($basketItems as $item)
                    <input type="hidden" name="shopping_basket_id[]" value="{{ $item->id }}">

                    <div class="item">
                        <div class="basket-image">
                                @if(isset($productImages[$item->product->id]))
                                    <img src="{{ $productImages[$item->product->id]->image_path }}" alt="{{ $item->product->item }}">
                                @endif                        
                        </div>
                        <div class="description">
                            <span>{{ $item->product->item }}</span>
                            <span>Color: {{ $item->color }}</span>
                            <span>Accessory: {{ $item->accessories }}</span>
                        </div>
                        <div class="quantity-app-create">
                            <span>Color Quantity: {{ $item->quantity }}</span><br>
                            <span>Accessory Quantity: {{ $item->acc_quantity }}</span>
                        </div>
                        <div class="total-price">₱{{ number_format($item->total_price, 2, '.', ',') }}</div>
                        @php
                            $totalPrice += $item->total_price; // Add item price to total
                        @endphp
                    </div>
                @endforeach

                @foreach ($wpItems as $item)
                    <input type="hidden" name="wp_basket_id[]" value="{{ $item->id }}">

                    <h4>Wedding Package</h4>
                    <div class="app-res-item-wp">
                        <div class="basket-image-wp">
                            @if ($item->weddingPackageImage)
                                <img src="{{ $item->weddingPackageImage->image_path }}" alt="{{ $item->weddingPackage->item }}">
                            @endif
                        </div>
                        <div class="description-wrap">
                            <div class="description-wp">
                                <span>1. {{ $item->bride_gown }}</span>
                                <span>Color: {{ $item->bride_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>2. {{ $item->groom_suit }}</span>
                                <span>Color: {{ $item->groom_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>3. {{ $item->maid_of_honor }}</span>
                                <span>Color: {{ $item->moh_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>4. {{ $item->bestman }}</span>
                                <span>Color: {{ $item->bestman_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>5. {{ $item->bridesmaid_set }}</span>
                                <span>Color: {{ $item->bridesmaid_set_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>6. {{ $item->groomsmen_set }}</span>
                                <span>Color: {{ $item->groomsmen_set_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>7. {{ $item->bearers_set }}</span>
                                <span>Color: {{ $item->bearers_set_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>8. {{ $item->flowerG_set }}</span>
                                <span>Color: {{ $item->flowerG_set_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>9. {{ $item->bride_father }}</span>
                                <span>Color: {{ $item->bride_father_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>10. {{ $item->groom_father }}</span>
                                <span>Color: {{ $item->groom_father_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>11. {{ $item->bride_mother }}</span>
                                <span>Color: {{ $item->bride_mother_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>12. {{ $item->groom_mother }}</span>
                                <span>Color: {{ $item->groom_mother_color }}</span>

                            </div>
                        </div>
                        <div class="total-price-app-wp">
                            ₱{{ number_format($item->weddingPackage->price, 2, '.', ',') }}
                        </div>
                    </div>
                    @php
                        $totalPrice += $item->weddingPackage->price; // Add wedding package price to total
                    @endphp
                @endforeach
                <div style="margin:1em; color: red" class="total-price-app-wp">
                    Total: ₱{{ number_format($totalPrice, 2,'.',',') }}
                </div>
            </div>


        <form action="{{ route('reservation-store') }}" class="form" method="POST" enctype="multipart/form-data" id="reservation_form">
                @csrf

                @if($customerId)
                    <input type="hidden" name="customer_id" value="{{$customerId->id}}">
                @endif

               
            @if ($basketItems->isNotEmpty())
                @foreach ($basketItems as $item)
                    <input type="hidden" name="shopping_basket_id[]" value="{{ $item->id }}">
                @endforeach
            @endif

            @if ($wpItems->isNotEmpty())
                @foreach ($wpItems as $item)
                    <input type="hidden" name="wp_basket_id[]" value="{{ $item->id }}">
                @endforeach
            @endif

                    <input type="hidden" name="total_res_price" value="{{ $totalPrice }}">

                <div class="address">
                    <h2 class="h2-app">Customer Details</h2>

                    <div class="card">
                        <address class="address">
                            @if ($user)
                                <strong>{{ $user->fname }} {{ $user->lname }}</strong>
                            @endif
                            <br><br>
                            Phone number <br>
                              <span>fnofie</span> <br>
                            Complete Address <br>
                              <span>huhu</span><br><br>
                           
                            <label for="timeSelect">Pick-up Time:</label>
                                <select class="time-select" id="timeSelect" name="reservation_time" required>
                                <option disabled selected>--select time--</option>
                                <option value="08:00 AM">8:00 AM</option>
                                <option value="09:00 AM">9:00 AM</option>
                                <option value="10:00 AM">10:00 AM</option>
                                <option value="11:00 AM">11:00 AM</option>
                                <option value="1:00 PM">1:00 PM</option>
                                <option value="2:00 PM">2:00 PM</option>
                                <option value="3:00 PM">3:00 PM</option>
                                <option value="4:00 PM">4:00 PM</option>
                            </select>
                            <p style="color:red; font-size:10px">*pick-up date and time should be the day before the reserved date*</p>

                            <br>
                            <label for="selected-day">Reservation Date:</label><br>
                                <input type="text" style="color:green" id="selected-day" name="reservation_date">

                        </address>
                    </div>
                </div>

                <h2 class="h2-app">Reservation Date</h2>
                <div class="calendar-appointment">
                    <div class="wrapper">
                        <div class="header">
                            <div class="navigation" style="display:flex; align-items: center; justify-content:center;">
                                <span style="margin:1em" id="prevYear" class="fas fa-arrow-left"></span>
                                <span style="margin:1em" id="prevMonth" class="fas fa-chevron-left"></span>
                                <strong class="current-date"></strong>
                                <span style="margin:1em" id="nextMonth" class="fas fa-chevron-right"></span>
                                <span style="margin:1em" id="nextYear" class="fas fa-arrow-right"></span>
                            </div>
                        </div>
                        <div class="calendar">
                            <ul class="weeks">
                                <li>Sun</li>
                                <li>Mon</li>
                                <li>Tue</li>
                                <li>Wed</li>
                                <li>Thu</li>
                                <li>Fri</li>
                                <li>Sat</li>
                            </ul>
                            <ul class="days"></ul>
                        </div>
                    </div>
                </div>


                <fieldset>
                    <legend>Payment Deposit</legend>
                    <div class="form__radios">
                        <div class="form__radio">
                            <label style="font-size: 14px" for="downpayment">
                                Downpayment - ₱{{ number_format($totalPrice / 2, 2, '.', ',') }}
                            </label>
                            <input id="downpayment" name="payment_deposit" type="radio" value="Downpayment - ₱{{ number_format($totalPrice / 2, 2, '.', ',') }}" />
                        </div>
                        <div class="form__radio">
                            <label style="font-size: 14px;" for="fullpayment">
                                Full Payment - ₱{{ number_format($totalPrice, 2, '.', ',') }}
                            </label>
                            <input id="fullpayment" name="payment_deposit" type="radio" value="Full Payment - ₱{{ number_format($totalPrice, 2, '.', ',') }}"/>
                        </div> 
                    </div>
                </fieldset>


                <fieldset>
                  <legend>Payment Method</legend>

                  <div class="form__radios">
                    <div class="form__radio">
                      <label style="font-size: 14px" for="gcash">Gcash</label>
                      <input id="gcash" name="payment_method" type="radio" value="Gcash" />
                    </div>
                    <div id="accountDetails" class="hidden">
                      <h3>Input Account Details</h3>
                        <p>Send Payment to: Jonalyn Dela Cruz</p><p>Number: 09979226974</p>
                        
                          <label for="accountName">Account Name:</label>
                              <input id="accountName" style="border-radius:4px" type="text" name="account_name" ><br>

                          <label for="accountNumber">Account Number:</label>
                                <input id="accountNumber" style="border-radius:4px" name="account_number" class="" type="tel" pattern="^[0-9]*$" maxlength="11" value=""><br>

                          <label for="screenshot">Payment Screenshot:</label>
                              <input id="screenshot" type="file" style="border-radius:4px; background-color:white; border-none;" name="image_path"><br>

                    </div>
                    <div class="form__radio">
                      <label style="font-size: 14px" for="cash">Cash</label>
                      <input id="cash" name="payment_method" type="radio" value="Cash" />
                    </div>
                        <input type="hidden" name="status" id="status-input" value="pending" />
                  </div>
                </fieldset>

                  

                <div class="confirmation-res" >
                    <input type="checkbox" name="confirmation" value="confirmed" required>
                    <p>I confirm that all the information I have provided is accurate and authentic.
            I understand that if the rental time exceeds the agreed rental period, a charge of  ₱100.00 per day will be imposed.
            Furthermore, damaged or lost items should be paid with the appropriate amount.</p>
                </div>
                
                <div class="confirmation-p" >
                    <p>Once payment is made, it's NON-REFUNDABLE.</p>
                </div>
            

                <div class="button-container">
                    <button class="button button--full" type="submit"> Confirm Reservation</button>
                </div>

                @if ($basketItems->isEmpty())
                    <input type="hidden" name="shopping_basket_id[]" value="">
                @endif

                <!-- Error handling for empty wedding package items -->
                @if ($wpItems->isEmpty())
                    <input type="hidden" name="wp_basket_id[]" value="">
                @endif
        </form>
                        </div>
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
    </body>

<script>
    function handleReservation() {
        const reservation_form = document.getElementById('reservation_form');
        const form_data = new FormData(reservation_form);

        const basket_ids = document.querySelectorAll('input[name="shopping_basket_id"]:checked').forEach(function(element) {
            form_data.append('shopping_basket_id[]', element.value);
        });

        const wp_basket_ids = document.querySelectorAll('input[name="wp_basket_id"]:checked').forEach(function(element) {
            form_data.append('wp_basket_id[]', element.value);
        });

        fetch('/reservation-create/store', {
            method: 'POST',
            body: form_data,
        })
        .then(response => response.json())
        .then(data => {
            window.location.href = "/customer-receipt";
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
</script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
        var cashRadio = document.getElementById('cash');
        var statusInput = document.getElementById('status-input');

        cashRadio.addEventListener('change', function() {
            statusInput.value = 'pending';
        });

        cashRadio.addEventListener('click', function() {
            statusInput.value = 'pending';
        });
        });

</script>

<script>
        const gcashRadio = document.getElementById('gcash');
        const cashRadio = document.getElementById('cash');

        // Get the account details container
        const accountDetails = document.getElementById('accountDetails');

        // Initially hide the account details
        accountDetails.classList.add('hidden');

        gcashRadio.addEventListener('change', function() {
            if (this.checked) {
                accountDetails.classList.remove('hidden');
            } else {
                accountDetails.classList.add('hidden');
            }
        });

        cashRadio.addEventListener('change', function() {
            if (this.checked) {
                accountDetails.classList.add('hidden');
            }
        });
</script>


<!-- Calendar -->
<script>
    const daysTag = document.querySelector(".days"),
        currentDate = document.querySelector(".current-date"),
        prevMonthIcon = document.getElementById("prevMonth"),
        nextMonthIcon = document.getElementById("nextMonth"),
        prevYearIcon = document.getElementById("prevYear"),
        nextYearIcon = document.getElementById("nextYear"),
        selectedDayInput = document.getElementById("selected-day");

    let selectedDay = null;

    let date = new Date(), // Current date by default
        currYear = date.getFullYear(),
        currMonth = date.getMonth(); // Zero-indexed month

    const months = ["January", "February", "March", "April", "May", "June", "July",
        "August", "September", "October", "November", "December"
    ];

    const renderCalendar = (reservationDates) => {
        let today = new Date(); // Get current date in local timezone
        let liTag = "";

        // Add empty <li> elements for the days before the first day of the current month
        for (let i = new Date(currYear, currMonth, 1).getDay(); i > 0; i--) {
            liTag += `<li class="inactive">${new Date(currYear, currMonth, 0).getDate() - i + 1}</li>`;
        }

        // Add <li> elements for the days of the current month
        for (let i = 1; i <= new Date(currYear, currMonth + 1, 0).getDate(); i++) {
            let isReserved = reservationDates.includes(`${currYear}-${currMonth + 1}-${i}`);
            let isPast = new Date(currYear, currMonth, i) < today;
            let isActive = !(isReserved || isPast);
            let isToday = i === today.getDate() && currMonth === today.getMonth() &&
                currYear === today.getFullYear();

            if (isReserved || isPast) {
                liTag += `<li class="inactive${isReserved ? ' reserved' : ''}">${i}</li>`;
            } else {
                let isTodayClass = isToday ? 'active' : '';
                liTag += `<li class="${isTodayClass}" onclick="handleDaySelect(${i})">${i}</li>`;
            }
        }

        currentDate.innerText = `${months[currMonth]} ${currYear}`;
        daysTag.innerHTML = liTag;
    };

    const handleDaySelect = (day) => {
        selectedDay = day;
        updateSelectedDateInput();
        renderCalendar([]);
    };

    const updateSelectedDateInput = () => {
        if (selectedDay !== null) {
            const selectedDate = new Date(currYear, currMonth, selectedDay);
            const options = { month: 'long', day: 'numeric', year: 'numeric' };
            const formattedDate = selectedDate.toLocaleDateString('en-US', options);
            selectedDayInput.value = formattedDate;
        }
    };

    renderCalendar([]);

    prevMonthIcon.addEventListener("click", () => {
        if (currMonth === 0) {
            currYear--;
            currMonth = 11;
        } else {
            currMonth--;
        }
        renderCalendar([]);
    });

    nextMonthIcon.addEventListener("click", () => {
        if (currMonth === 11) {
            currYear++;
            currMonth = 0;
        } else {
            currMonth++;
        }
        renderCalendar([]);
    });

    prevYearIcon.addEventListener("click", () => {
        currYear--;
        renderCalendar([]);
    });

    nextYearIcon.addEventListener("click", () => {
        currYear++;
        renderCalendar([]);
    });

</script>







    </html>
@endsection
