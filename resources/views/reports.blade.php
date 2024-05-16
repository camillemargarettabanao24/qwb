@extends ('layouts.manager')

@section ('contentss')

<div class="app-container">
    <div class="sidebar">
    
    <ul class="sidebar-list">
    <li class="sidebar-list-item" >
        <a href="{{route('manager.manager-home')}}">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        <span>Reservations</span>
        </a>
    </li>
    <li class="sidebar-list-item" >
        <a href="{{route ('manager.manager-appointments') }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
        <span>Appointments</span>
        </a>
    </li>
    <li class="sidebar-list-item">
        <a href="{{route ('manager.manager-rented')}}">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
        <span>Rented</span>
        </a>
    </li>
    <li  class="sidebar-list-item">
        <a  href="{{route('manager.manager-products')}}">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
        <span>Products</span>
        </a>
    </li>
    <li class="sidebar-list-item" style="background-color: #f085c3; ">
        <a style="color:white" href="{{route('reports')}}">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        <span>Reports</span>
        </a>
    </li>
    <li class="sidebar-list-item">
        <a href="#">
        <i class="fas fa-user" style="margin-right: 1em"></i><span>Account</span>
        </a>
    </li>
    </ul>
    </div>

    <div class="container mt-5">
        <h1><strong>May 2024</strong></h1>
        <div class="row">
            <div class="col-12 col-md-3 mb-3">
                <div class="card" style="width: 20em; background-color: ">
                    <div class="card-body">
                        <h2 class="card-title">Pending</h2>
                        <p class="card-text">{{$pendingCount}}</p>
                        <a href="{{ route('reports') }}" class="card-link">Print Report</a>
                        <a href="{{ route('manager.manager-home') }}" class="card-link">View Reservation</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 mb-3">
                <div class="card" style="width: 20em; background-color: ">
                    <div class="card-body">
                        <h2 class="card-title">Reserved</h2>
                        <p class="card-text">{{$reservedCount}}</p>
                        <a href="{{ route('reports.reserved') }}" class="card-link">Print Report</a>
                        <a href="{{ route('manager.manager-home') }}" class="card-link">View Reservation</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 mb-3">
                <div class="card" style="width: 20em; background-color: ">
                    <div class="card-body">
                        <h2 class="card-title">Ongoing</h2>
                        <p class="card-text">{{$ongoingCount}}</p>
                        <a href="{{ route('reports') }}" class="card-link">Print Report</a>
                        <a href="{{ route('manager.manager-home') }}" class="card-link">View Reservation</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 mb-3">
                <div class="card" style="width: 20em; background-color: ">
                    <div class="card-body">
                        <h2 class="card-title">Returned</h2>
                        <p class="card-text">{{$returnedCount}}</p>
                        <a href="{{ route('reports') }}" class="card-link">Print Report</a>
                        <a href="{{ route('manager.manager-home') }}" class="card-link">View Reservation</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 mb-3">
                <div class="card" style="width: 20em; background-color: ">
                    <div class="card-body">
                        <h2 class="card-title">Declined</h2>
                        <p class="card-text">{{$declinedCount}}</p>
                        <a href="{{ route('reports') }}" class="card-link">Print Report</a>
                        <a href="{{ route('manager.manager-home') }}" class="card-link">View Reservation</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


@endsection 
