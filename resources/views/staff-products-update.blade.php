@extends ('layouts.staff')

@section ('contents')

<div class="app-container">
  <div class="sidebar">
 
    <ul class="sidebar-list">
      <li style="background-color: #f085c3; " class="sidebar-list-item">
        <a style="color:white " href="#">
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
      <li class="sidebar-list-item">
        <a href="{{route('staff-products')}}">
        <i class="fas fa-box-open" ></i><span>Products</span>
        </a>
      </li>
      <li class="sidebar-list-item">
      <a href="{{ route('staff-profile') }}">
          <i class="fas fa-user" ></i><span>Account</span>
        </a>
      </li>
    </ul>
    <div class="account-info">
     
    </div>
  </div>

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

                <form action="{{ route('products.update', ['id' => $product->id]) }}" class="form" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')

                  <div class="address">
                      <h2 class="h2-app">Update Product</h2>

                      <div class="card-staff-add">
                          <address class="address">
                              <label for="item">Product Name:</label><br>
                                  <input type="text" class="staff-name" id="item" name="item" value="{{ $product->item }}" required><br>
                              <label for="description" >Description:</label><br>
                                  <textarea style="text-transform: none" class="description-textarea" id="description" name="description" rows="5" cols="70" value="{{$product->description}}">{{ $product->description }}</textarea><br>
                              <label for="category">Category:</label><br>
                                  <input type="text" class="staff-name" id="category" name="category" value="{{ $product->category }}" required><br>
                              <label for="price">Price:</label><br>
                                  <input type="number" class="staff-name" id="price" name="price" value="{{ $product->price }}" min="1" required><br>
                              <br><br>
                              <label for="image_path">Product Images:</label><br>
                                  <input type="file" class="form-control-file" id="image_path" name="image_path[]" multiple><br><br>
                                      <!-- Image Preview -->
                                      @foreach($product->images as $images)
                                        <img style="width:15%; margin:1em" src="{{$images->image_path}}" alt="">
                                        <button type="submit" class="delete-button" data-image-id="{{ $images->id }}">Delete</button>
                                      @endforeach
                              
                              <h5>Image Preview:</h5><br>
                              <div id="image-preview" class="image-preview">
                                  <!-- Preview images will be displayed here --> 
                              </div>

                              <div class="container">
                                  <h4>Add Colors</h4>
                                  <div id="colorInputs">
                                      <!-- Existing color inputs -->
                                      @foreach($product->product_colors as $color)
                                      <div class="form-group">
                                          <label for="colors">Color:</label>
                                          <input name="colors[{{ $loop->index }}][color]" class="form-control" value="{{ $color->color }}" placeholder="Color Name">
                                          <input name="colors[{{ $loop->index }}][quantity]" class="form-control" type="number" value="{{ $color->quantity }}" placeholder="Quantity">
                                          <input name="colors[{{ $loop->index }}][price]" class="form-control" type="number" value="{{ $color->price }}" placeholder="Price">
                                      </div>
                                      @endforeach
                                  </div>
                                  <button id="addColor">Add Color</button>
                              </div>

                              <div class="container">
                                  <h4>Add Accessories</h4>
                                  <div id="accessoryInputs">
                                      <!-- Existing accessory inputs -->
                                      @foreach($product->product_accessories as $accessory)
                                      <div class="form-group">
                                          <label for="accessories">Accessory:</label>
                                          <input name="accessories[{{ $loop->index }}][accessory]" class="form-control" value="{{ $accessory->accessory }}" placeholder="Accessory Name">
                                          <input name="accessories[{{ $loop->index }}][quantity]" class="form-control" type="number" value="{{ $accessory->quantity }}" placeholder="Quantity">
                                          <input name="accessories[{{ $loop->index }}][price]" class="form-control" type="number" value="{{ $accessory->price }}" placeholder="Price">
                                      </div>
                                      @endforeach
                                  </div>
                                  <button id="addAccessory">Add Accessory</button>
                              </div>
                          </address>
                      </div>

                      <!-- Submit Button -->
                      <div class="button-container">
                          <button class="staff-add-product --full" type="submit"> Update Product</button>
                      </div>
                  </div>
              </form>

    </div>
</div>

<style>
  .delete-button {
      background-color: #ff6347; /* Red color for the delete button */
      color: #fff; /* White text color */
      border: none; /* Remove border */
      padding: 0.5em 1em; /* Padding around the button text */
      margin: 5px 0 0 10px; /* Add some space above the button */
      cursor: pointer; /* Change cursor to pointer on hover */
      border-radius: 5px; /* Add rounded corners */
  }

  .delete-button:hover {
      background-color: #ff483b; /* Darker red color on hover */
  }

  .delete-button:focus {
      outline: none; /* Remove default focus outline */
      box-shadow: 0 0 0 2px #ff6347; /* Add a red border when focused */
  }

</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to handle deletion of images
        function handleDeleteButtonClick(event) {
            const imageId = event.target.getAttribute("data-image-id");
            if (imageId) {
                // Send an AJAX request to delete the image from the server
                fetch(`/staff-products-delete/${imageId}`, { method: 'DELETE' })
                    .then(response => {
                        if (response.ok) {
                            console.log('Image deleted successfully.');
                            // Remove the container holding the image and delete button
                            event.target.closest(".image-container").remove();
                        } else {
                            console.error('Failed to delete image.');
                        }
                    })
                    .catch(error => console.error('Error deleting image:', error));
            }
        }

        // Event listener for delete buttons
        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("delete-button")) {
                handleDeleteButtonClick(event);
            }
        });

        // Event listener for file input change
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
                    previewElement.classList.add("image-container");
                    previewElement.innerHTML = `
                        <img style="width:20%" src="${reader.result}" alt="">
                        <button class="delete-button" data-image-id="${i}">Delete</button>
                    `;
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