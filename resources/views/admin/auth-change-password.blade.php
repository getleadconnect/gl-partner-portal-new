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
 
    <div class="container-fluid light">
    <div class="col-sm-12">
 
 <img class="logo-mob pt-2 pl-2 " src="{{asset('assets/images/logo-icon1.svg')}}" width="60"> 
 
    <div class="already">Already have an account? <a href="{{route('admin.login')}}">Login</a> </div> 
 </div>

</div>


</div>
</div>
    <div class="d-flex flex-column flex-root">
        
        <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white"
            id="kt_login">

            <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto gsign-up"
                style="position: relative;">
                <div class="d-flex flex-column-fluid flex-center">
                    <div class="login-form login-signin main-login">
                        <form class="form" method="post" action="{{route('admin.update-user-password')}}" novalidate="novalidate">
						@csrf
						
						<input type="hidden" name="user_email" id="user_email" value="{{$user_email}}" />
						
						
                            <h3 class="sign-title text-center pb-4 mb-0">Change password</h3>
                            <h6>Please proceed to change your password.</h6>
                            <div class="form-group">
                                <div class="d-flex justify-content-between mt-2 pt-2">
                                <label class="sign-label">Enter new password</label> </div>
                                <input class="form-control form-control-solid h-auto" type="text"
                                    placeholder="New password" name="new_password" id="new_password" autocomplete="off" required />
								@if($errors->has('new_password'))
									<label style="color:red;">{{$errors->first('new_password')}}</label>
								@endif
                            </div>
							<div class="form-group">
                                <div class="d-flex justify-content-between mt-2 pt-2">
                                <label class="sign-label">Re-Enter new password</label> </div>
                                <input class="form-control form-control-solid h-auto" type="text"
                                    placeholder="Confirm Password" name="conf_password" id="conf_password"  autocomplete="off" required />
								@if($errors->has('conf_password'))
									<label style="color:red;">{{$errors->first('conf_password')}}</label>
								@endif
								
								@if($errors->has('fail'))
								<label style="color:red;">{{$errors->first('fail')}}</label>
								@endif
									
                            </div>

                            <div class="pb-lg-0 pb-5 sign-d-flex align-items-center w-100 mt-5 ">
                                <button type="submit" class="pt-2 pb-2 btn btn-primary font-weight-bolder font-size-h6 px-8 sign-btn d-block w-100 mt-5 mt-5 bold " style="color: #fff !important;font-weight: bold;">CHANGE PASSWORD</button>
                            </div>

                           
                        </form>

                    </div>
                </div>
            </div>

            <!-- rightside -->
           
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/metismenujs/metismenujs.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/owl.carousel.min.js')}}"></script>
	
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