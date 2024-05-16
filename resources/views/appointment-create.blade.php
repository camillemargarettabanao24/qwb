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
                        <div class="total-price-app-create">₱{{ $item->total_price }}</div>
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
                            ₱{{ $item->weddingPackage->price }}.00
                        </div>
                    </div>
                    @php
                        $totalPrice += $item->weddingPackage->price; // Add wedding package price to total
                    @endphp
                @endforeach
                <div style="margin:1em; color: red" class="total-price-app-wp">
                    Total: ₱{{ $totalPrice }}.00
                </div>
            </div>


            <form action="{{ route('appointment-store') }}" class="form" method="POST">
                @csrf

                @if($customerId)
                    <input type="hidden" name="customer_id" value="{{$customerId->id}}">
                @endif

                @foreach ($basketItems as $item)
                    <input type="hidden" name="shopping_basket_id[]" value="{{ $item->id }}">
                @endforeach

                @foreach ($wpItems as $item)
                    <input type="hidden" name="wp_basket_id[]" value="{{ $item->id }}">
                @endforeach

                    <input type="hidden" name="total_app_price" value="{{ $totalPrice }}">

                <div class="address">
                    <h2 class="h2-app">Customer Details</h2>

                    <div class="card">
                        <address class="address">
                            @if ($user)
                                <strong>{{ $user->fname }} {{ $user->lname }}</strong>
                            @endif
                            <br><br>
                            Phone number
                            <input id="phoneNumber" name="phone_number" class="number" type="tel" pattern="^\+63[0-9]*$"
                                maxlength="13" required value="+63"><br>
                            Complete Address<br>
                            <label for="province">- Province</label>
                            <select class="address-app" id="province" name="province" required>
                                <option disabled selected>--select--</option>
                                <option value="Negros Oriental">Negros Oriental</option>
                            </select>
                            <br>
                            <label for="city/municipality">- City/Municipality</label>
                                <select class="address-app" id="city/municipality" name="city_municipality" required>
                                    <option disabled selected>--select--</option>
                                    <option value="Amlan">Amlan</option>
                                    <option value="Ayungon">Ayungon</option>
                                    <option value="Bacong">Bacong</option>
                                    <option value="Bais">Bais</option>
                                    <option value="Basay">Basay</option>
                                    <option value="Bayawan">Bayawan</option>
                                    <option value="Bindoy">Bindoy</option>
                                    <option value="Dauin">Dauin</option>
                                    <option value="Dumaguete">Dumaguete</option>
                                    <option value="Guihulngan">Guihulngan</option>
                                    <option value="Jimalalud">Jimalalud</option>
                                    <option value="La Libertad">La Libertad</option>
                                    <option value="Mabinay">Mabinay</option>
                                    <option value="Manjuyod">Manjuyod</option>
                                    <option value="Pamplona">Pamplona</option>
                                    <option value="San Jose">San Jose</option>
                                    <option value="Santa Catalina">Santa Catalina</option>
                                    <option value="Siaton">Siaton</option>
                                    <option value="Sibulan">Sibulan</option>
                                    <option value="Tanjay">Tanjay</option>
                                    <option value="Tayasan">Tayasan</option>
                                    <option value="Valencia">Valencia</option>
                                    <option value="Vallehermoso">Vallehermoso</option>
                                    <option value="Zamboanguita">Zamboanguita</option>

                                </select>
                            <br>
                            <label for="barangay">- Barangay</label>
                            <select class="address-app" id="barangay" name="barangay" required>
                                <option disabled selected>--select--</option>
                                <option value=""></option>
                            </select>
                            <br><br>
                            <label for="timeSelect">Appointment Time:</label>
                                <select class="time-select" id="timeSelect" name="appointment_time" required>
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
                            <br>
                            <label for="selected-day">Appointment Date:</label><br>
                            <input type="text" style="color:green" id="selected-day" name="appointment_date">

                        </address>
                    </div>
                </div>
                <h2 class="h2-app">Appointment Date</h2>
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

                <div class="confirmation" style="display:flex; align-items:center">
                    <input type="checkbox" name="confirmation" value="confirmed" required>
                    <p>I confirm that all the information I have provided is accurate and
                        authentic.</p>
                </div>

                <div class="button-container">
                    <button class="button button--full" type="submit"> Confirm Appointment</button>
                </div>
            </form>
        </div>

    </body>

    
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

    <script>
        const barangayAddresses = {
            "Amlan": [
                "Bio-os",
                "Jantianon",
                "Jugno",
                "Mag-abo",
                "Poblacion",
                "Silab",
                "Tambojangin",
                "Tandayag"
            ],
            "Ayungon": [
                "Amdus",
                "Anibong",
                "Atabay",
                "Awa-an",
                "Ban-ban",
                "Calagcalag",
                "Candana-ay",
                "Carol-an",
                "Gomentoc",
                "Inacban",
                "Iniban",
                "Jandalamanon",
                "Kilaban",
                "Lamigan",
                "Maaslum",
                "Mabato",
                "Manogtong",
                "Nabhang",
                "Poblacion",
                "Tambo",
                "Tampocon I",
                "Tampocon II",
                "Tibyawan",
                "Tiguib"
            ],
            "Bacong": [
                "Balayagmanok",
                "Banilad",
                "Buntis",
                "Buntod",
                "Calangag",
                "Combado",
                "Doldol",
                "Isugan",
                "Liptong",
                "Lutao",
                "Magsuhot",
                "Malabago",
                "Mampas",
                "North Poblacion",
                "Sacsac",
                "San Miguel",
                "South Poblacion",
                "Sulodpan",
                "Timbanga",
                "Timbao",
                "Tubod",
                "West Poblacion"
            ],
            "Bais": [
                "Barangay I",
                "Barangay II",
                "Basak",
                "Biñohon",
                "Cabanlutan",
                "Calasga-an",
                "Cambagahan",
                "Cambaguio",
                "Cambanjao",
                "Cambuilao",
                "Canlargo",
                "Capiñahan",
                "Consolacion",
                "Dansulan",
                "Hangyad",
                "Katacgahan",
                "La Paz",
                "Lo-oc",
                "Lonoy",
                "Mabunao",
                "Manlipac",
                "Mansangaban",
                "Okiot",
                "Olympia",
                "Panala-an",
                "Panam-angan",
                "Rosario",
                "Sab-ahan",
                "San Isidro",
                "Tagpo",
                "Talungon",
                "Tamisu",
                "Tamogong",
                "Tangculogan",
                "Valencia"
            ],
            "Basay": [
                "Actin",
                "Bal-os",
                "Bongalonan",
                "Cabalayongan",
                "Cabatuanan",
                "Linantayan",
                "Maglinao",
                "Nagbo-alao",
                "Olandao",
                "Poblacion"
            ],
            "Dauin": [
                "Anahawan",
                "Apo Island",
                "Bagacay",
                "Baslay",
                "Batuhon Dacu",
                "Boloc-boloc",
                "Bulak",
                "Bunga",
                "Casile",
                "Libjo",
                "Lipayo",
                "Maayongtubig",
                "Mag-aso",
                "Magsaysay",
                "Malongcay Dacu",
                "Masaplod Norte",
                "Masaplod Sur",
                "Panubtuban",
                "Poblacion I",
                "Poblacion II",
                "Poblacion III",
                "Tugawe",
                "Tunga-tunga"
            ],
            "Dumaguete": [
                "Bagacay",
                "Bajumpandan",
                "Balugo",
                "Banilad",
                "Bantayan",
                "Batinguel",
                "Bunao",
                "Cadawinonan",
                "Calindagan",
                "Camanjac",
                "Candau-ay",
                "Cantil-e",
                "Daro",
                "Junob",
                "Looc",
                "Mangnao-Canal",
                "Motong",
                "Piapi",
                "Poblacion No. 1",
                "Poblacion No. 2",
                "Poblacion No. 3",
                "Poblacion No. 4",
                "Poblacion No. 5",
                "Poblacion No. 6",
                "Poblacion No. 7",
                "Poblacion No. 8",
                "Pulantubig",
                "Tabuctubig",
                "Taclobo",
                "Talay"
            ],
            "Guihulngan": [
                "Bakid",
                "Balogo",
                "Banwaque",
                "Basak",
                "Binobohan",
                "Buenavista",
                "Bulado",
                "Calamba",
                "Calupa-an",
                "Hibaiyo",
                "Hilaitan",
                "Hinakpan",
                "Humayhumay",
                "Imelda",
                "Kagawasan",
                "Linantuyan",
                "Luz",
                "Mabunga",
                "Magsaysay",
                "Malusay",
                "Maniak",
                "Mckinley",
                "Nagsaha",
                "Padre Zamora",
                "Plagatasanon",
                "Planas",
                "Poblacion",
                "Sandayao",
                "Tacpao",
                "Tinayunan Beach",
                "Tinayunan Hill",
                "Trinidad",
                "Villegas"
            ],
            "Jimalalud": [
                "Aglahug",
                "Agutayon",
                "Apanangon",
                "Bae",
                "Bala-as",
                "Bangcal",
                "Banog",
                "Buto",
                "Cabang",
                "Camandayon",
                "Cangharay",
                "Canlahao",
                "Dayoyo",
                "Eli",
                "Lacaon",
                "Mahanlud",
                "Malabago",
                "Mambaid",
                "Mongpong",
                "North Poblacion",
                "Owacan",
                "Pacuan",
                "Panglaya-an",
                "Polopantao",
                "Sampiniton",
                "South Poblacion",
                "Talamban",
                "Tamao"
            ],
            "La Libertad": [
                "Aniniaw",
                "Aya",
                "Bagtic",
                "Biga-a",
                "Busilak",
                "Cangabo",
                "Cantupa",
                "Elecia",
                "Eli",
                "Guihob",
                "Kansumandig",
                "Mambulod",
                "Mandapaton",
                "Manghulyawon",
                "Manluminsag",
                "Mapalasan",
                "Maragondong",
                "Martilo",
                "Nasungan",
                "Pacuan",
                "Pangca",
                "Pisong",
                "Pitogo",
                "Poblacion North",
                "Poblacion South",
                "San Jose",
                "Solongon",
                "Tala-on",
                "Talayong"
            ],
            "Mabinay": [
                "Abis",
                "Arebasore",
                "Bagtic",
                "Banban",
                "Barras",
                "Bato",
                "Bugnay",
                "Bulibulihan",
                "Bulwang",
                "Campanun-an",
                "Canggohob",
                "Cansal-ing",
                "Dagbasan",
                "Dahile",
                "Hagtu",
                "Himocdongon",
                "Inapoy",
                "Lamdas",
                "Lumbangan",
                "Luyang",
                "Manlingay",
                "Mayaposi",
                "Napasu-an",
                "New Namangka",
                "Old Namangka",
                "Pandanon",
                "Paniabonan",
                "Pantao",
                "Poblacion",
                "Samac",
                "Tadlong",
                "Tara"
            ],
            "Manjuyod": [
                "Alangilanan",
                "Bagtic",
                "Balaas",
                "Bantolinao",
                "Bolisong",
                "Butong",
                "Campuyo",
                "Candabong",
                "Concepcion",
                "Dungo-an",
                "Kauswagan",
                "Lamogong",
                "Libjo",
                "Maaslum",
                "Mandalupang",
                "Panciao",
                "Poblacion",
                "Sac-sac",
                "Salvacion",
                "San Isidro",
                "San Jose",
                "Santa Monica",
                "Suba",
                "Sundo-an",
                "Tanglad",
                "Tubod",
                "Tupas"
            ],
            "Pamplona": [
                "Abante",
                "Balayong",
                "Banawe",
                "Calicanan",
                "Datagon",
                "Fatima",
                "Inawasan",
                "Magsusunog",
                "Malalangsi",
                "Mamburao",
                "Mangoto",
                "Poblacion",
                "San Isidro",
                "Santa Agueda",
                "Simborio",
                "Yupisan"
            ],
            "San Jose": [
                "Basac",
                "Basiao",
                "Cambaloctot",
                "Cancawas",
                "Janayjanay",
                "Jilocon",
                "Naiba",
                "Poblacion",
                "San Roque",
                "Santo Niño",
                "Señora Ascion",
                "Siapo",
                "Tampi",
                "Tapon Norte"
            ],
            "Santa Catalina": [
                "Alangilan",
                "Amio",
                "Buenavista",
                "Caigangan",
                "Caranoche",
                "Cawitan",
                "Fatima",
                "Kabulacan",
                "Mabuhay",
                "Manalongon",
                "Mansagomayon",
                "Milagrosa",
                "Nagbalaye",
                "Nagbinlod",
                "Obat",
                "Poblacion",
                "San Francisco",
                "San Jose",
                "San Miguel",
                "San Pedro",
                "Santo Rosario",
                "Talalak"
            ],
            "Siaton": [
                "Albiga",
                "Apoloy",
                "Bonawon",
                "Bonbonon",
                "Cabangahan",
                "Canaway",
                "Casala-an",
                "Caticugan",
                "Datag",
                "Giliga-on",
                "Inalad",
                "Malabuhan",
                "Maloh",
                "Mantiquil",
                "Mantuyop",
                "Napacao",
                "Poblacion I",
                "Poblacion II",
                "Poblacion III",
                "Poblacion IV",
                "Salag",
                "San Jose",
                "Sandulot",
                "Si-it",
                "Sumaliring",
                "Tayak"
            ],
            "Sibulan": [
                "Agan-an",
                "Ajong",
                "Balugo",
                "Bolocboloc",
                "Calabnugan",
                "Cangmating",
                "Enrique Villanueva",
                "Looc",
                "Magatas",
                "Maningcao",
                "Maslog",
                "Poblacion",
                "San Antonio",
                "Tubigon",
                "Tubtubon"
            ],
            "Tanjay": [
                "Azagra",
                "Bahi-an",
                "Luca",
                "Manipis",
                "Novallas",
                "Obogon",
                "Pal-ew",
                "Poblacion I",
                "Poblacion II",
                "Poblacion III",
                "Poblacion IV",
                "Poblacion IX",
                "Poblacion V",
                "Poblacion VI",
                "Poblacion VII",
                "Poblacion VIII",
                "Polo",
                "San Isidro",
                "San Jose",
                "San Miguel",
                "Santa Cruz Nuevo",
                "Santa Cruz Viejo",
                "Santo Niño",
                "Tugas"
            ],
            "Tayasan": [
                "Bacong",
                "Bago",
                "Banga",
                "Cabulotan",
                "Cambaye",
                "Dalaupon",
                "Guincalaban",
                "Ilaya-Tayasan",
                "Jilabangan",
                "Lag-it",
                "Linao",
                "Lutay",
                "Maglihe",
                "Magtuhao",
                "Matauta",
                "Matuog",
                "Numnum",
                "Palaslan",
                "Pinalubngan",
                "Pindahan",
                "Pinocawan",
                "Poblacion",
                "Putingbato",
                "San Isidro",
                "San Jose",
                "Talalak",
                "Tampi",
                "Tanañas",
                "Tigbao",
                "Tinayunan Beach",
                "Tinayunan Hill",
                "Tumanay"
            ],
            "Valencia": [
                "Balugo",
                "Bongbong",
                "Bunga Mar",
                "Caidiocan",
                "East Balabag",
                "Liptong",
                "Luz",
                "Magsaysay",
                "Malabo",
                "Napacao",
                "North Poblacion",
                "Panangquilon",
                "Panglaya-an",
                "Pili",
                "Poblacion",
                "Puhagan",
                "South Balabag",
                "Tapon",
                "Tayapi"
            ],
            "Vallehermoso": [
                "Anahaw",
                "Bagawines",
                "Bago",
                "Bal-os",
                "Balingasag",
                "Bangcal",
                "Bangin",
                "Bantolinao",
                "Barangay I",
                "Barangay II",
                "Barangay III",
                "Barangay IV",
                "Barangay V",
                "Barangay VI",
                "Barangay VII",
                "Barangay VIII",
                "Barangay IX",
                "Barangay X",
                "Bongbong",
                "Bulod",
                "Cabatacan",
                "Cabugwang",
                "Cabayugan",
                "Calabnugan",
                "Cambaye",
                "Canlampus",
                "Cansumalig",
                "Cantupa",
                "Cantutang",
                "Cuba",
                "Doce",
                "Guba",
                "Kauswagan",
                "Lag-it",
                "Linao",
                "Lipayo",
                "Lut-od",
                "Mabunga",
                "Mag-aso",
                "Malilis",
                "Maloh",
                "Mantiquil",
                "Molocaboc",
                "Nalhub",
                "Napacao",
                "Nato",
                "Obat",
                "Odiong",
                "Pacuan",
                "Pagsa",
                "Panglaya-an",
                "Panglayahan",
                "Pangpang",
                "Poblacion",
                "Ponong",
                "Pook",
                "San Isidro",
                "San Jose",
                "Santo Niño",
                "Sua",
                "Talisay",
                "Tambak",
                "Tawin-tawin",
                "Tinayunan Beach",
                "Tinayunan Hill",
                "Togbongon",
                "Tugas",
                "Tulapos",
                "Uwayan",
                "Valencia",
                "Viga",
                "Villa Hermosa",
                "Villareal"
            ],
            "Zamboanguita": [
                "Bacong",
                "Bajau",
                "Bambulo",
                "Basak",
                "Batuan",
                "Bongbong",
                "Calango",
                "Cangmating",
                "Cangmating Poblacion",
                "Canluto",
                "Cansumalig",
                "Cawitan",
                "Ibabao",
                "Malongcay Dacu",
                "Maluay",
                "Malusay",
                "Mandilikit",
                "Maningcao",
                "Napo",
                "Poblacion",
                "Tandayag"
            ]

        };

        function populateBarangays() {
            const cityDropdown = document.getElementById('city/municipality');
            const barangayDropdown = document.getElementById('barangay');
            const selectedCity = cityDropdown.value;

            // Clear existing options
            barangayDropdown.innerHTML = '<option disabled selected>--select--</option>';

            // Populate barangays for the selected city/municipality
            if (selectedCity && barangayAddresses[selectedCity]) {
                barangayAddresses[selectedCity].forEach(barangay => {
                    const option = document.createElement('option');
                    option.value = barangay;
                    option.textContent = barangay;
                    barangayDropdown.appendChild(option);
                });
            }
        }

        // Listen for changes in the city/municipality dropdown
        document.getElementById('city/municipality').addEventListener('change', populateBarangays);

        // Initial population of barangays
        populateBarangays();
    </script>

    </html>
@endsection
