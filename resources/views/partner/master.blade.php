<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{ env('SITE_TITLE') }} | Getlead Partner Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Partner Portal for Getlead" name="description" />
    <meta content="Getlead" name="author" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/fav.png')}}">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/toastr.2.1.3/toastr.2.1.3.css')}}" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/sweetalert2/sweetalert2.min.css')}}">
	
	<link href="{{asset('assets/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('datatables.net/css/jquery.dataTables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('datatables.net/css/buttons.dataTables.min.css')}}">
		
	<link href="{{ asset('assets/intl-tel-input17.0.3/intlTelInput.min.css')}}" rel="stylesheet"/>

	
	@yield('style')
	<style>
	.text-left
	{
		text-align:left;
	}
	</style>
</head>
<body data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg">
<div id="layout-wrapper">
	
<header id="page-topbar" class="isvertical-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="javascript:;" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/white-logo.svg')}}" alt="Getlead Partner Portal Logo" width="175px">
                    </span>
                </a>
                <a href="javascript:;" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/white-logo.svg')}}" alt="Getlead Partner Portal Logo" width="175px">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- Search -->
            
                <div class="position-relative" style="padding-left:15px;">
                   <h5>Partner - Administration</h5>
                </div>
        </div>

        <div class="d-flex">
            <div class="dropdown d-inline-block d-lg-none">
                <button type="button" class="btn header-item" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-sm" data-feather="search"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0">
                    <form class="p-2">
                        <div class="search-box">
                            <div class="position-relative">
                                <input type="text" class="form-control rounded bg-light border-0" placeholder="Search...">
                                <i class="mdi mdi-magnify search-icon"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon" id="page-header-notifications-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-sm" data-feather="bell"></i>
                 <span class=" noti-dot bg-danger rounded-pill" id="notification-count">0</span>
            </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0 font-size-15"> Notifications</h5>
                            </div>
                            <div class="col-auto">
                                <a href="#!" id="mark_all_as_read" class="small"> Mark all as read</a>
                            </div>
                        </div>
                    </div>

					<div data-simplebar id="latest_ten_notification" style="max-height: 250px;overflow:hidden scroll;scrollbar-width: thin;" class="simplebar-scrollable-y">
					
						<!-- Notification content here -------------------->
															
					</div>

                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="{{ url('partner/notifications')}}">
                            <i class="uil-arrow-circle-right me-1"></i> <span>View More..</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{asset('assets/images/logo-icon1.svg')}}" alt="Header Avatar">
                </button>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <a class="dropdown-item" href="{{route('partner.settings')}}"><i class='bx bx-user-circle text-muted font-size-18 align-middle me-1'></i> <span class="align-middle">My Account</span></a>
                    <!--<a class="dropdown-item" href="help.php"><i class='bx bx-buoy text-muted font-size-18 align-middle me-1'></i> <span class="align-middle">Support</span></a>-->
					<div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('partner.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
					<i class='bx bx-log-out text-muted font-size-18 align-middle me-1'></i> 
					<span class="align-middle">Logout</span></a>
					<form action="{{ route('partner.logout') }}" id="logout-form" method="post">@csrf</form>
                </div>
            </div>
        </div>
    </div>
</header>


<div class="vertical-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="javascript:;" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{asset('assets/images/white-logo.svg')}}" alt="Getlead Partner Portal Logo" width="175px">
            </span>
        </a>

        <a href="javascript:;" class="logo logo-light">
            <span class="logo-lg">
                <img src="{{asset('assets/images/white-logo.svg')}}" alt="Getlead Partner Portal Logo" width="175px">
            </span>
            <span class="logo-sm">
                <img src="{{asset('assets/images/white-logo.svg')}}" alt="Getlead Partner Portal Logo" width="175px">
            </span>
        </a>
    </div>

    <div data-simplebar class="sidebar-menu-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li >
                    <a href="{{ route('partner.dashboard')}}" >
                        <i class="bx bx-tachometer icon nav-icon"></i>
                        <span class="menu-item " data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('partner.leads')}}" >
                        <i class="bx bx-user-circle icon nav-icon"></i>
                        <span class="menu-item" data-key="t-partners">My Leads</span>
                    </a>
                </li>
				
				<li>
                    <a href="{{ route('partner.payout-history')}}" >
                        <i class="bx bx-user-circle icon nav-icon"></i>
                        <span class="menu-item" data-key="t-partners">Payout History</span>
                    </a>
                </li>
				
				<li>
                    <a href="{{ route('partner.news')}}" >
                        <i class="bx bx-user-circle icon nav-icon"></i>
                        <span class="menu-item" data-key="t-partners">Latest News</span>
                    </a>
                </li>
				
				<li>
                    <a href="{{ route('partner.terms')}}" >
                        <i class="bx bx-user-circle icon nav-icon"></i>
                        <span class="menu-item" data-key="t-partners">About Program</span>
                    </a>
                </li>

               <li>
                    <a href="{{ route('partner.settings')}}">
                        <i class="bx bx-cog icon nav-icon"></i>
                        <span class="menu-item" data-key="t-settings">Settings</span>
                    </a>
                </li>
				
				
				
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>

<div class="main-content">

@yield('content')

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 text-left">
                    <script>document.write(new Date().getFullYear())</script> &copy; Getlead Partner Portal.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="https://getleadcrm.com/" target="_blank" class="text-reset">GetLead CRM</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
	
</div>


<!-- JAVASCRIPT -->
<script src="{{asset('assets/js/jquery-3.7.1.js')}}"></script>

<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/metismenujs/metismenujs.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>

<script src="{{asset('datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('datatables.net/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('datatables.net/js/jszip.min.js')}}"></script>
<script src="{{asset('datatables.net/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('datatables.net/js/buttons.print.min.js')}}"></script>

<script src="{{asset('assets/js/app.js')}}"></script>
<script  src="{{asset('assets/toastr.2.1.3/toastr.2.1.3.js')}}"></script>
<script src="{{asset('assets/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/sweetalert2/sweetalert2.min.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/dist/boxicons.min.js"></script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script src="{{asset('assets/intl-tel-input17.0.3/intlTelInput.min.js')}}"></script>



@stack('scripts')
<script>

$(document).ready(function()
{
	
getNotifications();

	function getNotifications()
	{
		$.ajax({
			url: "{{ route('partner.get-latest-notifications')}}",
			type: 'get',
			//data: 
			success: function(res)
			{
				$("#latest_ten_notification").html(res.data);
				$("#notification-count").html(res.noti_count);
			}
		});
	};


	$("#mark_all_as_read").click(function()
	{
		$.ajax({
			url: "{{ route('partner.set-notifications-as-read')}}",
			type: 'get',
			//data: 
			success: function(res)
			{
				toastr.success("Success.!");
				getNotifications();
			}
		});

	});


});

</script>
</body>
</html>