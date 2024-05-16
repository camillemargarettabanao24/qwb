<!DOCTYPE html>
<html>
<head>
<title>QWB Management System</title>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/customer-home.css') }}">
<link rel="stylesheet" href="{{ asset('css/customer-add2cart.css') }}">
<link rel="stylesheet" href="{{ asset('css/customer-details.css') }}">
<link rel="stylesheet" href="{{ asset('css/customer-receipt.css') }}">
<link rel="stylesheet" href="{{ asset('css/shopping-basket.css') }}">
<link rel="stylesheet" href="{{ asset('css/appointment.css') }}">
<link rel="stylesheet" href="{{ asset('css/appointment-create.css') }}">
<link rel="stylesheet" href="{{ asset('css/customer-profile.css') }}">
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
        <div onclick="toggle()" class="profile-dropdown-btn">
            @if($user)
            <i class="fas fa-user-alt"></i>
                <h3>{{ $user->fname }} {{$user->lname}}</h3>
            <i class="fas fa-angle-down"></i>
            @endif
        </div>

        <ul class="profile-dropdown-list">
          <li class="profile-dropdown-list-item">
            <a href="{{ route('customer-profile') }}">
              <i class="fas fa-user-alt"></i>
              Profile
            </a>
          </li>

          <li class="profile-dropdown-list-item">
            <a href="{{ route('shopping-basket') }}">
              <i class="fas fa-shopping-basket"></i>
              shopping basket
            </a>
          </li>

          <li class="profile-dropdown-list-item">
            <a href="{{ route('customer-reservations') }}">
              <i class="far fa-calendar-check"></i>
              Reservations
            </a>
          </li>

          <li class="profile-dropdown-list-item">
            <a href="{{ route('customer-appointments') }}">
              <i class="fas fa-calendar-alt"></i>
              Appointments
            </a>
          </li>

          <hr />

          <li class="profile-dropdown-list-item">
            <a href="{{route('Logout')}}">
              <i class="fas fa-sign-out-alt"></i>
              Log out
            </a>
          </li>
        </ul>
      </div>
</header>

</nav>

@yield('content')
</body>
</html>