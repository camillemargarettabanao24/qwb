<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Login</title>
 
    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->

</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="POST" action="{{ route('logmein') }}">
    @csrf

        <img src="{{ asset('images/logo1.png') }}" style="width:30%; ">
        <h2>Q Wedding Boutique Management System</h2>

        <label for="username"></label>
            <input style="text-transform:none" type="text" name="username" placeholder="username" id="username">

        <label for="password"></label>
            <input type="password" name="password" placeholder="Password" id="password">

        <button type="submit" >Log In</button>

        <div class="social">
            <!-- <div class="go"><i class="fab fa-google"></i>  Google</div> -->
        </div>
        <h6>Don't have an account? <a href="{{ route('customer-signup') }}" style="font-size:1em;">Signup</a></h6>

    </form>
</body>
</html>

    </body>
</html>