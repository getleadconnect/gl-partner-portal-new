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
	<link rel="stylesheet" href="{{asset('assets/toastr.2.1.3/toastr.2.1.3.css')}}">
	
    <!-- This css only for authentication page -->
    <link rel="stylesheet" href="{{asset('assets/css/authentication.css')}}">
	<link href="{{ asset('assets/intl-tel-input17.0.3/intlTelInput.min.css')}}" rel="stylesheet"/>
<style>
.iti__selected-flag
{
	height:44px !important;
}
</style>  
</head>

<body id="kt_body" class="header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-secondary-enabled">

    <div class="d-flex flex-column flex-root">
        <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white"
            id="kt_login">

            <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto gsign-up"
                style="position: relative;">
                <div class="d-flex flex-column-fluid flex-center">
                    <div class="login-form login-signin main-login">
					
					
					<div class="loading-outer" style="display:none;">
						  <span class="spinner-loading" style="top:50% !important;">
						  <label style="font-size:48px;color:red;"> <i class="fa fa-spinner fa-spin"></i> </label>
						  <h6 style="color:red;"> Please Wait.......</h6>
						  </span>
					</div>
					
                    <form method="post" id="signup-form" action="{{ route('partner.create') }}" autocomplete="off" >
					@csrf
                            
						<div class="pb-13 pt-lg-0 pt-5 mx-auto">
                            <img class="logo-mob mx-auto d-block" src="{{asset('assets/images/logo.svg')}}" width="65%">
                            <h3 class="sign-title text-center pt-5 pb-2">Register now</h3>
                        </div>
						
						<input type="hidden" name="agent_id" value="{{ $agent_id!=null ? $agent_id : 0 }}">

						<div class="form-group">
							<div class="d-flex justify-content-between mt-n5">
							<label class="sign-label">Name<span class="text-red">*</span> </label> </div>
								<input class="form-control form-control-solid h-auto mb-2" type="text"  placeholder="Your name" id="name" name="name" autocomplete="off" required />
							</div>
							
							<div class="form-group">
								<div class="d-flex justify-content-between mt-n5">
								<label class="sign-label">Email address<span class="text-red">*</span></label> </div>
								<input type="email" class="form-control form-control-solid h-auto mb-2"  placeholder="Email address" id="email" name="email" autocomplete="off" required />
							</div>
								
							<div class="form-group">
								<div class="d-flex justify-content-between mt-n5">
								<label class="sign-label">Mobile<span class="text-red">*</span> </label> </div>
								<input type="hidden" class="form-control" placeholder="" value="91" name="country_code"  id="country_code">
								<input type="tel" class="form-control form-control-solid h-auto mb-2"  placeholder="mobile"  style="width:350px;" id="mobile" name="mobile" minlength=10 autocomplete="off" required />
							</div>

							<div class="form-group">
								<div class="d-flex justify-content-between mt-n5">
								<label class="sign-label">Company name<span class="text-red">*</span> </label> </div>
								<input class="form-control form-control-solid h-auto mb-2" type="text"
									placeholder="Your company name" name="company_name" id="company_name" autocomplete="off" required />
							</div>
							
							<div class="form-group">
								<div class="d-flex justify-content-between mt-n5">
									<label class="sign-label ">Password<span class="text-red">*</span></label>
								</div>
								<div style="position:relative;">
                                  <input class="form-control form-control-solid h-auto" type="password"
                                    placeholder="Type your password here" name="password" id="password" minlength=6 maxlength=30 autocomplete="off" required />
									<span id="toggle_pwd" class="fa fa-fw field-icon-eye fa-eye mt-5"></span>
								</div>
							</div>
							
							<div class="form-group" style="margin-bottom:25px;">
								<div class="d-flex justify-content-between mt-n5">
									<label class="sign-label ">Re-enter Password<span class="text-red">*</span></label>
								</div>
								<div style="position:relative;">
                                  <input class="form-control form-control-solid h-auto" type="password"
                                    placeholder="Type your password here" name="conf_password" id="conf_password" minlength=6 maxlength=30 autocomplete="off" required />
									<span id="conf_toggle_pwd" class="fa fa-fw field-icon-eye fa-eye mt-5"></span>
								</div>
							</div> 
							
							<input type="checkbox" id="chkAcceptBox" class="check-box font-size-h6"  style="width:20px;height:20px;vertical-align:middle;margin-top:0px !important;">&nbsp;
							I agree the <a href="javascript:;" id="btnOffcanvas" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" style="color:blue !important;">terms & conditons</a>

							<div class="pb-lg-0 pb-5 sign-d-flex align-items-center w-100 mt-3 ">
								<button	id="btnRegister" class="pt-2 pb-2 btn btn-primary w-100 mt-3 bold " style="color: #fff !important;font-weight: bold;" disabled >REGISTER NOW</button>
							</div>

							<div class="help text-center pt-4">Already have an account?<a href="{{route('partner.login')}}"> Login</a></div>
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

	
	<div class="offcanvas offcanvas-end"  style="width:560px !important;" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
	    <div class="offcanvas-header">
		    <h5 id="offcanvasRightLabel">TERMS & CONDITIONS</h5>
			   <button type="button" class="button-close btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	    </div>
	    <div class="offcanvas-body">
		     <iframe src="{{url('agreement/agreement-1-10-2024.pdf')}}#toolbar=0&navpanes=0" style="width:100%;height:100%;"></iframe>
	    </div>
	</div>

    <script src="{{asset('assets/js/jquery-3.7.1.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/metismenujs/metismenujs.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/owl.carousel.min.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="{{asset('assets/toastr.2.1.3/toastr.2.1.3.js')}}"></script>
	<script src="{{asset('assets/intl-tel-input17.0.3/intlTelInput.min.js')}}"></script>
	
	 @if(Session::get('success'))
        <script>
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.success("{{Session::get('success')}}");
        </script>
        @endif

        @if(Session::get('fail'))
        <script>
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
                toastr.error("{{Session::get('fail')}}");
        </script>
        @endif
			
			
    <script>
		
	
	var phone_number = window.intlTelInput(document.querySelector("#mobile"), {
	  separateDialCode: true,
	  preferredCountries:["in"],
	  hiddenInput: "full_number",
	  utilsScript:"{{url('assets/intl-tel-input17.0.3/utils.js')}}"
	});
	
	
	$("#chkAcceptBox").click(function()
	{
		if($(this).is(':checked'))
		{
			$("#btnRegister").prop('disabled',false);
		}
		else
		{
			$("#btnRegister").prop('disabled',true);
		}
		
	});
	
	
	$("#btnRegister").click(function()
	{
		var code=phone_number.getSelectedCountryData()['dialCode'];
		$("#country_code").val(code);
		$(".loading-outer").css('display','block');
	});
	
	
	$("#toggle_pwd").click(function() 
	{
	  $(this).toggleClass("fa-eye fa-eye-slash");
	  var input = $("#password");
	  if (input.attr("type") === "password") {
		input.attr("type", "text");
	  } else {
		input.attr("type", "password");
	  }
	});
	
	
	$("#conf_toggle_pwd").click(function() 
	{
	  $(this).toggleClass("fa-eye fa-eye-slash");
	  var input = $("#conf_password");
	  if (input.attr("type") === "password") {
		input.attr("type", "text");
	  } else {
		input.attr("type", "password");
	  }
	});


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
		
	$("#signup-form").validate({
		
		rules:{
			password:{
				required:true,
				minlength:5,
				maxlength:30
			},
			conf_password:{
				required:true,
				equalTo:password,
			}
		}
		
	});	
	
	

    </script>

</body>

</html>