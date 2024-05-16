@extends ('layouts.customer')

@section ('content')

<body>
 
<section class="indivproducts" id="indivproducts">
    <div class="box-container">
                <div class="box">
                    <div class="image-carousel">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @if(isset($WeddingPackageImages[$weddingPackage->id]) && count($WeddingPackageImages[$weddingPackage->id]) > 0)
                                    
                                    @foreach($WeddingPackageImages[$weddingPackage->id] as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ $image->image_path }}" alt="{{ $weddingPackage->item }}">
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
                    <!-- for navigation -->
                    <div class="prev-arrow">&lt;</div>
                    <div class="next-arrow">&gt;</div>
                </div>
            </div>
        
    <div class="box-details">
        <div class="indiv-content">

                <h6>Products/{{$weddingPackage->category}}</h6>
                <h2>{{$weddingPackage->item}}</h2>

            <div class="price">₱{{$weddingPackage->price}}.00</div>

                <h4>Details:</h4>
                <span>{{$weddingPackage->description}}</span>

                <form method="POST" action="{{ route('WPBasket.store', ['id' => $weddingPackage->id]) }}">
                    @csrf

                    @if($user)
                        <input type="hidden" name="customer_id" value="{{ $user->id }}">
                    @endif
                        <input type="hidden" name="wedding_package_id" value="{{ $weddingPackage->id }}">
                        <input type="hidden" name="wedding_package_images_id" value="{{ $WeddingPackageImage->id }}">

                    @foreach ($productsByCategoryColors as $category => $products)
                        
                        <h4 style="text-transform: capitalize">{{ $category }}</h4>
                            @foreach ($products as $productName => $product)
                                <h2 hidden>{{ $productName }}</h2>

                                <div>

                                    <div class="add2cart-image">
                                        @foreach ($product['images'] as $image)
                                            <img src="{{ $image }}" alt="{{ $productName }}">
                                        @endforeach
                                    </div>

                                    <div style="display: flex; flex-wrap: wrap;">
                                        <input type="hidden" name="product_names[{{ $category }}]" value="{{ $productName }}">
                                        @foreach ($product['colors'] as $color)
                                            @php
                                                $isBarong = ($category === 'Barong');
                                                $isMotherDress = ($category === 'Mother Dress');
                                                $barongSelectedCount = isset($selectedColors['Barong']) ? count($selectedColors['Barong']) : 0;
                                                $motherDressSelectedCount = isset($selectedColors['Mother Dress']) ? count($selectedColors['Mother Dress']) : 0;
                                                $disabled = ($isBarong && $barongSelectedCount >= 2 && !in_array($color, $selectedColors['Barong'])) || ($isMotherDress && $motherDressSelectedCount >= 2 && !in_array($color, $selectedColors['Mother Dress'])) ? 'disabled' : '';
                                            @endphp
                                            <label>
                                                @if ($isBarong || $isMotherDress)
                                                    <input type="checkbox" name="selected_colors[{{ $category }}][]" value="{{ $color }}" class="color-checkbox" {{ $disabled }}>
                                                @else
                                                    <input type="radio" name="selected_colors[{{ $category }}]" value="{{ $color }}" class="color-radio">
                                                @endif
                                                    <p style="margin-right: 10px;">{{ $color }}</p>
                                            </label>
                                        @endforeach
                                    </div>

                                </div>
                            @endforeach
                    @endforeach

                    <!-- Submit button -->
                    <button style="margin-top:2em" type="submit" class="btn btn-primary">Add to Basket</button>
                </form>

        </div> 
    </div>
</section>

<!--products-->
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
</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.color-checkbox');
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                const category = checkbox.getAttribute('name').replace('selected_colors[', '').replace('][]', '');
                const checkedCount = document.querySelectorAll(`input[name="selected_colors[${category}][]"]:checked`).length;
                
                // Disable other checkboxes if the selected count is 2 for Barong or Mother Dress
                if (category === 'Barong' || category === 'Mother Dress') {
                    checkboxes.forEach(function (cb) {
                        if (cb !== checkbox && cb.getAttribute('name') === checkbox.getAttribute('name')) {
                            cb.disabled = (checkedCount >= 2 && !cb.checked);
                        }
                    });
                }
            });
        });
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

<script>
    function validateForm() {
        const checkboxes = document.querySelectorAll('.color-checkbox:checked');
        let valid = true;

        checkboxes.forEach(checkbox => {
            const category = checkbox.getAttribute('name').replace('selected_colors[', '').replace('][]', '');
            const checkedCount = document.querySelectorAll(`input[name="selected_colors[${category}][]"]:checked`).length;

            if ((category === 'Barong' || category === 'Mother Dress') && checkedCount > 2) {
                valid = false;
            }
        });

        if (!valid) {
            alert('Not all items are available');
            return;
        }

        document.getElementById('addToBasketForm').submit();
    }
</script>

@endsection