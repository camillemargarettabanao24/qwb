@extends ('layouts.staff')

@section ('contents')

<div class="app-container">
  <div class="sidebar">
 
    <ul class="sidebar-list">
      <li  class="sidebar-list-item">
        <a href="{{route('staff-home')}}">
        <i class="far fa-calendar-check" ></i><span>Reservations</span>
        </a>
      </li>
      <li class="sidebar-list-item">
        <a href="{{route('staff-appointments')}}">
        <i class="fas fa-calendar-alt" ></i><span>Appointments</span>
        </a>
      </li>
      <li class="sidebar-list-item">
        <a href="{{route ('staff-rented')}}">
        <i class="fas fa-tshirt" ></i><span>Rented</span>
        </a>
      </li>
      <li style="background-color: #f085c3; "class="sidebar-list-item">
        <a style="color:white " href="{{route('staff-products')}}">
          <i class="fas fa-box-open" ></i><span>Products</span>
        </a>
      </li>
      <!-- <li class="sidebar-list-item">
        <a href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
          <span>History</span>
        </a>
      </li> -->
      <li class="sidebar-list-item">
      <a href="{{ route('staff-profile') }}">
          <i class="fas fa-user" ></i><span>Account</span>
        </a>
      </li>
    </ul>
    <div class="account-info">
     
    </div>
  </div>
<!-- Create Product Form -->
<div class="staff-add">

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

                <form action="{{ route('staff-products-add-wedding-package.store') }}" class="form" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="address">
                        <h2 class="h2-app">Add Wedding Package</h2>

                        <div class="card-staff-add">
                            <address class="address">
                                    <label for="item">Product Name:</label><br>
                                        <input type="text" class="staff-name" id="item" name="item" required><br>
                                    <label for="description">Description:</label><br>
                                        <textarea class="description-textarea" id="description" name="description" rows="5" cols="65" required></textarea><br>
                                    <label for="category">Category:</label><br>
                                        <input type="text" class="staff-name" id="category" name="category" required><br>

                                    <label for="price">Price:</label><br>
                                          <input type="number" class="staff-name" id="price" name="price" min="1" required><br>
                                <br><br>
                                    <label for="image_path">Product Images:</label><br>
                                              <input type="file" class="form-control-file" id="image_path" name="image_path[]" multiple required><br><br>
                                    
                                  <div id="image-preview" class="image-preview">
                                        <!-- Preview images will be displayed here -->
                                    </div>


                      <!-- Submit Button -->
                      <div class="button-container">
                            <button class="staff-add-product --full" type="submit"> Add Wedding Package</button>
                      </div>
            </div>
            <br>

        </form>
    </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("#image_path").addEventListener("change", function() {
        const previewContainer = document.querySelector("#image-preview");
        const files = this.files;

        previewContainer.innerHTML = "";

        // Loop through all uploaded files
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            // Read file as a data URL
            reader.readAsDataURL(file);

            reader.onload = function() {
                const image = new Image();
                image.src = reader.result;

                // Create a preview element for the image
                const previewElement = document.createElement("div");
                previewElement.classList.add("image-preview-item");
                previewElement.appendChild(image);
                
                previewContainer.appendChild(previewElement);
            };
        }
    });
});

</script>
<script>
    // Function to add new color input dynamically
    document.getElementById('addColor').addEventListener('click', function() {
        var colorInputsContainer = document.getElementById('colorInputs');
        var index = colorInputsContainer.children.length; // Get the current number of color inputs

        var newColorInput = document.createElement('div');
        newColorInput.className = 'form-group';
        newColorInput.innerHTML = '<label for="colors">Color ' + (index + 1) + '</label>' +
                                    '<input name="colors[' + index + '][color]" class="form-control" placeholder="Color Name">' +
                                    '<input name="colors[' + index + '][quantity]" class="form-control" type="number" placeholder="Quantity">' +
                                    '<input name="colors[' + index + '][price]" class="form-control" type="number" placeholder="Price">';

        colorInputsContainer.insertAdjacentHTML('beforeend', newColorInput.outerHTML); // Insert the new color input before the end of the container
    });

    // Function to add new accessory input dynamically
    document.getElementById('addAccessory').addEventListener('click', function() {
        var accessoryInputsContainer = document.getElementById('accessoryInputs');
        var index = accessoryInputsContainer.children.length; // Get the current number of accessory inputs

        var newAccessoryInput = document.createElement('div');
        newAccessoryInput.className = 'form-group';
        newAccessoryInput.innerHTML = '<label for="accessories">Accessory ' + (index + 1) + '</label>' +
                                        '<input name="accessories[' + index + '][accessory]" class="form-control" placeholder="Accessory Name">' +
                                        '<input name="accessories[' + index + '][quantity]" class="form-control" type="number" placeholder="Quantity">' +
                                        '<input name="accessories[' + index + '][price]" class="form-control" type="number" placeholder="Price">';

        accessoryInputsContainer.insertAdjacentHTML('beforeend', newAccessoryInput.outerHTML); // Insert the new accessory input before the end of the container
    });
</script>

@endsection