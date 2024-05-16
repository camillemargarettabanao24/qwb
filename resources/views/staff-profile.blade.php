@extends ('layouts.staff')


@section('contents')
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
      <li  class="sidebar-list-item">
        <a href="{{route('staff-products')}}">
        <i class="fas fa-box-open" ></i><span>Products</span>
        </a>
      </li>
      <!-- <li class="sidebar-list-item">
        <a href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
          <span>History</span>
        </a>
      </li> -->
      <li style="background-color: #f085c3; " class="sidebar-list-item">
      <a style="color:white " href="{{ route('staff-profile') }}">
          <i class="fas fa-user" ></i><span>Account</span>
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

            <form action="{{ route('staff-profile.update') }}" class="form" method="POST">
                @csrf
                @method('PUT')

                

                <div class="address">
                        <div class="profile-title">
                          <h2 class="h2-app">Staff Profile</h2>
                        </div>
                    <div class="card-staff-add">
                        <address class="address">
                            <label for="fname">First Name:</label>
                            <input style="text-transform: none"  type="text" name="fname" class="user-name" value="{{ $userStaff->fname }}"><br>
                            <label for="lname">Last Name:</label>
                            <input style="text-transform: none"  type="text" name="lname" class="user-name" value="{{ $userStaff->lname }}"><br>
                            <label for="username">Username:</label>
                            <input style="text-transform: none"  type="text" name="username" class="user-name" value="{{ $userStaff->username }}"><br>
                            <label for="email">Email:</label>
                            <input style="text-transform: none" type="email" name="email" class="user-name" value="{{ $userStaff->email }}"><br>

                            <br><br><strong><Chang></Chang>e Password</strong><br>
                            <label for="new_password">New Password</label><br>
                            <input type="password" id="new_password" name="new_password" class="user-name"><br>
                            <label for="new_password_confirmation">Confirm Password</label><br>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="user-name"><br>

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
    document.getElementById('showPasswordCheckbox').addEventListener('change', function() {
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const type = this.checked ? 'text' : 'password';
        newPasswordInput.type = type;
        confirmPasswordInput.type = type;
    });
</script>




    </html>
@endsection
