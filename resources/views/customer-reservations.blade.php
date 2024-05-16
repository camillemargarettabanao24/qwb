@extends ('layouts.customer')


@section('content')
    <!-- products --> 

    <body class="customer-details">
                    @if ($isEmptyReservation)
                        <h2 style="margin:3em">You have no reservations.</h2>
                    @endif

            <div class="cus-res-title">
                <h2 class="h2-app">Reservation Details</h2>
            </div>

    @foreach($reservations as $reservation)
        <div class="iphone-reservations"> 

            <div id="selectedItems" class="shopping-basket-app-create">
            @foreach($reservation->basket as $basket)

                    <div class="item">
                        <div class="basket-image">
                            @if(isset($productImages[$basket->product->id]))
                                <img src="{{ $productImages[$basket->product->id]->image_path }}" alt="{{ $basket->product->item }}">
                            @endif                     
                        </div>
                        <div class="quantity-res-create">
                            <span>Color: {{ $basket->color }}</span><br>
                            <span>Accessory: {{ $basket->accessories }}</span>
                        </div>
                        <div class="quantity-res-create">
                            <span> Quantity: {{ $basket->quantity }}</span><br>
                            <span> Quantity: {{ $basket->acc_quantity }}</span>
                        </div>
                        <div class="total-price-cus-res">₱{{ number_format($basket->total_price, 2, '.', ',') }}</div>
                    </div>
        @endforeach

                @foreach ($reservation->weddingPackageBasket as $basket)

                    <h4>Wedding Package</h4>
                    <div class="app-res-item-wp">
                        <div class="basket-image-wp">
                            @if($basket->weddingPackageImage)
                                <img src="{{ $basket->weddingPackageImage->image_path }}" alt="{{ $basket->weddingPackage->item }}">
                            @endif
                        </div>
                        <div class="description-wrap">
                            <div class="description-wp">
                                <span>1. {{ $basket->bride_gown }}</span>
                                <span>Color: {{ $basket->bride_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>2. {{ $basket->groom_suit }}</span>
                                <span>Color: {{ $basket->groom_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>3. {{ $basket->maid_of_honor }}</span>
                                <span>Color: {{ $basket->moh_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>4. {{ $basket->bestman }}</span>
                                <span>Color: {{ $basket->bestman_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>5. {{ $basket->bridesmaid_set }}</span>
                                <span>Color: {{ $basket->bridesmaid_set_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>6. {{ $basket->groomsmen_set }}</span>
                                <span>Color: {{ $basket->groomsmen_set_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>7. {{ $basket->bearers_set }}</span>
                                <span>Color: {{ $basket->bearers_set_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>8. {{ $basket->flowerG_set }}</span>
                                <span>Color: {{ $basket->flowerG_set_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>9. {{ $basket->bride_father }}</span>
                                <span>Color: {{ $basket->bride_father_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>10. {{ $basket->groom_father }}</span>
                                <span>Color: {{ $basket->groom_father_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>11. {{ $basket->bride_mother }}</span>
                                <span>Color: {{ $basket->bride_mother_color }}</span>

                            </div>
                            <div class="description-wp">
                                <span>12. {{ $basket->groom_mother }}</span>
                                <span>Color: {{ $basket->groom_mother_color }}</span>

                            </div>
                        </div>
                        <div class="total-price-app-wp">
                            @if($basket->weddingPackage)
                                 ₱{{number_format($basket->weddingPackage->price, 2, '.', ',')}}
                            @endif
                        </div>
                    </div>
                @endforeach

                <div style="margin:1em; color: red" class="total-price-app-wp">
                    Total:  ₱{{number_format($reservation->total_res_price,2, '.',',') }}
                </div>
            </div>

            <div class="form">
                <div class="address">

                    <div class="card-reservation">
                        <address class="address">
                            @if ($user)
                                <strong>{{ $user->fname }} {{ $user->lname }}</strong>
                            @endif
                            <br><br>
                            Phone number: <br>
                            <span style ="color:grey">{{$reservation->phone_number}}</span><br>

                            Complete Address:<br>
                                <p style ="color:grey">{{$reservation->barangay}} {{$reservation->city_municipality}} {{$reservation->province}}</p>
                            <br>
                                <strong>Payment Details</strong><br>
                                <span>Payment Method</span><br>
                                <span style ="color:grey">{{$reservation->payment_method}}</span>
                                <br>
                                <span>Payment Deposit</span><br>
                                <span style ="color:grey">{{$reservation->payment_deposit}}</span><br><br>
                                <strong> Schedule</strong><br>
                            <label for="timeSelect">Pick up time:</label><br>
                                <span style ="color:grey">{{$reservation->reservation_time}}</span>
                            <br> <p style="color:green; font-size:14px">*pick-up date and time is the day before the reserved date*</p>
                            <label for="selected-day">Reservation Date:</label><br>
                                <span style ="color:grey">{{$reservation->reservation_date}}</span><br><br>

                                <strong>STATUS:</strong>

                                    @if ($reservation->status == 'pending')
                                        <strong style="color:red">
                                            {{$reservation->status}}
                                        </strong>
                                    @else
                                        <strong style="color:green">
                                            {{$reservation->status}}
                                        </strong>
                                    @endif
                        </address>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </body>


   
    </html>
@endsection
