<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>{{ env('SITE_TITLE') }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/fav.png')}}">
    <link rel="stylesheet" href="{{asset('landing/styles/landing/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{asset('landing/styles/landing/css/flaticon.css')}}" />

    <link rel="stylesheet" href="{{asset('landing/styles/landing/css/owl.carousel.min.css')}}" />
    <link rel="stylesheet" href="{{asset('landing/styles/landing/css/owl.theme.css')}}" />
    <link rel="stylesheet" href="{{asset('landing/styles/landing/css/lightgallery.css')}}" />
    <link rel="stylesheet" href="{{asset('landing/styles/landing/css/woocommerce.css')}}" />
   
    <link rel="stylesheet" href="{{asset('landing/styles/landing/style.css')}}" />
    <link rel="stylesheet" href="{{asset('landing/styles/landing/resp.css')}}" />
    <link rel="stylesheet" href="{{asset('landing/styles/landing/css/home.css')}}" />
    
    <!-- <link rel="stylesheet" href="css/royal-preload.css" /> -->
	<style>
	.ot-button
	{
		text-align:center;
		margin:auto;
		display:block;
	}
	</style>
</head>

<body class="royal_preloader">
    <div id="page" class="site">


        <header id="site-header" class="site-header header-static"> 
			<div class="container">
				<nav class="navbar navbar-expand-lg">
					<div id="site-logo" class="site-logo">
						<a href="javascript:;">
							<img src="assets/images/logo.svg" alt="" class="">
						</a>
					</div>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
						aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
						<i class="fa fa-bars" aria-hidden="true"></i>
					</button>
					<div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
						<div class="navbar-nav">
							{{-- <a class="nav-item nav-link active" href="#">Home <span
									class="sr-only">(current)</span></a> --}}

								<a class="nav-link login-btn" href="{{route('partner.login')}}" >Login</a>
							
						</div>
					</div>
				</nav>
			</div>

        </header>

        {{-- <header id="site-header" class="site-header header-static">
            <!-- Main Header start -->
            <div class="header-desktop">
                <div class="octf-main-header is-fixed">
                    <div class="container">

						


                        <div class="row">
                            <div class="col-sm-6 align-self-center">
                                <div id="site-logo" class="site-logo">
                                    <a href="#">
                                        <img src="images/background/logo.svg" alt="Progrisaas" class="">
                                    </a>
                                </div>
                            </div>
                         
                            <div class="col-sm-6">
                                <div class="octf-btn-cta justify-content-end">
                                    
                                </div>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header> --}}
		

        <section class="top-h1">
            <div class="container">
                <div class="space-150"></div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>Become a Getlead Partner</h2>
                        <p>Invest in outstanding startups, find investments for your business,<br>involve the best in
                            your ideas.</p>
                        <div class="space-10"></div>
                        <div class="space-5"></div>
                        <div class="ot-button">
                            <a href="{{route('partner.home')}}" class="octf-btn octf-btn-main">Let’s Get Started</a>
                        </div>
                        <div class="space-70"></div>
                        <div class="space-5"></div>
                        <div class="space-2"></div>
                        <img src="images/background/1.svg" alt="" width="50%">
                    </div>
                </div>
                <div class="space-90"></div>
            </div>
        </section>

        <section class="gl-services-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="ssub-yes">
                            <div class="ot-heading">
                                <!-- <span class="ot-heading__sub">Benefits</span> -->
                                <h2 class="ot-heading__title">Benefits for partners</h2>
                            </div>
                        </div>
                        <div class="space-40"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="ot-icon-box services-list-icon services-h1">
                            <div class="ot-icon-box__icon">
                                <img src="images/background/partners.png" width="60px">
                            </div>
                            <div class="space-4"></div>
                            <div class="ot-icon-box__content">
                                <h3 class="icon-box-title">Joint marketing and cross-promotion</h3>
                                <div class="space-3"></div>
                                <div class="icon-box-des">But I must explain to you how all this mistaken idea of
                                    denouncing.</div>
                            </div>
                        </div>
                        <div class="space-30 d-lg-none"></div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="ot-icon-box services-list-icon services-h1">
                            <div class="ot-icon-box__icon">
                                <img src="images/background/brand-image.png" width="60px">
                            </div>
                            <div class="space-4"></div>
                            <div class="ot-icon-box__content">
                                <h3 class="icon-box-title">Brand recognition and exposure with us</h3>
                                <div class="space-3"></div>
                                <div class="icon-box-des">Pleasure and praising pain was born and I will give you a
                                    complete.</div>
                            </div>
                        </div>
                        <div class="space-30 d-lg-none"></div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="ot-icon-box services-list-icon services-h1">
                            <div class="ot-icon-box__icon">
                                <img src="images/background/price-tag.png" width="60px">
                            </div>
                            <div class="space-4"></div>
                            <div class="ot-icon-box__content">
                                <h3 class="icon-box-title">Exclusive promotions and discounts</h3>
                                <div class="space-3"></div>
                                <div class="icon-box-des">Account of the system, and expound actual teachings of the
                                    great explorer.</div>
                            </div>
                        </div>
                        <div class="space-30 d-md-none"></div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="ot-icon-box services-list-icon services-h1 pr-4">
                            <div class="ot-icon-box__icon">
                                <img src="images/background/sales.png" width="60px">
                            </div>
                            <div class="space-4"></div>
                            <div class="ot-icon-box__content">
                                <h3 class="icon-box-title pr-lg-5">Increase in sales and revenue</h3>
                                <div class="space-3"></div>
                                <div class="icon-box-des">To take a trivial example, which of us ever undertakes
                                    laborious physical.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-50"></div>


            </div>
        </section>  



        <section class="offer-h1" style="margin-top: 50px;">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="ssub-yes">
                            <div class="ot-heading">
                                <!-- <span class="ot-heading__sub">What we offer</span> -->
                                <h2 class="ot-heading__title">Explore our partnership programs </h2>
                            </div>
                        </div>
                        <div class="space-30"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 offset-md-3 ">
                        <div class="box-offer offer-bg-1">
                            <h4 style="text-align:center;">Channel partners</h4>
                            <p class="mb-0">Companies that oversee the entire customer experience, from marketing and
                                sales to solution delivery and implementation.</p>
                            <div class="space-10"></div>
                            <div class="space-5"></div>
                            <ul class="none-style list-s1 mb-0">
                                <li>
                                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 11">
                                            <path
                                                d="M13.6554 2.15622C14.1149 1.66307 14.1149 0.863266 13.6554 0.369866C13.1962 -0.123289 12.4514 -0.123289 11.9919 0.369866L4.93262 7.95072L2.00788 4.80998C1.54864 4.31658 0.80384 4.31658 0.344601 4.80998C-0.114867 5.30313 -0.114867 6.10294 0.344601 6.59609L4.10098 10.6301C4.56045 11.1233 5.30502 11.1233 5.76449 10.6301L13.6554 2.15622Z">
                                            </path>
                                        </svg></span>
                                    <span>Lead generation and co-marketing opportunities</span>
                                </li>
                                <li>
                                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 11">
                                            <path
                                                d="M13.6554 2.15622C14.1149 1.66307 14.1149 0.863266 13.6554 0.369866C13.1962 -0.123289 12.4514 -0.123289 11.9919 0.369866L4.93262 7.95072L2.00788 4.80998C1.54864 4.31658 0.80384 4.31658 0.344601 4.80998C-0.114867 5.30313 -0.114867 6.10294 0.344601 6.59609L4.10098 10.6301C4.56045 11.1233 5.30502 11.1233 5.76449 10.6301L13.6554 2.15622Z">
                                            </path>
                                        </svg></span>
                                    <span>Discounts or incentives for volume purchases</span>
                                </li>
                                <li>
                                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 11">
                                            <path
                                                d="M13.6554 2.15622C14.1149 1.66307 14.1149 0.863266 13.6554 0.369866C13.1962 -0.123289 12.4514 -0.123289 11.9919 0.369866L4.93262 7.95072L2.00788 4.80998C1.54864 4.31658 0.80384 4.31658 0.344601 4.80998C-0.114867 5.30313 -0.114867 6.10294 0.344601 6.59609L4.10098 10.6301C4.56045 11.1233 5.30502 11.1233 5.76449 10.6301L13.6554 2.15622Z">
                                            </path>
                                        </svg></span>
                                    <span>Recognition or rewards for sales performance</span>
                                </li>
                                <li>
                                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 11">
                                            <path
                                                d="M13.6554 2.15622C14.1149 1.66307 14.1149 0.863266 13.6554 0.369866C13.1962 -0.123289 12.4514 -0.123289 11.9919 0.369866L4.93262 7.95072L2.00788 4.80998C1.54864 4.31658 0.80384 4.31658 0.344601 4.80998C-0.114867 5.30313 -0.114867 6.10294 0.344601 6.59609L4.10098 10.6301C4.56045 11.1233 5.30502 11.1233 5.76449 10.6301L13.6554 2.15622Z">
                                            </path>
                                        </svg></span>
                                    <span>Partner portal to access resources & track sales </span>
                                </li>
                            </ul>
                            <div class="space-40"></div>
                            <div class="ot-button" >
                                <a href="{{route('partner.home')}}" class="octf-btn octf-btn-second color-third">Become a Channel
                                    partners</a>
                            </div>
                            <div class="space-30"></div>
                            <div class="space-5"></div>
                            <div class="space-2"></div>
                        </div>
                    </div>
					
					{{-- <div class="col-lg-6">
                        <div class="box-offer offer-bg-2">
                            <h4>Referral partners</h4>
                            <p class="mb-0">Advocates and consultants with extensive connections to potential
                                clients.</p>
                            <div class="space-10"></div>
                            <div class="space-5"></div>
                            <ul class="none-style list-s1 mb-0">
                                <li>
                                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 11">
                                            <path
                                                d="M13.6554 2.15622C14.1149 1.66307 14.1149 0.863266 13.6554 0.369866C13.1962 -0.123289 12.4514 -0.123289 11.9919 0.369866L4.93262 7.95072L2.00788 4.80998C1.54864 4.31658 0.80384 4.31658 0.344601 4.80998C-0.114867 5.30313 -0.114867 6.10294 0.344601 6.59609L4.10098 10.6301C4.56045 11.1233 5.30502 11.1233 5.76449 10.6301L13.6554 2.15622Z">
                                            </path>
                                        </svg></span>
                                    <span>Increased revenue</span>
                                </li>
                                <li>
                                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 11">
                                            <path
                                                d="M13.6554 2.15622C14.1149 1.66307 14.1149 0.863266 13.6554 0.369866C13.1962 -0.123289 12.4514 -0.123289 11.9919 0.369866L4.93262 7.95072L2.00788 4.80998C1.54864 4.31658 0.80384 4.31658 0.344601 4.80998C-0.114867 5.30313 -0.114867 6.10294 0.344601 6.59609L4.10098 10.6301C4.56045 11.1233 5.30502 11.1233 5.76449 10.6301L13.6554 2.15622Z">
                                            </path>
                                        </svg></span>
                                    <span>New customers and markets </span>
                                </li>
                                <li>
                                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 11">
                                            <path
                                                d="M13.6554 2.15622C14.1149 1.66307 14.1149 0.863266 13.6554 0.369866C13.1962 -0.123289 12.4514 -0.123289 11.9919 0.369866L4.93262 7.95072L2.00788 4.80998C1.54864 4.31658 0.80384 4.31658 0.344601 4.80998C-0.114867 5.30313 -0.114867 6.10294 0.344601 6.59609L4.10098 10.6301C4.56045 11.1233 5.30502 11.1233 5.76449 10.6301L13.6554 2.15622Z">
                                            </path>
                                        </svg></span>
                                    <span>Expanded product/service offerings</span>
                                </li>
                                <li>
                                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 11">
                                            <path
                                                d="M13.6554 2.15622C14.1149 1.66307 14.1149 0.863266 13.6554 0.369866C13.1962 -0.123289 12.4514 -0.123289 11.9919 0.369866L4.93262 7.95072L2.00788 4.80998C1.54864 4.31658 0.80384 4.31658 0.344601 4.80998C-0.114867 5.30313 -0.114867 6.10294 0.344601 6.59609L4.10098 10.6301C4.56045 11.1233 5.30502 11.1233 5.76449 10.6301L13.6554 2.15622Z">
                                            </path>
                                        </svg></span>
                                    <span>Trust and credibility</span>
                                </li>

                                <li>
                                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 11">
                                            <path
                                                d="M13.6554 2.15622C14.1149 1.66307 14.1149 0.863266 13.6554 0.369866C13.1962 -0.123289 12.4514 -0.123289 11.9919 0.369866L4.93262 7.95072L2.00788 4.80998C1.54864 4.31658 0.80384 4.31658 0.344601 4.80998C-0.114867 5.30313 -0.114867 6.10294 0.344601 6.59609L4.10098 10.6301C4.56045 11.1233 5.30502 11.1233 5.76449 10.6301L13.6554 2.15622Z">
                                            </path>
                                        </svg></span>
                                    <span>Networking opportunities.</span>
                                </li>


                            </ul>
                            <div class="space-40"></div>
                            <div class="ot-button">
                                <a href="{{route('agent.home')}}" class="octf-btn octf-btn-main">Become a Referral Partner</a>
                            </div>
                            <div class="space-30"></div>
                        </div>
                    </div> --}}
					
					
                </div>
                <div class="space-100"></div>
            </div>
        </section>

        <footer id="site-footer" class="site-footer">
            <div class="container">

                <div class="space-40"></div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 mb-3 mb-md-0 align-self-center">
                        <p class="copyright text-center">Copyright © 2023 Getlead Analytics Pvt. Ltd. All Rights
                            Reserved.</p>
                    </div>
                    <!--  <div class="col-lg-5 col-md-4 text-md-right">
                   <ul class="ft-menu">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Use</a></li>
                    </ul>
                </div>-->
                </div>
                <div class="space-40"></div>
            </div>
        </footer><!-- #site-footer -->
    </div><!-- #page -->
    <a id="back-to-top" href="#" class="show"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
    <!-- jQuery -->



    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="{{ asset('landing/scripts/landing/js/jquery.min.js') }}"></script>
	
    <script src="{{ asset('landing/scripts/landing/js/lightgallery-all.min.js') }}"></script>
    <script src="{{ asset('landing/scripts/landing/js/jquery.isotope.min.js') }}"></script>
    <script src="{{ asset('landing/scripts/landing/js/owl.carousel.min.js') }}"></script>
   <script src="{{ asset('landing/scripts/landing/js/easypiechart.min.js') }}"></script>
    <script src="{{ asset('landing/scripts/landing/js/jquery.countdown.min.js') }}"></script>
   <script src="{{ asset('landing/scripts/landing/js/scripts.js') }}"></script>
   <script src="{{ asset('landing/scripts/landing/js/contact.js') }}"></script>
    
    <!-- <script src="js/royal_preloader.min.js"></script>
    <script>
        window.jQuery = window.$ = jQuery;
        (function($) {
            "use strict";
            //Preloader
            Royal_Preloader.config({
                mode: 'logo',
                logo: 'images/logo.svg',
                logo_size: [160, 75],
                showProgress: true,
                showPercentage: true,
                text_colour: '#000000',
                background: '#ffffff'
            });
        })(jQuery);
    </script>  -->



	<script>
		$(window).scroll(function () {
    if ($(this).scrollTop() > 50) {
        $('.site-header').addClass("fixed");
    } else {
        $('.site-header').removeClass("fixed");
    }
    if ($(this).scrollTop() < 49) {
        $('.site-header').removeClass("fixed");
    }
});
			
		</script>


</body>

</html>
