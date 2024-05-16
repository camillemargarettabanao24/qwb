<!DOCTYPE html>
<html>
<head>
<title>QWB Management System</title>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('css/customer-home.css') }}">
<link rel="stylesheet" href="{{ asset('css/customer-profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/customer-details.css') }}">
<link rel="stylesheet" href="{{ asset('css/staff.css') }}">

<link rel="stylesheet" href="{{ asset('css/staff-home.css') }}">
<link rel="stylesheet" href="{{ asset('css/staff-header.css') }}">
<link rel="stylesheet" href="{{ asset('css/report.css') }}">
<script type="text/javascript" src="{{ asset('scripts/customer.js') }}"></script>
<script type="text/javascript" src="{{ asset('scripts/staff-home.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">



</head>
<body>

<!-- Navbar -->
<header>

<input type="checkbox" name="" id="toggle">
<label for="toggle" class="fas fa-bars"></label>
    <a href="{{ route('manager.manager-home')}}" class="logo">QWB<span>.</span></a>

    <nav class="navbar">
        <a href="{{ route('manager.manager-home') }}">Home</a>
        <a href="">About</a>
        <a href="">Contacts</a>
    </nav>

<!-- <a href="{{route('Logout')}}">Log out</a>     -->

 
<div class="profile-dropdown">
        <div onclick="toggle()" class="profile-dropdown-btn">
            @if($userManager)
                <i class="fas fa-user-alt"></i>
                    <h3>{{ $userManager->fname }} </h3>
                <i class="fas fa-angle-down"></i>
            @endif
        </div>

        <ul class="profile-dropdown-list">
          <li class="profile-dropdown-list-item">
            <a href="#">
              <i class="fas fa-user-alt"></i>
              Edit Profile
            </a>
          </li>

          <hr />

          <li class="profile-dropdown-list-item">
            <a href="{{route('Logout-manager')}}">
              <i class="fas fa-sign-out-alt"></i>
              Log out
            </a>
          </li>
        </ul>
      </div>
</header>

</nav>

@yield('contentss')
</body>
</html>