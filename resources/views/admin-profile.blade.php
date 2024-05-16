@extends ('layouts.admin')


@section('admin-content')
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
        <a href="{{route('admin.admin-home')}}">
        <i class="far fa-calendar-check" ></i><span>Reservations</span>
        </a>
      </li> 
      <li class="sidebar-list-item">
        <a href="{{route('admin.admin-appointments')}}">
        <i class="fas fa-calendar-alt" ></i><span>Appointments</span>
        </a>
      </li>
      <li class="sidebar-list-item">
        <a href="{{route ('admin.admin-rented')}}">
        <i class="fas fa-tshirt" ></i><span>Rented</span>
        </a>
      </li>
      <li style="background-color: #f085c3; " class="sidebar-list-item">
        <a style="color:white " href="{{route('admin.admin-products')}}">
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

        <div class="iphone-staff-add">

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

            <form action="" class="form" method="POST">
                @csrf

                    <input type="hidden" name="customer_id" value="">

                <div class="address">
                    <h2 class="h2-app">Customer Profile</h2>

                    <div class="card-staff-add">
                        <address class="address">
                                <label for="">First Name:</label>
                                    <input type="text" name="first_name" class="user-name" value="">
                                <label for="">Last Name:</label>
                                    <input type="text" name="last_name" class="user-name" value="">
                                <label for="">Middle Name:</label>
                                    <input type="text" name="middle_name" class="user-name" value="">

                                <label for="suffix">Suffix:</label>
                                    <input type="text" name="suffix" class="user-name" value="">
                            <br><br>
                            <label for="number">Phone number</label><br>
                                <input id="phoneNumber" name="phone_number" class="user-name" type="tel" pattern="^\+63[0-9]*$" 
                                    maxlength="13" value=""><br>
                                    <label for="email">Email address</label><br>
                                        <input type="email" id="email" name="email" class="user-name" value=""><br><br>
                            Complete Address<br>
                            <label for="province">- Province</label>
                                <select class="address-app" id="province" name="province">
                                    <option disabled selected></option>
                                    <option value="">Negros Oriental</option>
                                </select>
                            <br><br>
                            <label for="city/municipality">- City/Municipality</label>
                                <select class="address-app" id="city/municipality" name="city_municipality">
                                    <option disabled selected></option>
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
                            <br><br>
                            <label for="barangay">- Barangay</label>
                            <select class="address-app" id="barangay" name="barangay">
                                <option disabled selected></option>
                                <option value=""></option>
                            </select>

                            <br><br>Change Password<br>
                                <label for="new_password">New Password</label><br>
                                    <input type="password" id="new_password" name="new_password" class="user-name"><br>
                                <label for="confirm_password">Confirm Password</label><br>
                                    <input type="password" id="confirm_password" name="confirm_password" class="user-name"><br>

                            <input type="checkbox" id="showPasswordCheckbox">
                                <label for="showPasswordCheckbox">Show Password</label>

                        </address>
                    </div>
                </div>

                    <br><br>

                <div class="button-container">
                    <button class="button button--full" type="submit"> Update Profile</button>
                </div>
                <br>
            </form>
        </div>
</div>
</body>
<script>
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const showPasswordCheckbox = document.getElementById('showPasswordCheckbox');

    showPasswordCheckbox.addEventListener('change', function() {
        const isChecked = this.checked;
        newPasswordInput.type = isChecked ? 'text' : 'password';
        confirmPasswordInput.type = isChecked ? 'text' : 'password';
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
