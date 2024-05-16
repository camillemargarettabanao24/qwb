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
      <li class="sidebar-list-item">
        <a  href="{{route('admin.admin-products')}}">
        <i class="fas fa-box-open" ></i><span>Products</span>
        </a>
      </li>
      <li class="sidebar-list-item">
      <a href="{{route('admin.reports')}}">
          <i class="fas fa-newspaper"></i><span>Reports</span>
        </a>
      </li>
      <li class="sidebar-list-item">
        <a href="#">
          <i class="fas fa-user"></i><span>Account</span>
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
                        <option disabled selected>User</option>
                    </select>
                </div>
                <div class="filter-button-wrapper">
                    <select class="action-button">
                        <option disabled selected>Activity</option>
                    </select>
                </div>
                <div class="filter-button-wrapper">
                    <select class="action-button">
                        <option disabled selected>Date</option>
                    </select>
                </div>
            </div>
        </div>
      <div class="products-area-wrapper tableView">
        <div class="products-header">
            <div class="staff-app-header">
                <span>User</span>
            </div>
            <div class="staff-app-header">
                <span>Activity</span>
            </div>
            <div class="staff-app-header">
                <span>Time Created</span>
            </div>
            <div class="staff-app-header">
                <span>Time Updated</span>
            </div>
        </div>

        
        @foreach ($activityLogs as $activity) 

            <div class="products-row">
                <button class="cell-more-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                        <circle cx="12" cy="12" r="1"/>
                        <circle cx="12" cy="5" r="1"/>
                        <circle cx="12" cy="19" r="1"/>
                    </svg>
                </button>
                <div class="product-cell description">
                    <span class="cell-label"></span>{{$activity->user}}
                </div>
                <div class="product-cell category">
                    <span class="cell-label"></span>{{$activity->activity}}
                </div>
                <div class="product-cell colors">
                    {{$activity->created_at}} <br>
                </div>
                <div class="product-cell stock">
                    <span class="cell-label" style="text-align:center"></span>{{$activity->updated_at}} <br>
                </div>
            </div>
        </form>

        @endforeach

    </div>
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

@endsection 
