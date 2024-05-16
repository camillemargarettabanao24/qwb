<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
  <!-- <script type="text/javascript" src="{{ asset('scripts/customer-login.js') }}"></script> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <title> Customer Login</title> 

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
                <form class="login-form" method="POST" action="{{ route('logmein') }}">
                @csrf
                    <div class="panel-switch animated fadeIn">
                        <img src="{{ asset('images/logo.png') }}" style="width:30%; height: 30%; ">
                      
                    </div>

                    <h1 class="animated" id="title-login">QWB Management System</h1>
                    <fieldset id="login-fieldset">
                        <input class="login animated" name="username" type="textbox"  required   placeholder="Username" value="" >
                        <input class="login animated" name="password" type="password" required placeholder="Password" value="">
                    </fieldset>
                    <!-- <br><a href="">or</a><br><br>   
                    <a href="{{ route ('google-auth') }}"><i class="fab fa-google" style="margin-right: 8px"></i>continue with google</a> -->
                    <input type="submit" id="login-form-submit" class="login_form button animated" value="Log in">
                    <h6>Don't have an account? <a href="{{ route('customer-signup') }}" style="font-size:1em;">Signup</a></h6>
                </form>
            </div>
        </div>
    </body>
</html>