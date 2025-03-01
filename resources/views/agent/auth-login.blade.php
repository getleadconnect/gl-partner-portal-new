<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>GetLead | Partner Portal</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
    <link rel="shortcut icon" href="{{asset('assets/images/fav.png')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
    <!-- This css only for authentication page -->
	<link rel="stylesheet" href="{{asset('assets/toastr.2.1.3/toastr.2.1.3.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/authentication.css')}}">

   
</head>

<body id="kt_body" class="header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-secondary-enabled">

    <div class="d-flex flex-column flex-root">
        <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white"
            id="kt_login">

            <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto gsign-up"
                style="position: relative;">
                <div class="d-flex flex-column-fluid flex-center">
                    <div class="login-form login-signin main-login">
                        <form  method="POST" id="login-form" action="{{ route('agent.check') }}" >
						@csrf
                            <div class="pb-13 pt-lg-0 pt-5 mx-auto">
                                <img class="logo-mob mx-auto d-block" src="{{asset('assets/images/logo.svg')}}" width="65%">
                                <h3 class="sign-title text-center pt-5 pb-2">Login</h3>
                            </div>
                            <div class="form-group">
                                <label class="sign-label">Email address </label>
                                <input class="form-control form-control-solid h-auto" type="email"
                                    placeholder="email" name="email" id="email" autocomplete="off" required />
								@if($errors->has('email'))
									<label style="font-size:12px;color:red;margin:0px">{{$errors->first('email')}}</label>
									@endif
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between mt-n5">
                                    <label class="sign-label pt-3 ">Password</label>
                                </div>
                                <input class="form-control form-control-solid h-auto" type="password"
                                    placeholder="Type your password here" name="password" id="password" minlength=5 maxlength=30 autocomplete="off" required />
								@if($errors->has('password'))
									<label style="font-size:12px;color:red;margin:0px">{{$errors->first('email')}}</label>
									@endif
								@if(Session::get('fail'))
									<label style="font-size:12px;color:red;margin:0px">Invalid Credentials</label>
								@endif	
								
                                <a href="javascript:;"
                                    class="text-right text-hover-primary d-block mt-2 forgot-password pt-3  ">Forgot
                                    Password ?</a>
									
                            </div>
                            <div class="pb-lg-0 pb-5 sign-d-flex align-items-center w-100 mt-5 ">
                                <button type="submit" class="pt-2 pb-2 btn btn-primary font-weight-bolder font-size-h6 px-8 sign-btn d-block w-100 mt-5 mt-5 bold " style="color: #fff !important;font-weight: bold;">LOGIN</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <!-- rightside -->
            <div class="login-aside d-flex flex-column flex-row-auto mob-none" style="background:url(../assets/images/bg.png)">
                <div class="d-flex flex-column-auto flex-column">
                    <div class="container">

                        <div class="">
                            <div class="item">
                                <img src="{{asset('assets/images/chess-board.svg')}}" style="margin: auto;display: block;">
                                <h1 class="text-center text-white mt-2 pt-4">Make your move with <br>
                                    Strategic Partnerships</h1>
                                <p class="text-center mt-3">Collaborate, Innovate & Succeed Together
                                </p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/jquery-3.7.1.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/metismenujs/metismenujs.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/owl.carousel.min.js')}}"></script>
	<script src="{{asset('assets/toastr.2.1.3/toastr.2.1.3.js')}}"></script>
		
    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        })
    </script>

</body>

</html>