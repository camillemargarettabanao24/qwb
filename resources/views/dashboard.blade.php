<!DOCTYPE html>
<html>
<head>
<title>QWB Management System</title>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<script type="text/javascript" src="{{ asset('scripts/customer.js') }}"></script>
<script type="text/javascript" src="{{ asset('scripts/shopping-basket.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.0/main.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">


</head>
<body>

<!-- Navbar -->
<header>

<input type="checkbox" name="" id="toggle">
<label for="toggle" class="fas fa-bars"></label>
    <a href="{{ route('customer-home')}}" class="logo">QWB<span>.</span></a>

    <nav class="navbar">
        <a href="{{ route('customer-home') }}">Home</a>
        <a href="">About</a>
        <a href="">Contacts</a>
    </nav>

<!-- <a href="{{route('Logout')}}">Log out</a>     -->

 
<div class="profile-dropdown">
        <div style="margin-left:2em" onclick="toggle()" class="profile-dropdown-btn">
            <i style="padding-left:5em" class="fas fa-user-alt"></i>
                <a style="text-decoration:none; color:black; padding-right:5em"
                href="{{route('customer-login')}}">Log in</a>
        </div>

       
      </div>
</header>

</nav>

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
                    <a href="{{ route('customer-login')}}" class="fas fa-shopping-basket"></a>
                        <a href="#" class="fas fa-calendar-alt" onclick="showCalendarModal('{{ $product->item }}')"></a>
                    </div>
                </div>
                <div class="content">
                    <h3>{{$product->item}}</h3>
                    <div class="category" hidden>{{$product->category}}</div>
                    <div class="price">₱{{number_format($product->price,2, '.', ',')}}</div>
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
                            <a href="#" class="fas fa-calendar-alt" onclick="showCalendarModal('{{ $weddingPackageItem->item }}')"></a>
                    </div>

                </div>

                <div class="content">
                    <h3>{{$weddingPackageItem->item}}</h3>
                    <div class="category" >{{$weddingPackageItem->description}}</div>
                    <div class="price">₱{{number_format($weddingPackageItem->price,2, '.', ',')}}</div>
                </div>       

            </div>
            
 @endforeach      
           
</div>




    <!-- Calendar Modal -->
<div id="calendarModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeCalendarModal()">&times;</span>
        <h2>Availability Calendar</h2>
        <!-- Your calendar content goes here -->
        <!-- You can use the JavaScript to dynamically generate the calendar -->
    </div>
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
    // Function to show the calendar modal
function showCalendarModal(productName) {
    const modal = document.getElementById('calendarModal');
    const modalContent = modal.querySelector('.modal-content');
    // Clear any previous content
    modalContent.innerHTML = '';
    // Add the product name to the modal content
    modalContent.innerHTML += `<h2>${productName}</h2>`;
    // Here you can add your calendar content or any other content you want to display
    // For simplicity, let's just display a message
    modalContent.innerHTML += '<p>Calendar content goes here...</p>';
    // Show the modal
    modal.style.display = 'block';
}

// Function to close the calendar modal
function closeCalendarModal() {
    const modal = document.getElementById('calendarModal');
    // Hide the modal
    modal.style.display = 'none';
}

// Close the modal if the user clicks outside of it
window.onclick = function(event) {
    const modal = document.getElementById('calendarModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

</script>

</body>
</html>

