<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Staff Signup</title>
 
 <link rel="stylesheet" href="{{ asset('css/customer.css') }}">

 <link rel="preconnect" href="https://fonts.gstatic.com">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
 <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
 <!--Stylesheet-->


    </head>
    <body>
        <div>
           <div class="panel shadow1">
                <form method="POST" action="{{ route('registerStaff') }}">

                @if(Session::get('success'))
                  <div style="color:green" class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                
                @if(Session::get('fail'))
                  <div style="color:red" class="alert alert-danger">{{Session::get('fail')}}</div>
                @endif

                @csrf
                        <img src="{{ asset('images/logo1.png') }}" style="width:30%;">
                        <h2>Q Wedding Boutique Management System</h2>

                    <fieldset id="login-fieldset">
                        <input class="login" name="fname" type="textbox"  required   placeholder="First name" value="" >
                        <input class="login" name="lname" type="textbox"  required   placeholder="Last name" value="" >
                        <input class="login" name="username" type="textbox"  required   placeholder="Username" value="" >
                        <input class="login" name="email" type="email"  required   placeholder="Email" value="" >
                        <input style="color:black"class="login" name="password" type="password" required placeholder="Password" value="">
                        <input style="color:black" class="login" name="password_confirmation" type="password" required placeholder="Confirm Password" value="">
                    </fieldset>
                    @if ($errors->any())
                          <div class="alert alert-danger">
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li style="text-align:left; list-style-type: none; color:red; font-size: 10px">{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif
                    <!-- <br><a href="">or</a><br><br>   
                    <a href="{{ route ('google-auth') }}"><i class="fab fa-google" style="margin-right: 8px"></i>continue with google</a> -->
                    <button type="submit" >Sign Up</button>
                    <h6>Already have an account? <a href="{{ route('staff-login') }}" style="font-size:1em;">Log in</a></h6>
                </form>
            </div>
        </div>
    </body>
</html>