<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
  <!-- <script type="text/javascript" src="{{ asset('scripts/customer-login.js') }}"></script> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <title> Staff Login</title> 

        <!-- Font online-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
      
<!--        Animate.css-->
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
                
                                
        <link rel="stylesheet" href="main.css" >
        
        <!-- Google JQuery CDN -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        

    </head>
    <body>
        <div>
           <div class="panel shadow1">
                <form  method="POST" action="{{ route('logmeinStaff') }}">
                @csrf
                        <img src="{{ asset('images/logo1.png') }}" style="width:30%;">
                    <h2>Q Wedding Boutique Management System</h2>

                    <label for="username"></label>
                        <input type="text" name="username" placeholder="username" id="username">

                    <label for="password"></label>
                        <input type="password" name="password" placeholder="Password" id="password">
                    
                        <!-- <a href="{{ route ('google-auth') }}"><i class="fab fa-google" style="margin-right: 8px"></i>continue with google</a> -->
                        
                        <div class="staff-login">
                            <button class="staff-login" type="submit" >Log In</button>
                        </div>
                    <h6>Don't have an account? <a href="{{ route('staff-signup') }}" style="font-size:1em;">Signup</a></h6>
                </form>
            </div>
        </div>
    </body>
</html>