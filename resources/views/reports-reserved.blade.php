<!DOCTYPE html>
<html>
<head>
    <title>Reserved Items Report - May 2024</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .table-container {
            margin-top: 30px;
        }
        .summary {
            margin-top: 20px;
            font-weight: bold;
            text-align: right;
        }
        td{
            border: 1px solid black;
        }

        tr{
            border: 1px solid black;
        }
        thead .table-dark{
            border: 1px solid black;
        }

        .address{
            display:flex;
            align-items:left;
            line-height: 0.8;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #ddd !important;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.05);
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $title }}</h1>
        <p>as of {{ $date }}</p>
    </div>
        <br>
    <div class="address">
        <p>{{ $street }}</p>
        <p>{{ $city }}, {{ $province }} {{ $postal_code }}</p>
        <p>{{ $companyName }}</p>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Pick up Time</th>
                    <th>Reservation Date</th>
                    <th>Payment Method</th>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Payment Deposit</th>
                    <th>Total Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->id }}</td>
                    <td>{{ $reservation->customer->fname }} {{ $reservation->customer->lname }}</td>
                    <td>{{ $reservation->reservation_time }}</td>
                    <td>{{ date('F d, Y', strtotime($reservation->reservation_date)) }}</td>
                    <td>{{ $reservation->payment_method }}</td>
                    <td>{{ $reservation->account_name }}</td>
                    <td>{{ $reservation->account_number }}</td>
                    <td>{{$reservation->payment_deposit}}</td>
                    <td>{{ number_format($reservation->total_res_price, 2, '.', ',') }}</td>
                    <td>{{ $reservation->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="summary">
        <p>Total Reserved: {{ $reservedCount }}</p>
        <p>Total Pending: {{ $pendingCount }}</p>
        <p>Total Declined: {{ $declinedCount }}</p>
        <p>Total Ongoing: {{ $ongoingCount }}</p>
        <p>Total Returned: {{ $returnedCount }}</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Q Wedding Boutique. All rights reserved.</p>
    </div>

</body>
</html>
