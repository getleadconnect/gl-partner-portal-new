<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('SITE_TITLE') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="preconnect"   type="text/css" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('landing/styles/gl_style.css')}}"/>
    <link rel="stylesheet" href="{{asset('landing/styles/custom.css')}}"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css">
</head>
<body>
    <section class="login-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 side-col">
                    <div class="kt-login__content">
                        <a class="kt-login__logo" href="{{url('/')}}">
                            <img class="partner-logo" src="/images/background/logo.svg" style="width:200px;">
                        </a>
                        <h3 class="kt-login__title">Partner with GETLEAD</h3>
                        <span class="kt-login__desc">
                            Welcome to our partner program portal! We are excited to have you join us as we work together to grow our businesses.
                        </span>
 
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 side-col">
                    <div class="login-form-col">
                        <form  class="kt-form kt-form--fit kt-form--label-right login-form" id="login-form"action="{{ route('agent.check') }}" method="POST">
						@csrf                        
						<h3>Login To Your Account</h3>
                            
                            <div class="form-group validate is-invalid">
                                <input class="" type="text" placeholder="Email" name="email" autocomplete="off" aria-describedby="email-error" aria-invalid="true" value=""><div id="email-error" class="error invalid-feedback">This field is required.</div>
                            </div>
                            <div class="">
                                <input class="" type="Password" id="Password" placeholder="Password" name="password" >
                            </div>

                            <div class="kt-login__actions ">
                                <button id="" class="">Log In As Agent</button>
                            </div>
                        </form>
						
						
                        <form action="{{ route('agent.create') }}" class="kt-form kt-form--fit kt-form--label-right login-form" method="post" id="sign-up-form">
						@csrf                        

							@if (Session::get('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            @if (Session::get('fail'))
                            <div class="alert alert-danger">
                                {{ Session::get('fail') }}
                            </div>
                            @endif

                            <h3>Register Now</h3>

                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Name" id="name" name="name" value="" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="number" id="mobile" placeholder="Mobile Number" name="mobile" value="" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="email" placeholder="Email" name="email" value="" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" id="password" placeholder="Password" name="password" value="" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" id="c_password" placeholder="Confirm Password" name="c_password" value="" autocomplete="off" required>
                            </div>
                            <div class="kt-login__actions kt-switch-btn-2">
                                <button id="kt_login_signup_submit" class="btn btn-brand btn-pill btn-elevate">Sign Up</button>
                                <button type="button" class="btn btn-outline-brand btn-pill sign-up-cancel" href="#login-form">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="{{ asset('landing/scripts/gl_script.js')}}"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	
</body>
</html>
