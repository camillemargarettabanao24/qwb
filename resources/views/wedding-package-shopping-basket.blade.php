@extends ('layouts.customer')

@section('content')

    <body>
        <div class="basket-container">
            <div class="shopping-basket">
                <div class="title">
                    Shopping Basket
                </div>

                @foreach ($wpItems as $item)
                    <div class="item">
                        <div class="buttons">
                            <div class="add-appointment">
                                <input type="checkbox" name="appointment[]" value="{{ $item->id }}">
                            </div>
                        </div>

                        <div class="basket-image">

                        </div>

                        <div class="description">
                            <h4> {{ $item->bride_gown }}</h4>
                            <span>color: {{ $item->bride_color }}</span>
                            <br>
                            <h4> {{ $item->groom_suit }}</h4>
                            <span>color: {{ $item->groom_color }}</span>
                            <br>
                            <h4> {{ $item->maid_of_honor }}</h4>
                            <span>color: {{ $item->moh_color }}</span>
                            <br>
                            <h4> {{ $item->bestman }}</h4>
                            <span>color: {{ $item->bestman_color }}</span>
                            <br>
                            <h4> {{ $item->bridesmaid_set }}</h4>
                            <span>color: {{ $item->bridesmaid_set_color }}</span>
                            <br>
                            <h4> {{ $item->groomsmen_set }}</h4>
                            <span>color: {{ $item->groomsmen_set_color }}</span>
                            <br>
                            <h4> {{ $item->bearers_set }}</h4>
                            <span>color: {{ $item->bearers_set_color }}</span>
                            <br>
                            <h4> {{ $item->flowerG_set }}</h4>
                            <span>color: {{ $item->flowerG_set_color }}</span>
                            <br>
                            <h4> {{ $item->bride_father }}</h4>
                            <span>color: {{ $item->bride_father_color }}</span>
                            <br>
                            <h4> {{ $item->groom_father }}</h4>
                            <span>color: {{ $item->groom_father_color }}</span>
                            <br>
                            <h4> {{ $item->bride_mother }}</h4>
                            <span>color: {{ $item->bride_mother_color }}</span>
                            <br>
                            <h4> {{ $item->groom_mother }}</h4>
                            <span>color: {{ $item->groom_mother_color }}</span>
                        </div>

                        <div class="total-price">
                            <span><i class="fas fa-trash-alt"></i></span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="app-res-container">
                <div class=appointment-res-button>
                    <button type="submit" id="addAppointmentBtn">Add Appointment</button>
                    <button type="submit" id="addReservationBtn">Add Reservation</button>
                </div>
            </div>
            <script>
                // Function to handle adding appointment
                $('#addAppointmentBtn').on('click', function() {
                    // Array to store selected items
                    var selectedItems = [];

                    // Loop through all checkboxes
                    $('input[name="appointment[]"]:checked').each(function() {
                        // Add the item's ID to the selectedItems array
                        selectedItems.push($(this).val());
                    });

                    // Send the selectedItems array to the server or perform any desired action
                    console.log(selectedItems); // For demonstration, you can replace this with your logic
                });
            </script>

            <script>
                $('.like-btn').on('click', function() {
                    $(this).toggleClass('is-active');
                });

                $('.minus-btn').on('click', function(e) {
                    e.preventDefault();
                    var $this = $(this);
                    var $input = $this.closest('div').find('input');
                    var value = parseInt($input.val());

                    if (value > 0) {
                        value = value - 1;
                    } else {
                        value = 0;
                    }

                    $input.val(value);
                });

                $('.plus-btn').on('click', function(e) {
                    e.preventDefault();
                    var $this = $(this);
                    var $input = $this.closest('div').find('input');
                    var value = parseInt($input.val());

                    if (value < 100) {
                        value = value + 1;
                    } else {
                        value = 100;
                    }

                    $input.val(value);
                });
            </script>
    </body>

    </html>
@endsection
