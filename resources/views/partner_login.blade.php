<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.usebootstrap.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="preconnect"   type="text/css" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    {{ Html::style('styles/gl_style.css') }}
</head>
<body>
    <section class="login-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 side-col">
                    <div class="kt-login__content">
                        <a class="kt-login__logo" href="#">
                            <img class="partner-logo" src="https://partner.getlead.co.uk/admin/assets/media/logos/getlead-logo.svg">
                        </a>
                        <h3 class="kt-login__title">Partner with Getlead</h3>
                        <span class="kt-login__desc">
                            Enable customer success and deliver outstanding business with the<br> help of the right set of CRM tools
                        </span>
                        <div class="kt-login__actions kt-switch-btn">
                            <button type="button" class="btn btn-outline-brand btn-pill" href="#sign-up-form">Be A Partner</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 side-col">
                    <div class="login-form-col">
                        <h3>Login To Your Account</h3>
                        <form  class="kt-form kt-form--fit kt-form--label-right login-form" id="login-form"action="{{ route('attempt-login-partner') }}" method="POST">
                            @csrf
                            <div class="form-group validate is-invalid">
                                <input class="" type="text" placeholder="Email" name="email" autocomplete="off" aria-describedby="email-error" aria-invalid="true" value="partner@glbilling.com"><div id="email-error" class="error invalid-feedback">This field is required.</div>
                            </div>
                            <div class="">
                                <input class="" type="Password" id="Password" placeholder="Password" name="password" >
                            </div>
                            
                            <div class="kt-login__actions ">
                                <button id="" class="">Partner Sign In</button>
                            </div>
                        </form>
                        
                        <form class="kt-form kt-form--fit kt-form--label-right login-form" id="sign-up-form">
                            <h3>Register Now</h3>
                            
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Name" id="name" name="name" value="" autocomplete="off" required="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="number" id="mobile" placeholder="Mobile Number" name="mobile" value="" autocomplete="off" required="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="company_name" placeholder="Company Name" name="company_name" value="" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="email" placeholder="Email" name="email" value="" autocomplete="off" required="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="website" id="website" placeholder="Website" name="website" value="" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="team_size" placeholder="Team size" name="team_size" value="" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <select placeholder="Country" name="country" id="country" class="form-control">
                                    <option value="0" selected="" disabled="">Select Country</option>
                                </select>
                                <input type="hidden" class="countrys" id="countrys" value="" name="countrys">
                            </div>
                            <div class="form-group">
                                <select placeholder="State" name="state" id="state" class="form-control">
                                    <option value="0" selected="" disabled="">Select State</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="city" placeholder="city" name="city" value="" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="pin_code" placeholder="pincode" name="pin_code" value="" autocomplete="off">
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
    <script  src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    {{ Html::script('scripts/gl_script.js') }}
</body>
</html>